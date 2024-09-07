<?php

class AdminController extends Controller
{
    public $userModel;
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
}