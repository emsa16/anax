<?php
/**
 * Routes for pages with comment sections.
 */

return [
    "routes" => [
        [
            "info" => "Start the session and initiate the REM Server.",
            "requestMethod" => null,
            "path" => "**",
            "callable" => ["remController", "anyPrepare"]
        ],
        [
            "info" => "Show the comments for requested post.",
            "requestMethod" => "get",
            "path" => "{postid:digit}",
            "callable" => ["commentController", "showComments"]
        ],
        [
            "info" => "Create a new item and add to the dataset",
            "requestMethod" => "post",
            "path" => "{postid:digit}/post",
            "callable" => ["commentController", "createComment"]
        ],
        [
            "info" => "Edit comment",
            "requestMethod" => "post",
            "path" => "{postid:digit}/edit",
            "callable" => ["commentController", "editComment"]
        ],
        [
            "info" => "Delete comment from dataset",
            "requestMethod" => "post",
            "path" => "{postid:digit}/delete",
            "callable" => ["commentController", "deleteComment"]
        ],
        [
            "info" => "Up-/downvote content",
            "requestMethod" => "post",
            "path" => "{postid:digit}/vote",
            "callable" => ["commentController", "voteComment"]
        ],
    ]
];

// /**  */
// $app->router->add("comment/**", [$app->remController, "anyPrepare"]);
//
// /** Show the comments for requested post. */
// $app->router->get("comment/{postid:digit}", [$app->commentController, "showComments"]);
//
// /** Create a new item and add to the dataset */
// $app->router->post("comment/{postid:digit}/post", [$app->commentController, "createComment"]);
//
// /** Edit comment */
// $app->router->post("comment/{postid:digit}/edit", [$app->commentController, "editComment"]);
//
// /** Delete comment from dataset */
// $app->router->post("comment/{postid:digit}/delete", [$app->commentController, "deleteComment"]);
