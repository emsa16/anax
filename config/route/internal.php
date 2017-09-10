<?php
/**
 * Internal routes for error handling.
 */
$app->router->addInternal("403", [$app->routeController, "render403"]);

$app->router->addInternal("404", [$app->routeController, "render404"]);

$app->router->addInternal("500", [$app->routeController, "render500"]);
