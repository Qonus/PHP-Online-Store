<?php

require_once __DIR__ . '/../models/OrdersModel.php';

class OrdersController extends Controller {
    public function index() {
        try {
            $ordersModel = new OrdersModel();
            $orders = $ordersModel->getAllOrders();
            
            if ($orders) {
                $this->view->render('orders/orders', [
                    'title' => 'Orders',
                    'orders' => $orders,
                ]);
            } else {
                // Обработка ситуации, когда продукты не найден
                echo "Orders not found.";
            }
        } catch (Exception $e) {
            // Обработка ошибки, если произошла ошибка при поиске продукта или рендеринге шаблона
            echo "Error: " . $e->getMessage();
        }
    }
}
