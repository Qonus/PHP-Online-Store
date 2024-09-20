<?php

class AdminController extends Controller
{
    public $userModel;
    public $productModel;
    private $user;
    private $role;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = $this->loadModel("UserModel");
        if (isset($_SESSION["user"])) {
            $this->user = $_SESSION["user"];
            $this->role = $this->userModel->getUserById($this->user['user_id'])['user_type'];
        }
        $this->productModel = $this->loadModel('ProductModel');
    }

    private function checkRole($role = "")
    {
        if ($this->user && ($this->role == $role || ($role == "" && ($this->role == "Administrator" || $this->role == "Manager")))) {
            return;
        } else {
            $this->view->notFound();
            exit();
        }
    }

    public function index()
    {
        $this->checkRole();
        $this->view->render("admin/index", [
            "title" => "Admin Panel",
            "role" => $this->role
        ]);
    }

    public function users()
    {
        $this->checkRole("Administrator");

        $users = $this->userModel->getAllUsers(["Administrator", "Manager"]);

        $this->view->render("admin/users", [
            "title" => "Users panel",
            "users" => $users,
            "role" => $this->role,
        ]);
    }

    public function customers()
    {
        $this->checkRole();

        $customers = $this->userModel->getAllUsers(["Customer"]);

        $this->view->render("admin/users", [
            "title" => "Customers panel",
            "users" => $customers,
            "role" => $this->role,
        ]);
    }

    public function items()
    {
        $this->checkRole();

        $items = $this->productModel->getAllProducts();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                ":product_name" => $_POST["product_name"],
                ":description" => $_POST["description"],
                ":price" => $_POST["price"],
                ":stock_quantity" => $_POST["stock_quantity"],
                ":brand_id" => $_POST["brand_id"],
                ":category_id" => $_POST["category_id"],
                ":age_range" => $_POST["age_range"],
                ":player_number" => $_POST["player_number"],
                ":weight" => $_POST["weight"],
                ":dimensions" => $_POST["dimensions"],
                ":release_date" => $_POST["release_date"],
            ];

            $new_product = $this->productModel->addProduct($data);

            if ($new_product) {
                $this->view->render("admin/items", [
                    "title" => "Products panel",
                    "message" => "Success! New product added.",
                    "items" => $this->productModel->getAllProducts(),
                ]);
            } else {
                $this->view->render("admin/items", [
                    "title" => "Products panel",
                    "error" => "Error adding product. Please try again.",
                    "items" => $items,
                ]);
            }
        }
    }

    public function item($product_id)
    {
        $this->checkRole();

        $product = $this->productModel->getProductById($product_id);

        $this->view->render("admin/items", [
            "title" => "Products panel",
            "product" => $product,
        ]);
    }
}