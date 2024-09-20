<?php

class OrderModel extends UserModel
{
    protected $db;
    protected $table = "orders";

    public function getOrderById($order_id)
    {
        $sql = "SELECT * FROM orders WHERE order_id = :order_id";
        $args = [
            ":order_id" => $order_id
        ];
        return (array) $this->db->getRow($sql, $args);
    }

    public function getAllByUserIdOrders($user_id)
    {
        $sql = "SELECT * FROM orders WHERE customer_id = :user_id";
        $args = [
            ":user_id" => $user_id
        ];
        return $this->db->getAll($sql, $args);
    }

    public function getAllOrderDetails($order_id)
    {
        $sql = "SELECT p.product_id, p.product_name, od.quantity, od.unit_price, od.total_price FROM order_details od JOIN products p ON od.product_id = p.product_id WHERE od.order_id = :order_id";
        $args = [
            ":order_id" => $order_id
        ];
        return $this->db->getAll($sql, $args);
    }

    public function getAllOrders()
    {
        $sql = "SELECT * FROM orders";
        return $this->db->getAll($sql);
    }

    public function createOrder($user_id)
    {
        $sql = "CALL create_order(:u)";
        $args = [
            ":u" => $user_id
        ];
        $this->db->execute($sql, $args);
        return 1;
    }

    public function deleteOrderDetails($order_id)
    {
        $sql = "DELETE FROM order_details WHERE order_id = :order_id";
        $args = [
            ":order_id" => $order_id
        ];
        return $this->db->rowCount($sql, $args);
    }

    public function deleteOrder($order_id)
    {
        $this->deleteOrderDetails($order_id);

        $sql = "DELETE FROM orders WHERE order_id = :order_id";
        $args = [
            ":order_id" => $order_id
        ];
        return $this->db->rowCount($sql, $args);
    }
}
