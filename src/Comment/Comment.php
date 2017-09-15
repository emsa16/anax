<?php

namespace Emsa\Comment;

/**
 * A controller for the comment system.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class Comment
{



    public function getCommentsForPost($postid, $allComments)
    {
        $postComments = [];

        foreach ($allComments as $comment) {
            if ($comment["post_id"] === $postid) {
                $postComments[$comment["id"]] = $comment;
            }
        }

        return $postComments;
    }



    public function buildTree(array &$elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id']] = $element;
                unset($elements[$element['id']]);
            }
        }
        return $branch;
    }



    public function getActionCommentDetails($request)
    {
        $deleteid = $request->getGet("deleteid");
        $editid = $request->getGet("editid");
        $replyid = $request->getGet("replyid");

        switch (true) {
            case $deleteid:
                $actionCommentId = $deleteid;
                $actionCommentMethod = "delete";
                break;
            case $editid:
                $actionCommentId = $editid;
                $actionCommentMethod = "edit";
                break;
            case $replyid:
                $actionCommentId = $replyid;
                $actionCommentMethod = "post";
                break;
            default:
                $actionCommentId = "";
                $actionCommentMethod = "";
                break;
        }
        return [
            "actionCommentId" => $actionCommentId,
            "actionCommentMethod" => $actionCommentMethod
        ];
    }



    public function buildCommentSection($comments, $textfilter, $baseUrl, $actionCommentId, $actionCommentMethod)
    {
        $commentSection = "";
        foreach ($comments as $comment) {
            $gravatar = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($comment["email"]))) . '.jpg?d=identicon&s=40';
            $points = ((int)$comment["upvote"] - (int)$comment["downvote"]);
            $text = $textfilter->parse($comment["text"], ["htmlentities", "markdown"]);
            $replyLink = "<a href='$baseUrl?replyid={$comment["id"]}#{$comment["id"]}'>svara</a>";
            $editLink = "<a href='$baseUrl?editid={$comment["id"]}#{$comment["id"]}'>redigera</a>";
            $deleteLink = "<a href='$baseUrl?deleteid={$comment["id"]}#{$comment["id"]}'>radera</a>";
            $commentSection .= "<div class='entry'><a name='{$comment["id"]}'></a>\n";
            $commentSection .= "<img src='$gravatar'>";
            $commentSection .= "<div class='stats'>$points points | by {$comment['email']} on {$comment['time']}</div>\n";
            if ($actionCommentId == $comment["id"] && $actionCommentMethod == "edit") {
                $commentSection .= $this->buildEditCommentBox($baseUrl, $comment["id"], $comment["text"]);
            } else {
                $commentSection .= "<div class='text'>{$text->text}</div>\n";
            }
            $commentSection .= "<div class='actions'>$replyLink | $editLink | $deleteLink</div>\n";

            if ($actionCommentId == $comment["id"]) {
                if ($actionCommentMethod == "post") {
                    $commentSection .= $this->buildNewCommentBox($baseUrl, $comment["post_id"], $comment["id"]);
                } else if ($actionCommentMethod == "delete") {
                    $commentSection .= $this->buildDelConfirmDialog($baseUrl, $comment["id"]);
                }
            }

            if (isset($comment["children"])) {
                $children = $this->buildCommentSection($comment["children"], $textfilter, $baseUrl, $actionCommentId, $actionCommentMethod);
                $commentSection .= "<div class='children'>\n$children</div>\n";
            }
            $commentSection .= "</div>\n";
        }
        return $commentSection;
    }



    public function buildNewCommentBox($baseUrl, $postid, $parentid = 0)
    {
        return <<<EOD
        <form method="post" action="$baseUrl/post">
            <input type="hidden" name="post_id" value="$postid">
            <input type="hidden" name="parent_id" value="$parentid">
            <label for="email">Mejladress</label>
            <input type="email" name="email" id="email" required>
            <br>
            <textarea name="text" rows="6" cols="60" required></textarea>
            <br>
            <input type="submit" value="Skicka kommentar">
        </form>
EOD;
    }



    public function buildEditCommentBox($baseUrl, $id, $text)
    {
        return <<<EOD
        <form method="post" action="$baseUrl/edit">
            <input type='hidden' name='id' value='$id'>
            <textarea name="text" rows="6" cols="60" required>$text</textarea>
            <br>
            <input type="submit" value="Spara kommentar">
        </form>
EOD;
    }



    public function buildDelConfirmDialog($baseUrl, $id)
    {
        return <<<EOD
        <form class='delConfirm' method="post" action="$baseUrl/delete">
            <input type='hidden' name='id' value='$id'>
            Är du säker på att du vill radera denna kommentar?
            <br>
            <input class='delButton' type="submit" name="delete" value="Ja">
            <input type="submit" name="cancel" value="Nej">
        </form>
EOD;
    }



    public function compileNewComment($entry)
    {
        $entry["post_id"] = (int)$entry["post_id"];
        $entry["parent_id"] = (int)$entry["parent_id"];
        $entry["time"] = date("Y-m-d");
        $entry["upvote"] = 0;
        $entry["downvote"] = 0;
        return $entry;
    }
}
