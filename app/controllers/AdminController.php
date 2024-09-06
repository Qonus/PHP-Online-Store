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
        $this->user = $_SESSION["user"];
        $this->role = $this->userModel->getUserById($this->user['user_id'])['user_type'];
    }

    private function checkRole()
    {
        if ($this->user && ($this->role == "Administrator" || $this->role == "Manager")) {
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
}