<?php
$peticionAjax=true;
require_once ("../config/APP.php");
//petición a usuario

session_start(['name'=>'EA']);

if(!isset($_SESSION['id_ea'], $_SESSION['usuario_ea'], $_SESSION['token_ea'])){
    $alert = [
        "Alerta" => "redireccionar",
        "URL" => APP_URL."login/"
    ];
    echo json_encode($alert);
    exit();
}

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
    }else{
        $alert = [
            "Alerta" => "simple",
            "Titulo" => "Ocurrió un error inesperado",
            "Texto" => "No se recibieron todos los datos requeridos",
            "Tipo" => "error"
        ];
        echo json_encode($alert);
    }
    
    /*--------- Editar un usuario ---------*/
    
    
    /*--------- Eliminar un usuario ---------*/
    
   
}else {
    $alert = [
        "Alerta" => "simple",
        "Titulo" => "Ocurrió un error inesperado",
        "Texto" => "No se recibió una operación de usuario valida",
        "Tipo" => "error"
    ];
    echo json_encode($alert);
}