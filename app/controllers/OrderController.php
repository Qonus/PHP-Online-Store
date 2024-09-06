<?php

require_once __DIR__ . '/../controllers/UserController.php';
class OrderController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = parent::loadModel('OrderModel');
    }

    public function checkout()
    {
        UserController::checkAuth();

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
        $this->view->render('order/index', [
            'title' => 'Checkout',
        ]);
    }

    public function confirm()
    {
        UserController::checkAuth();

        // if (!isset($_SESSION['order'])) {
        //     header("Location: /checkout");
        //     return;
        // }
        //$order = $_SESSION['order'];
        //$_SESSION['order'] = null;
        $this->view->render('order/confirm', [
            'title' => 'Checkout confimation',
            //'order_id' => $order['order_id'],
            //'total_amout' => $order['total_amount']
        ]);
    }

    public function index()
    {
        UserController::checkAuth();

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

    public function orderDetails($order_id)
    {
        UserController::checkAuth();

        $order = $this->model->getOrderById($order_id);
        if ($_SESSION['user']['user_id'] != $order['customer_id']) {
            header("Location: /profile/orders");
            return;
        }
        $order_details = $this->model->getAllOrderDetails($order_id);

        $this->view->render('order/order_details', [
            'title' => 'Order Details',
            'order' => $order,
            'order_details' => $order_details,
        ]);
    }
}
