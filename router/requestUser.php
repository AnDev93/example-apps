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

require_once ("../controller/userController.php");
$userController = new userController();

if(isset($_POST['guardarUsuario'])){
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
}elseif(isset($_POST['editarUsuario'])){
    $userController->update_user_controller();
}elseif(isset($_POST['actualizarPerfil'])){
    $userController->update_profile_controller();
}elseif(isset($_POST['cambiarContrasenaPerfil'])){
    $userController->update_profile_password_controller();
}elseif(isset($_POST['cambiarEstatusUsuario'])){
    $userController->update_user_status_controller();
}elseif(isset($_POST['eliminarUsuario'])){
    $userController->delete_user_controller();
}else{
    $alert = [
        "Alerta" => "simple",
        "Titulo" => "Ocurrió un error inesperado",
        "Texto" => "No se recibió una operación de usuario valida",
        "Tipo" => "error"
    ];
    echo json_encode($alert);
}