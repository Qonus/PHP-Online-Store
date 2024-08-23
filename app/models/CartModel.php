<?php

class CartModel extends Model {
    protected $db;
    protected $table = "cart";

    public function getCart($userId): ?array {
        $sql = "SELECT user_id, cart.product_id, product_name, price, quantity, price * quantity AS 'total' FROM cart JOIN products ON cart.product_id = products.product_id WHERE user_id = :user_id";
        $args = [
            ":user_id" => $userId
        ];
        return (array)$this->db->getAll($sql, $args) ?: null;
    }

    public function getCartProduct($userId, $productId) {
        $sql = "SELECT * FROM cart WHERE user_id = :u AND product_id = :p";
        $args = [
            ":u" => $userId,
            ":p" => $productId,
        ];
        return (array)$this->db->getRow($sql, $args);
    }

    public function addToCart($userId, $productId, $quantity = 1): bool {
        $sql = "SELECT * FROM cart WHERE user_id = :u AND product_id = :p";
        $args = [
            ":u" => $userId,
            ":p" => $productId,
        ];
        $isInCart = $this->db->rowCount($sql, $args) > 0;
        if ($isInCart) {
            $quantity += getCartProduct($userId, $productId)['quantity'];
            return $this->updateQuantity($userId, $productId, $quantity);
        } else {
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:u, :p, :q)";
            $args = [
                ":u" => $userId,
                ":p" => $productId,
                ":q" => $quantity
            ];
            return $this->db->execute($sql, $args);
        }
        return $this->db->execute($sql, $args);
    }

    public function removeFromCart($userId, $productId): bool {
        $sql = "DELETE FROM cart WHERE user_id = :u AND product_id = :p";
        $args = [
            ":u" => $userId,
            ":p" => $productId
        ];
        return $this->db->execute($sql, $args);
    }

    public function updateQuantity($userId, $productId, $quantity): bool {
        if ($quantity < 1) {
            return $this->removeFromCart($userId, $productId);
        } else {
            $sql = "UPDATE cart SET quantity = :q WHERE user_id = :u AND product_id = :p";
            $args = [
                ":q" => $quantity,
                ":u" => $userId,
                ":p" => $productId
            ];
            return $this->db->execute($sql, $args);
        }
    }

    public function clearCart($userId): bool {
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $args = [$userId];
        return $this->db->execute($sql, $args);
    }
}