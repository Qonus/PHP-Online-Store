<?php

class DeliveryMethodModel extends Model
{
    protected $db;
    protected $table = "delivery_methods";

    public function getAllDeliveryMethods()
    {
        return $this->db->getAll("SELECT * FROM delivery_methods");
    }
}
