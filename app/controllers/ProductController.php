<?php

require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class ProductController extends Controller {
    public function index() {
        try {
            $productModel = new ProductModel();
            $products = $productModel->getAllProducts();
            
            if ($products) {
                $this->view->render('products/products', [
                    'title' => 'Products',
                    'products' => $products,
                ]);
            } else {
                // Обработка ситуации, когда продукты не найден
                echo "Products not found.";
            }
        } catch (Exception $e) {
            // Обработка ошибки, если произошла ошибка при поиске продукта или рендеринге шаблона
            echo "Error: " . $e->getMessage();
        }
    }

    public function search($prompt) {
        
    }

    public function show($id) {
        try {
            $productModel = new ProductModel();
            $item = $productModel->getProductById($id);
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getCategoryById($item['category_id'])['category_name'];

            if ($item) {
                $this->view->render('products/individual-product-page', [
                    'title' => $item['product_name'],
                    'category' => $category,
                    'product_id' => $item['product_id'],
                    'name' => $item['product_name'],
                    'description' => $item['description'],
                    'age_range' => $item['age_range'],
                    'player_number' => $item['player_number'],
                    'weight' => $item['weight'],
                    'dimensions' => $item['dimensions'],
                    'release_date' => $item['release_date'],
                    'price' => $item['price'],
                    'stock_quantity' => $item['stock_quantity'],
                ]);
            } else {
                // Обработка ситуации, когда продукт не найден
                echo "Product not found.";
            }
        } catch (Exception $e) {
            // Обработка ошибки, если произошла ошибка при поиске продукта или рендеринге шаблона
            echo "Error: " . $e->getMessage();
        }
    }
}
