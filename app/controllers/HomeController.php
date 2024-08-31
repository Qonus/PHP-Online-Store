<?php

class HomeController extends Controller
{
    public function index()
    {
        require_once __DIR__ . '/../models/ProductModel.php';

        try {
            $productModel = new ProductModel();
            $products = $productModel->getLastProducts();

            if ($products) {
                $this->view->render('home/index', [
                    'title' => 'PlaySphere',
                    'products' => $products,
                ]);
            } else {
                echo "Products not found.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
