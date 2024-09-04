<?php

class UserModel extends Model
{
    protected $db;
    protected $table = "users";

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE user_id = :user_id";
        $args = [
            ":user_id" => $userId
        ];
        return (array) $this->db->getRow($sql, $args);
    }

    public function authUser($email, $password): ?array
    {
        $sql = "SELECT * FROM users WHERE email LIKE :email AND password = :password";
        $args = [
            ":email" => $email,
            ":password" => $password
        ];
        return (array) $this->db->getRow($sql, $args) ?: null;
    }

    public function registerUser($data)
    {
        $sql = "SELECT * FROM users WHERE email LIKE :email";
        $args = [
            ":email" => $data['email']
        ];
        if ((array) $this->db->getRow($sql, $args) ?: null) {
            return 0;
        }
        $sql = "INSERT INTO users (user_type, first_name, last_name, email, phone, password) VALUES (:user_type, :first_name, :last_name, :email, :phone, :password)";
        $result = $this->db->insert($sql, $data);
        return $result;
    }

    public function getAllUsers()
    {
        return (array) $this->db->getAll("SELECT * FROM users");
    }

    public function updateUser($userId, $data): ?array
    {
        foreach ($data as $key => $value) {
            $args = [];
            $args[":$key"] = $value;
            $sql = "UPDATE users SET $key = :$key WHERE user_id = :u";
            $args[':u'] = $userId;
            $this->db->rowCount($sql, $args);
        }
        return $this->getUserById($userId);
    }

    public function getCustomerById($id): ?array
    {
        $sql = "SELECT * FROM users JOIN customers ON users.user_id = customers.user_id WHERE users.user_id = ?";
        return (array) $this->db->getRow($sql, [$id]) ?: null;
    }

    public function getCustomerAddresses($id): ?array
    {
        $sql = "SELECT * FROM addresses WHERE customer_id = ?";
        return (array) $this->db->getAll($sql, [$id]) ?: null;
    }

    public function addAddress($data)
    {
        $sql = "INSERT INTO addresses (address_label, customer_id, address_line1, address_line2, city, state, postal_code, country, address_comment) VALUES (:address_label, :customer_id, :address_line1, :address_line2, :city, :state, :postal_code, :country, :address_comment)";
        return $this->db->insert($sql, $data);
    }
}

?>