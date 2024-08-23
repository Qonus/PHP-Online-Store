<?php

class CartController extends Controller {
    public function __construct() {
        parent::__construct();
        require_once __DIR__ . '/../models/CartModel.php';
        $this->model = new CartModel();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }
        try {
            $items = $this->model->getCart($_SESSION['user']['user_id']);
            $this->view->render('cart/index', [
                'title' => 'Cart',
                'items' => $items
            ]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function add($id) {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }
        try {
            $this->model->addToCart($_SESSION['user']['user_id'], $id);
            header("Location: /cart/");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function remove($id) {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }
        try {
            $this->model->updateQuantity($_SESSION['user']['user_id'], $id, 0);
            header("Location: /cart/");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function set($id, $quantity) {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }
        try {
            $product = $this->model->getCartProduct($_SESSION['user']['user_id'], $id);
            $this->model->updateQuantity($_SESSION['user']['user_id'], $id, $product['quantity'] + $quantity);
            header("Location: /cart/");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}