<?php

namespace Emsa\Route;

use \Anax\Common\AppInjectableInterface;
use \Anax\Common\AppInjectableTrait;

/**
 * A controller for the REM Server.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class RouteController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * Renders flat file content page.
     *
     * @return void
     */
    public function flatFileContent()
    {
        // Get the current route and see if it matches a content/file
        $path = $this->app->request->getRoute();
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
        $content = $this->app->textfilter->parse($content, ["yamlfrontmatter", "shortcode", "markdown", "titlefromheader"]);

        // Render a standard page using layout
        $this->app->view->add("default1/article", [
            "content" => $content->text
        ]);
        $this->app->renderPage($content->frontmatter);
    }



    /**
     * Renders info page for debugging purposes.
     *
     * @return void
     */
    public function dumpDebugInfo()
    {
        // Add views to a specific region
        $this->app->view->add("default1/info");

        // Render a standard page using layout
        $this->app->renderPage([
            "title" => "Info",
        ]);
    }



    /**
     * Renders 403 page.
     *
     * @return void
     */
    public function render403()
    {
        $title = "403 Forbidden";
        $this->app->view->add("default1/http_status_code", [
            "title" => $title,
            "message" => "You are not permitted to do this.",
        ]);
        $this->app->renderPage([
            "title" => $title,
        ], 403);
    }


    /**
     * Renders 404 page.
     *
     * @return void
     */
    public function render404()
    {
        $title = "404 Page not found";
        $this->app->view->add("default1/http_status_code", [
            "title" => "404 Page not found",
            "message" => "The page you are looking for is not here.",
        ]);
        $this->app->renderPage([
            "title" => $title,
        ], 404);
    }



    /**
     * Renders 500 page.
     *
     * @return void
     */
    public function render500()
    {
        $title = "500 Internal Server Error";
        $this->app->view->add("default1/http_status_code", [
            "title" => "500 Internal Server Error",
            "message" => "An unexpected condition was encountered.",
        ]);
        $this->app->renderPage([
            "title" => $title,
        ], 500);
    }
}
