<?php
	require_once "./config/APP.php";
	require_once "./controller/viewController.php";

	//Instancia de controlador de vistas
	$template = new viewController();
  // Cargar plantilla
	$template->get_template_controller();