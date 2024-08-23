<?php

class OrdersController extends Controller {
    public function __construct() {
        parent::__construct();
        require_once __DIR__ . '/../models/OrdersModel.php';
        $this->model = new OrdersModel();
    }

    public function index() {
        try {
            $orders = $this->model->getAllOrders();
            
            if ($orders) {
                $this->view->render('orders/orders', [
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
