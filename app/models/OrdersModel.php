<?php

class OrdersModel extends Model {
    protected $db;
    protected $table = "orders";

    public function getOrderById($orderId) {
        $sql = "SELECT * FROM orders WHERE order_id = :order_id";
        $args = [
            ":order_id" => $orderId
        ];
        return (array)$this->db->getRow($sql, $args);
    }

    public function getAllOrders() {
        return $this->db->getAll("SELECT * FROM orders");
    }

    public function deleteOrder($orderId) {
        $sql = "DELETE FROM orders WHERE order_id = :order_id";
        $args = [
            ":order_id" => $orderId
        ];
        return $this->db->rowCount($sql, $args);
    }
}
