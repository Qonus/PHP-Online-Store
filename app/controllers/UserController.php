<?php

class UserController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once __DIR__ . '/../models/UserModel.php';
        $this->model = new UserModel;
    }

    public function index() {

        $this->view->render('users/profile', [
            'title' => 'Profile',
            'error' => "User doesn't exist"
        ]);
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "user_type" => "Customer",
                "first_name" => $_POST["first_name"],
                "last_name" => $_POST["last_name"],
                "phone" => $_POST["phone"],
                "email" => $_POST["email"],
                "password" => $_POST["password"],
            ];
            $confirm_password = $_POST["confirm_password"];
            if ($confirm_password != $data["password"]) {
                $this->view->render("users/register", [
                    "title" => "Register",
                    "first_name" => $_POST["first_name"],
                    "last_name" => $_POST["last_name"],
                    "phone" => $_POST["phone"],
                    "email" => $_POST["email"],
                    "error" => "Unable to register, your passwords don't match"
                ]);
                return;
            }
            $result = $this->model->registerUser($data);
            if ($result) {
                $_SESSION["user"] = $result;
                header("Location: /");
            } else {
                $this->view->render('users/register', [
                    'title' => 'Register',
                    'error' => 'Unable to register, maybe your email is already registered'
                ]);
            }
        } else {
            $this->view->render('users/register', [
                'title' => 'Register'
            ]);
        }
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") { 
            $email = $_POST["email"];
            $password = $_POST["password"];
            $result = $this->model->authUser($email, $password);
            if ($result) {
                $_SESSION["user"] = $result;
                header("Location: /");
            } else {
                $this->view->render('users/login', [
                    'title' => 'Login',
                    'error' => 'Invalid email or password'
                ]);
            }
        } else {
            $this->view->render('users/login', [
                'title' => 'Login'
            ]);
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        header("Location: /");
    }
}

?>