<?php
$peticionAjax=true;
require_once ("../config/APP.php");
//petición a usuario

if(isset($_POST['id_ea'])){
    /*--------- Instancia al controlador ---------*/
    require_once ("../controller/loginController.php");
    $loginController = new loginController();

    /*--------- cerrar sesion ---------*/
    if(isset($_POST['usuario']) && isset($_POST['token']) ){
        $loginController->log_out_controller();
    }
    
}else {
    session_start(['name'=>APP_NAME]);
    session_unset();
    session_destroy();
    header("Location: ".APP_URL."login/");
}