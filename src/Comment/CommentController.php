<?php

namespace Emsa\Comment;

use \Anax\Common\AppInjectableInterface;
use \Anax\Common\AppInjectableTrait;

/**
 * A controller for the comment system.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class CommentController implements AppInjectableInterface
{
    use AppInjectableTrait;



    public function showComments($postid)
    {
        $allComments = $this->app->rem->getDataset("comments");
        $postComments = $this->app->comment->getCommentsForPost($postid, $allComments);
        $hierarchedComments = $this->app->comment->buildTree($postComments);
        $baseUrl = $this->app->url->create("comment/$postid");
        $actionCommentDetails = $this->app->comment->getActionCommentDetails($this->app->request);
        $commentSection = $this->app->comment->buildCommentSection($hierarchedComments, $this->app->textfilter, $baseUrl, $actionCommentDetails["actionCommentId"], $actionCommentDetails["actionCommentMethod"]);
        $commentBox = $this->app->comment->buildNewCommentBox($baseUrl, $postid);
        $this->app->view->add("comments", [
            "commentBox" => $commentBox,
            "comments" => $commentSection,
            "postid" => $postid
        ], "main", 2);
    }



    public function createComment($postid)
    {
        $postValues = $this->app->request->getPost();
        $entry = $this->app->comment->compileNewComment($postValues);
        $item = $this->app->rem->addItem("comments", $entry);
        $commentid = $item["id"];
        $this->app->redirect("comment/$postid#$commentid");
    }



    public function editComment($postid)
    {
        $postValues = $this->app->request->getPost();
        $item = $this->app->rem->getItem("comments", (int)$postValues["id"]);
        $item["text"] = $postValues["text"];
        $item = $this->app->rem->upsertItem("comments", (int)$postValues["id"], $item);
        $commentid = $item["id"];
        $this->app->redirect("comment/$postid#$commentid");
    }



    public function deleteComment($postid)
    {
        $postValues = $this->app->request->getPost();
        if (isset($postValues["cancel"])) {
            $commentId = $postValues["id"];
            $this->app->redirect("comment/$postid#$commentId");
            exit;
        }
        $this->app->rem->deleteItem("comments", (int)$postValues["id"]);
        $this->app->redirect("comment/$postid");
    }
}
