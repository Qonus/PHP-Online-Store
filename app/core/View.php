<?php

class View {
    protected $viewPath = __DIR__ . "/../views";

    public function render(String $view, array $data = []) {
        extract($data);
        ob_start();
        include "{$this->viewPath}/{$view}.php";
        $content = ob_get_clean();
        include "{$this->viewPath}/layouts/body.php";
    }
}

?>