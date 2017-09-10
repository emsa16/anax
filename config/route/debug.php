<?php
/**
 * Routes to ease development and debugging.
 */


/**
 * Dump general information
 */
$app->router->add("debug/info", [$app->routeController, "dumpDebugInfo"]);
