<?php

class View {
    protected $viewPath = __DIR__ . '/../views/';
    
    public function render($view, $data = []) {
        extract($data); // Преобразуем массив в переменные
        ob_start();
        include $this->viewPath . $view . '.php';
        $content = ob_get_clean();
        include $this->viewPath . 'layouts/template.php'; // Главный шаблон
    }
}