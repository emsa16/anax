<?php
/**
 * Test route only
 */
$app->router->add("test/test", function () use ($app) {
    // Get the current route and see if it matches a content/file
    $path = $app->request->getRoute();
    $file1 = ANAX_INSTALL_PATH . "/content/${path}.md";
    $file2 = ANAX_INSTALL_PATH . "/content/${path}/index.md";

    $file = is_file($file1) ? $file1 : null;
    $file = is_file($file2) ? $file2 : $file;

    if (!$file) {
        return;
    }

    // Check that file is really in the right place
    $real = realpath($file);
    $base = realpath(ANAX_INSTALL_PATH . "/content/");
    if (strncmp($base, $real, strlen($base))) {
        return;
    }

    // Get content from markdown file
    $content = file_get_contents($file);
    $content = $app->textfilter->parse($content, ["yamlfrontmatter", "shortcode", "markdown", "titlefromheader"]);

    // Render a standard page using layout
    $app->view->add("test/test", [
        "content" => $content->text
    ]);
    $app->renderPage($content->frontmatter);
});
