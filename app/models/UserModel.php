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

    public function getUser($data): ?array
    {
        $sql = "SELECT * FROM users WHERE email LIKE :email AND password = :password";
        $args = [
            ":email" => $email,
            ":password" => $password
        ];
        return (array) $this->db->getRow($sql, $args) ?: null;
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
        return $this->db->insert($sql, $data);
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
}

?>