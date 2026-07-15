<?php
$peticionAjax=true;
require_once ("../config/APP.php");
//petición a usuario

if(isset($_POST['guardarUsuario'])){
    /*--------- Instancia al controlador ---------*/
    require_once ("../controller/userController.php");
    $userController = new userController();

    /*--------- Agregar un usuario ---------*/
    if(
        isset($_POST['Nombres_reg']) 
        && isset($_POST['Apellidos_reg']) 
        && isset($_POST['Email_reg']) 
        && isset($_POST['Telefono_reg']) 
        && isset($_POST['Rol_reg']) 
        && isset($_POST['Equipo_reg'])
        && isset($_POST['Username_reg'])
        && isset($_POST['Password_reg'])
        && isset($_POST['Password_confirm_reg'])
    ){
        $userController->add_user_controller();
    }
    
    /*--------- Editar un usuario ---------*/
    
    
    /*--------- Eliminar un usuario ---------*/
    
   
}else {
    session_start(['name'=>APP_NAME]);
    session_unset();
    session_destroy();
    header("Location: ".APP_URL."login/");
}