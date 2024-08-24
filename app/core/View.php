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
        include $this->viewPath . 'layouts/template.php';
    }
}

?>