<?php

namespace Emsa\Comment;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for the comment system.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class CommentController implements InjectionAwareInterface
{
    use InjectionAwareTrait;



    public function showComments($postid)
    {
        $allComments = $this->di->rem->getDataset("comments");
        $postComments = $this->di->comment->getCommentsForPost($postid, $allComments);
        $hierarchedComments = $this->di->comment->buildTree($postComments);
        $baseUrl = $this->di->url->create("comment/$postid");
        $actionCommentDetails = $this->di->comment->getActionCommentDetails($this->di->request);
        $commentSection = $this->di->comment->buildCommentSection($hierarchedComments, $this->di->textfilter, $baseUrl, $actionCommentDetails["actionCommentId"], $actionCommentDetails["actionCommentMethod"]);
        $commentBox = $this->di->comment->buildNewCommentBox($baseUrl, $postid);
        $this->di->view->add("comments", [
            "commentBox" => $commentBox,
            "comments" => $commentSection,
            "postid" => $postid
        ], "main", 2);
    }



    public function createComment($postid)
    {
        $postValues = $this->di->request->getPost();
        $entry = $this->di->comment->compileNewComment($postValues);
        $item = $this->di->rem->addItem("comments", $entry);
        $commentid = $item["id"];
        $this->di->response->redirect("comment/$postid#$commentid");
    }



    public function editComment($postid)
    {
        $postValues = $this->di->request->getPost();
        $item = $this->di->rem->getItem("comments", (int)$postValues["id"]);
        $item["text"] = $postValues["text"];
        $item = $this->di->rem->upsertItem("comments", (int)$postValues["id"], $item);
        $commentid = $item["id"];
        $this->di->response->redirect("comment/$postid#$commentid");
    }



    public function deleteComment($postid)
    {
        $postValues = $this->di->request->getPost();
        if (isset($postValues["cancel"])) {
            $commentId = $postValues["id"];
            $this->di->response->redirect("comment/$postid#$commentId");
            exit;
        }
        $this->di->rem->deleteItem("comments", (int)$postValues["id"]);
        $this->di->response->redirect("comment/$postid");
    }
}
