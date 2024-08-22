<?php

class ProductModel extends Model {
    protected $db;
    protected $table = "products";

    public function getProductById($productId) {
        $sql = "SELECT * FROM products WHERE product_id = :product_id";
        $args = [
            ":product_id" => $productId
        ];
        return (array)$this->db->getRow($sql, $args);
    }

    public function getLastProducts() {
        $sql = 'SELECT * FROM products ORDER BY product_id DESC LIMIT 3';
        return (array)$this->db->getAll($sql);
    }

    public function getAllProductsInCategory($category_id) {
        $sql = 'SELECT * FROM products WHERE category_id = :category_id';
        $args = [
            ':category_id' => $category_id
        ];
        return (array)$this->db->getAll($sql, $args);
    }

    public function getAllProducts() {
        return (array)$this->db->getAll("SELECT * FROM products");
    }

    public function createProduct($data) {
        $sql = "INSERT INTO products (name, description, price, stock) VALUES (:name, :description, :price, :stock)";
        return $this->db->insert($sql, $data);
    }

    public function updateProduct($productId, $data) {
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, stock = :stock WHERE product_id = :product_id";
        return $this->db->rowCount($sql, $data);
    }

    public function deleteProduct($productId) {
        $sql = "DELETE FROM products WHERE product_id = :product_id";
        $args = [
            ":product_id" => $productId
        ];
        return $this->db->rowCount($sql, $args);
    }
}
