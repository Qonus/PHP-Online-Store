<?php

class View
{
    protected $viewPath = __DIR__ . '/../views/';

    protected function getContent($path, $data)
    {
        extract($data);
        ob_start();
        include $path;
        $content = ob_get_clean();
        return $content;
    }

    public function render($view, $data = [])
    {
        $content = $this->getContent($this->viewPath . $view . '.php', $data);
        extract($data);
        include $this->viewPath . 'layouts/template.php';
    }

    public function notFound()
    {
        header("HTTP/1.1 404 Not Found");
        $this->render("layouts/not-found", [
            'title' => "Not Found",
        ]);
    }
}

?>