<?php
/**
 * Routes for pages with comment sections.
 */

 /**  */
$app->router->add("comment/**", [$app->remController, "anyPrepare"]);

/** Show the comments for requested post. */
$app->router->get("comment/{postid:digit}", [$app->commentController, "showComments"]);

/** Create a new item and add to the dataset */
$app->router->post("comment/{postid:digit}/post", [$app->commentController, "createComment"]);

/** Edit comment */
$app->router->post("comment/{postid:digit}/edit", [$app->commentController, "editComment"]);

/** Delete comment from dataset */
$app->router->post("comment/{postid:digit}/delete", [$app->commentController, "deleteComment"]);
