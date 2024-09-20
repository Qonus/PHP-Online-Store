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
        $sql = "SELECT salt FROM users WHERE email LIKE ?";
        $salt = (array)$this->db->getRow($sql, [$email]);

        $sql = "SELECT * FROM users WHERE email LIKE :email AND password = :password";
        $args = [
            ":email" => $email,
            ":password" => SHA1(SHA1($password) . $salt["salt"])
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

    public function getAllUsers($roles = [])
    {
        $sql = "SELECT * FROM users";
        $args = [];
        if (!empty($roles)) {
            $sql .= " WHERE";
        }
        foreach ($roles as $role) {
            if ($roles[0] != $role) {
                $sql .= " OR";
            }
            $sql .= " user_type = :$role";
            $args[":$role"] = $role;
        }
        return (array) $this->db->getAll($sql, $args);
    }

    public function updateUser($userId, $data): ?array
    {
        foreach ($data as $key => $value) {
            if ($key == "email") {
                $sql = "SELECT * FROM users WHERE email LIKE :email";
                $args = [
                    ":email" => $value,
                ];
                if ((array) $this->db->getRow($sql, $args) ?: null) {
                    return null;
                }
            }
            $args = [];
            $args[":$key"] = $value;
            $sql = "UPDATE users SET $key = :$key WHERE user_id = :u";
            $args[':u'] = $userId;
            $this->db->rowCount($sql, $args);
        }
        return $this->getUserById($userId);
    }


    // CUSTOMER
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

    public function updateCustomer($user_id, $data): ?array
    {
        foreach ($data as $key => $value) {
            $args = [];
            $args[":$key"] = $value;
            $sql = "UPDATE customers SET $key = :$key WHERE user_id = :user_id";
            $args[':user_id'] = $user_id;
            $this->db->rowCount($sql, $args);
        }
        return $this->getCustomerById($user_id);
    }


    // ADDRESS
    public function getAddressById($address_id)
    {
        $sql = "SELECT * FROM addresses WHERE address_id = :address_id";
        $args = [
            ":address_id" => $address_id
        ];
        return (array) $this->db->getRow($sql, $args);
    }

    public function getDefaultAddressByCustomerId($customer_id)
    {
        $sql = "SELECT a.address_id, a.address_label FROM customers c JOIN addresses a ON a.address_id = c.default_address_id WHERE c.user_id = :customer_id";
        $args = [
            ":customer_id" => $customer_id
        ];
        $result = $this->db->getRow($sql, $args);
        return (array) $result;
    }

    public function getAddressByAddressLabel($customer_id, $address_label)
    {
        $sql = "SELECT a.address_id, a.address_label FROM customers c JOIN addresses a ON a.customer_id = c.user_id WHERE c.user_id = :customer_id AND a.address_label = :address_label";
        $args = [
            ":customer_id" => $customer_id,
            ":address_label" => $address_label,
        ];
        return (array) $this->db->getRow($sql, $args);
    }

    public function addAddress($data)
    {
        $sql = "INSERT INTO addresses (address_label, customer_id, address_line1, address_line2, city, state, postal_code, country, address_comment) VALUES (:address_label, :customer_id, :address_line1, :address_line2, :city, :state, :postal_code, :country, :address_comment)";
        return $this->db->insert($sql, $data);
    }

    public function removeAddress($address_id)
    {
        $args = [
            ":address_id" => $address_id
        ];
        $sql = "UPDATE customers SET default_address_id = NULL WHERE default_address_id = :address_id";
        $this->db->execute($sql, $args);
        $sql = "DELETE FROM addresses WHERE address_id = :address_id";
        return $this->db->execute($sql, $args);
    }

    public function updateAddress($address_id, $data)
    {
        foreach ($data as $key => $value) {
            $args = [];
            $args[":$key"] = $value;
            $sql = "UPDATE addresses SET $key = :$key WHERE address_id = :address_id";
            $args[':address_id'] = $address_id;
            $this->db->rowCount($sql, $args);
        }
        return $this->getAddressById($address_id);
    }
}

?>