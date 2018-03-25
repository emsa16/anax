<?php
if (!isset($editForm)) {
    $editForm = $form;
}
?>

<div class="comments">

    <h4>Skriv en kommentar</h4>
    <?= $this->renderView('comment/form', ["method" => "", "submit" => "Skicka", "postid" => $postid, "form" => $form, "parent_id" => 0]) ?>

    <h3>Kommentarer:</h3>
    <p>Sortera på <a href="<?= $this->url("comment/$postid?sort=best") ?>">bästa</a> |
                  <a href="<?= $this->url("comment/$postid?sort=old") ?>">äldsta</a> |
                  <a href="<?= $this->url("comment/$postid?sort=new") ?>">nyaste</a></p>

    <?= $this->renderView("comment/comment-tree", ["comments" => $comments, "textfilter" => $textfilter, "postid" => $postid, "action" => $action, "actionID" => $actionID, "form" => $editForm]) ?>
</div>
