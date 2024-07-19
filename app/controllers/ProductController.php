<?php

class ProductController extends Controller {
    public function index() {
        $this->view->render("home/index", ["title" => "Home"]);
    }

    public function product($id) {
        echo $id;
    }
}

?>