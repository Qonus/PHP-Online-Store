<?php

abstract class Controller
{
	public $model;
	public $view;

	function __construct()
	{
		$this->view = new View();
	}

	protected static function loadModel($model)
	{
		require_once __DIR__ . "/../models/{$model}.php";
		return new $model();
	}

	abstract function index();
}