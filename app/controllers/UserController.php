<?php

class UserController extends Controller
{
    protected View $profileView;

    public function __construct()
    {
        parent::__construct();
        require_once __DIR__ . '/../views/users/profile/ProfileView.php';
        $this->profileView = new ProfileView;
        require_once __DIR__ . '/../models/UserModel.php';
        $this->model = new UserModel;
    }

    // PROFILE
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }
        $this->profileView->render('profile', [
            'title' => 'Profile',
            'first_name' => $_SESSION['user']['first_name'],
            'last_name' => $_SESSION['user']['last_name'],
            'email' => $_SESSION['user']['email'],
            'phone' => $_SESSION['user']['phone'],
            'created_at' => $_SESSION['user']['created_at'],
            'updated_at' => $_SESSION['user']['updated_at'],
        ]);
    }
    public function settings()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $result = $this->model->updateUser($_SESSION['user']['user_id'], [
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);

            if ($result) {
                $_SESSION['user'] = $result;
                $this->profileView->render('settings', [
                    'title' => 'Edit Profile',
                    'message' => "Success, data saved",
                    'first_name' => $_SESSION['user']['first_name'],
                    'last_name' => $_SESSION['user']['last_name']
                ]);
            } else {
                $this->profileView->render('settings', [
                    'title' => 'Edit Profile',
                    'error' => 'Error, try again later',
                    'first_name' => $_SESSION['user']['first_name'],
                    'last_name' => $_SESSION['user']['last_name']
                ]);
            }
            return;
        }

        $this->profileView->render('settings', [
            'title' => 'Edit Profile',
            'first_name' => $_SESSION['user']['first_name'],
            'last_name' => $_SESSION['user']['last_name']
        ]);
    }
    public function privacy()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }
        // if ($_SERVER["REQUEST_METHOD"] === "POST") {
        //     $first_name = $_POST["first_name"];
        //     $last_name = $_POST["last_name"];
        //     $result = $this->model->updateUser($_SESSION['user']['user_id'], [
        //         'first_name' => $first_name,
        //         'last_name' => $last_name,
        //     ]);

        //     if ($result) {
        //         $_SESSION['user'] = $result;
        //         $this->profileView->render('settings', [
        //             'title' => 'Edit Profile',
        //             'message' => "Success, data saved",
        //         ]);
        //     } else {
        //         $this->profileView->render('settings', [
        //             'title' => 'Edit Profile',
        //             'error' => 'Error, try again later',
        //         ]);
        //     }
        //     return;
        // }

        $this->profileView->render('privacy', [
            'title' => 'Profile Privacy',
            'email' => $_SESSION['user']['email'],
        ]);
    }
    public function address()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login/");
            return;
        }
        $this->profileView->render('address', [
            'title' => 'Profile',
            'first_name' => $_SESSION['user']['first_name'],
            'last_name' => $_SESSION['user']['last_name'],
            'email' => $_SESSION['user']['email'],
            'phone' => $_SESSION['user']['phone'],
            'created_at' => $_SESSION['user']['created_at'],
            'updated_at' => $_SESSION['user']['updated_at'],
        ]);
    }

    // AUTH
    public function register()
    {
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
                $_SESSION["user"] = $this->model->getUserById($result);
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
    public function login()
    {
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
    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: /");
    }
}

?>