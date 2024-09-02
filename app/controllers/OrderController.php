<?php

require_once __DIR__ . '/../controllers/UserController.php';
class OrderController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        require_once __DIR__ . '/../models/OrderModel.php';
        $this->model = new OrderModel();
    }

    public function checkout()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // $payment_method = $_POST["payment_method"];
            // $address = $_POST["address"];
            $this->model->createOrder($_SESSION['user']['user_id']);
            header("Location: /checkout/confirm");
            return;
            // if ($order_id) {
            //     //$_SESSION['order'] = $this->model->getOrderById($order_id);
            // }
        }
        $this->view->render('checkout/index', [
            'title' => 'Checkout',
        ]);
    }

    public function confirm()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            return;
        }
        // if (!isset($_SESSION['order'])) {
        //     header("Location: /checkout");
        //     return;
        // }
        //$order = $_SESSION['order'];
        //$_SESSION['order'] = null;
        $this->view->render('checkout/confirm', [
            'title' => 'Checkout confimation',
            //'order_id' => $order['order_id'],
            //'total_amout' => $order['total_amount']
        ]);
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            return;
        }
        try {
            $orders = $this->model->getAllByUserIdOrders($_SESSION['user']['user_id']);

            if ($orders) {
                $this->profileView->render('orders', [
                    'title' => 'Orders',
                    'orders' => $orders,
                ]);
            } else {
                $this->profileView->render('orders', [
                    'title' => 'Orders',
                ]);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
