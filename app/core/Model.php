<?php

abstract class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getData() {
        // Реализация по умолчанию или можно сделать абстрактным методом
    }
}
