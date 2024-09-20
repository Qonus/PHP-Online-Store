<?php

class UserController extends Controller
{
    protected View $profileView;

    public function __construct()
    {
        parent::__construct();
        require_once __DIR__ . "/../views/users/profile/ProfileView.php";
        $this->profileView = new ProfileView;
        $this->model = parent::loadModel("UserModel");
    }

    static function checkAuth()
    {
        //$userModel = parent::loadModel("UserModel");
        if (!isset($_SESSION["user"])) {
            header("HTTP/1.1 401 Unauthorized");
            header("Location: /login/");
            return;
        } else {
            // $user = $_SESSION["user"];
            // $user = $userModel->getCustomerById($user["user_id"]);
            // if (!$user) {
            //     unset($_SESSION["user"]);
            //     header("HTTP/1.1 401 Unauthorized");
            //     header("Location: /login/");
            //     return;
            // }
            return;
        }
    }


    // PROFILE
    public function index()
    {
        self::checkAuth();

        $this->profileView->render("profile", [
            "title" => "Profile",
            "first_name" => $_SESSION["user"]["first_name"],
            "last_name" => $_SESSION["user"]["last_name"],
            "email" => $_SESSION["user"]["email"],
            "phone" => $_SESSION["user"]["phone"],
            "created_at" => $_SESSION["user"]["created_at"],
            "updated_at" => $_SESSION["user"]["updated_at"],
        ]);
    }
    public function settings()
    {
        self::checkAuth();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $result = $this->model->updateUser($_SESSION["user"]["user_id"], [
                "first_name" => $first_name,
                "last_name" => $last_name,
            ]);

            if ($result) {
                $_SESSION["user"] = $result;
                $this->profileView->render("settings", [
                    "title" => "Edit Profile",
                    "message" => "Success, data saved",
                    "first_name" => $_SESSION["user"]["first_name"],
                    "last_name" => $_SESSION["user"]["last_name"]
                ]);
            } else {
                $this->profileView->render("settings", [
                    "title" => "Edit Profile",
                    "error" => "Error, try again later",
                    "first_name" => $_SESSION["user"]["first_name"],
                    "last_name" => $_SESSION["user"]["last_name"]
                ]);
            }
            return;
        }

        $this->profileView->render("settings", [
            "title" => "Edit Profile",
            "first_name" => $_SESSION["user"]["first_name"],
            "last_name" => $_SESSION["user"]["last_name"]
        ]);
    }
    public function privacy()
    {
        self::checkAuth();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["change_password"])) {
                $old_password = $_POST["old_password"];
                $new_password = $_POST["new_password"];
                $confirm_new_password = $_POST["confirm_new_password"];
                if ($old_password != $_SESSION["user"]["password"]) {
                    $this->profileView->render("privacy", [
                        "title" => "Privacy settings",
                        "email" => $_SESSION["user"]["email"],
                        "error" => "Invalid old password",
                    ]);
                    return;
                } else if ($new_password != $confirm_new_password) {
                    $this->profileView->render("privacy", [
                        "title" => "Privacy settings",
                        "email" => $_SESSION["user"]["email"],
                        "error" => "Confirm password doesn't match with new password",
                    ]);
                    return;
                }

                $result = $this->model->updateUser($_SESSION["user"]["user_id"], [
                    "password" => $new_password,
                ]);

                if ($result) {
                    $_SESSION["user"] = $result;
                    $this->profileView->render("privacy", [
                        "title" => "Privacy settings",
                        "email" => $_SESSION["user"]["email"],
                        "message" => "Success, password is set",
                    ]);
                } else {
                    $this->profileView->render("privacy", [
                        "title" => "Privacy settings",
                        "email" => $_SESSION["user"]["email"],
                        "error" => "Error, try again later",
                    ]);
                }
                return;
            } else if (isset($_POST["change_email"])) {
                $email = $_POST["email"];

                $result = $this->model->updateUser($_SESSION["user"]["user_id"], [
                    "email" => $email,
                ]);

                if ($result) {
                    $_SESSION["user"] = $result;
                    $this->profileView->render("privacy", [
                        "title" => "Privacy settings",
                        "email" => $_SESSION["user"]["email"],
                        "message" => "Success, email is set",
                    ]);
                } else {
                    $this->profileView->render("privacy", [
                        "title" => "Privacy settings",
                        "email" => $_SESSION["user"]["email"],
                        "error" => "Error, email already exists",
                    ]);
                }
                return;
            }
        }

        $this->profileView->render("privacy", [
            "title" => "Profile Privacy",
            "email" => $_SESSION["user"]["email"],
        ]);
    }
    public function address()
    {
        self::checkAuth();
        $user = $_SESSION["user"];


        $addresses = $this->model->getCustomerAddresses($user["user_id"]);
        $default_address = $this->model->getDefaultAddressByCustomerId($user["user_id"]);
        if (!$default_address) {
            $default_address["address_id"] = null;
            $default_address["address_label"] = "";
        }

        $page_params = [
            "title" => "Address",
            "addresses" => $addresses,
            "default_address" => $default_address["address_label"],
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["add_address"])) {
                $data = [
                    ":address_label" => $_POST["address_label"],
                    ":customer_id" => $user["user_id"],
                    ":address_line1" => $_POST["address_line1"],
                    ":address_line2" => $_POST["address_line2"],
                    ":city" => $_POST["city"],
                    ":state" => $_POST["state"],
                    ":postal_code" => $_POST["postal_code"],
                    ":country" => $_POST["country"],
                    ":address_comment" => $_POST["address_comment"],
                ];
                $new_address = $this->model->addAddress($data);
                $page_params["addresses"] = $this->model->getCustomerAddresses($user["user_id"]);
                if ($new_address) {
                    $page_params["message"] = "Success, new address added.";
                } else {
                    $page_params["error"] = "Error, try again later.";
                }
            } else if (isset($_POST["set_default_address"])) {
                try {
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

                    $page_params["message"] = "Success, default address is set.";
                    $page_params["default_address"] = $new_default_address["address_label"];
                } catch (Exception $e) {
                    $page_params["error"] = "Error, {$e->getMessage()}";
                }
            }
        }

        $this->profileView->render("address/index", $page_params);
    }

    public function removeAddress($address_id)
    {
        self::checkAuth();
        $address = $this->model->getAddressById($address_id);
        if ($_SESSION["user"]["user_id"] != $address["customer_id"]) {
            header("Location: /profile/address");
            return;
        }

        $this->model->removeAddress($address_id);
        header("Location: /profile/address");
    }

    public function editAddress($address_id)
    {
        self::checkAuth();

        $address = $this->model->getAddressById($address_id);
        if ($_SESSION["user"]["user_id"] != $address["customer_id"]) {
            header("Location: /profile/address");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $result = $this->model->updateAddress($address_id, [
                "address_label" => $_POST["address_label"],
                "address_line1" => $_POST["address_line1"],
                "address_line2" => $_POST["address_line2"],
                "city" => $_POST["city"],
                "state" => $_POST["state"],
                "postal_code" => $_POST["postal_code"],
                "country" => $_POST["country"],
                "address_comment" => $_POST["address_comment"],
            ]);
            if ($result) {
                $address = $this->model->getAddressById($address_id);
                $this->profileView->render("address/edit", [
                    "title" => "Edit Address",
                    "address" => $address,
                    "message" => "Success, address updated."
                ]);
            } else {
                $this->profileView->render("address/edit", [
                    "title" => "Edit Address",
                    "address" => $address,
                    "error" => "Error, try again."
                ]);
            }
            return;
        }
        $this->profileView->render("address/edit", [
            "title" => "Edit Address",
            "address" => $address,
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
                $this->view->render("users/register", [
                    "title" => "Register",
                    "error" => "Unable to register, maybe your email is already registered"
                ]);
            }
        } else {
            $this->view->render("users/register", [
                "title" => "Register"
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
                $this->view->render("users/login", [
                    "title" => "Login",
                    "error" => "Invalid email or password"
                ]);
            }
        } else {
            $this->view->render("users/login", [
                "title" => "Login"
            ]);
        }
    }
    public function logout()
    {
        unset($_SESSION["user"]);
        header("Location: /");
    }
}

?>