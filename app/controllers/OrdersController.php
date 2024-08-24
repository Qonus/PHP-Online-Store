<?php

require_once __DIR__ . '/../controllers/UserController.php';
class OrdersController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        require_once __DIR__ . '/../models/OrdersModel.php';
        $this->model = new OrdersModel();
    }

    public function index()
    {
        try {
            $orders = $this->model->getAllOrders();

            if ($orders) {
                $this->profileView->render('orders', [
                    'title' => 'Orders',
                    'orders' => $orders,
                ]);
            } else {
                echo "Orders not found.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
