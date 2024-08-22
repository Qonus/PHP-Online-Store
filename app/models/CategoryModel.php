<?php

class CategoryModel extends Model {
    protected $db;
    protected $table = "categories";

    public function getCategoryById($categoryId) {
        $sql = "SELECT * FROM categories WHERE category_id = :category_id";
        $args = [
            ":category_id" => $categoryId
        ];
        return (array)$this->db->getRow($sql, $args);
    }

    public function getCategoryByName($category_name) {
        $sql = "SELECT * FROM categories WHERE category_name = :category_name";
        $args = [
            ":category_name" => $category_name
        ];
        return (array)$this->db->getRow($sql, $args);
    }

    public function getAllCategories() {
        return $this->db->getAll("SELECT * FROM categories");
    }

    public function deleteCategory($categoryId) {
        $sql = "DELETE FROM categories WHERE category_id = :category_id";
        $args = [
            ":category_id" => $categoryId
        ];
        return $this->db->rowCount($sql, $args);
    }
}
