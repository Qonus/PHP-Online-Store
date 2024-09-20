<?php

require_once __DIR__ . "/../controllers/UserController.php";
class OrderController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = parent::loadModel("OrderModel");
    }

    public function checkout()
    {
        UserController::checkAuth();
        $user = $_SESSION["user"];

        $addresses = $this->model->getCustomerAddresses($user["user_id"]);
        $default_address = $this->model->getDefaultAddressByCustomerId($user["user_id"]);
        if (!$default_address) {
            $default_address["address_id"] = null;
            $default_address["address_label"] = "";
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $new_default_address = [];
            if ($_POST["default_address"] == "None") {
                $new_default_address["address_id"] = null;
                $new_default_address["address_label"] = "";
            } else {
                $new_default_address = $this->model->getAddressByAddressLabel($user["user_id"], $_POST["default_address"]);
            }
            $data = [
                "default_address_id" => $new_default_address["address_id"],
            ];
            $this->model->updateCustomer($user["user_id"], $data);

            // $payment_method = $_POST["payment_method"];
            // $address = $_POST["address"];
            $this->model->createOrder($_SESSION["user"]["user_id"]);
            header("Location: /checkout/confirm");
            return;
            // if ($order_id) {
            //     //$_SESSION["order"] = $this->model->getOrderById($order_id);
            // }
        }
        $this->view->render("order/index", [
            "title" => "Checkout",
            "addresses" => $addresses,
            "default_address" => $default_address["address_label"],
        ]);
    }

    public function confirm()
    {
        UserController::checkAuth();

        // if (!isset($_SESSION["order"])) {
        //     header("Location: /checkout");
        //     return;
        // }
        //$order = $_SESSION["order"];
        //$_SESSION["order"] = null;
        $this->view->render("order/confirm", [
            "title" => "Checkout confimation",
            //"order_id" => $order["order_id"],
            //"total_amout" => $order["total_amount"]
        ]);
    }

    public function index()
    {
        UserController::checkAuth();
        $user = $_SESSION["user"];
        $this->orders($user["user_id"]);
    }

    public function orders($customer_id)
    {
        UserController::checkAuth();

        $user = $_SESSION["user"];
        if ($customer_id != $user["user_id"] && ($user["user_type"] != "Manager" && $user["user_type"] != "Administrator")) {
            $this->view->notFound();
            exit();
        }

        try {
            $orders = $this->model->getAllByUserIdOrders($customer_id);

            if ($orders) {
                $this->profileView->render("orders", [
                    "title" => "Orders",
                    "orders" => $orders,
                ]);
            } else {
                $this->profileView->render("orders", [
                    "title" => "Orders",
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
        $user = $_SESSION["user"];
        if ($user["user_id"] != $order["customer_id"] && ($user["user_type"] != "Manager" && $user["user_type"] != "Administrator")) {
            header("Location: /profile/orders");
            return;
        }
        $order_details = $this->model->getAllOrderDetails($order_id);

        $this->view->render("order/order_details", [
            "title" => "Order Details",
            "order" => $order,
            "order_details" => $order_details,
        ]);
    }

    public function cancel($order_id) {
        UserController::checkAuth();
    
        $user = $_SESSION["user"];
        
        $order = $this->model->getOrderById($order_id);
        
        if (!$order || ($order["customer_id"] != $user["user_id"] && $user["user_type"] != "Manager" && $user["user_type"] != "Administrator")) {
            $this->view->notFound();
            exit();
        }
    
        $deleted = $this->model->deleteOrder($order_id);
        header("Location: /profile");
    }
    
}
