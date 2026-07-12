<?php
    if($peticionAjax){
        require_once "../model/userModel.php";
    }else{
        require_once "./model/userModel.php";
    }
    class userController extends userModel {
        /*== Controlador para agregar un usuario ==*/
        public function  add_user_controller(){
            /*== recibir campos via post ==*/
            $nombre = mainModel::clean_string($_POST['Nombre_reg']);
            $apellido = mainModel::clean_string($_POST['Apellido_reg']);
            $email = mainModel::clean_string($_POST['Email_reg']);
            $telefono = mainModel::clean_string($_POST['Telefono_reg']);
            $rol = mainModel::clean_string($_POST['Rol_reg']);
            $equipo = mainModel::clean_string($_POST['Equipo_reg']);
            $username = mainModel::clean_string($_POST['Username_reg']);
            $password = mainModel::clean_string($_POST['Password_reg']);
            $password2 = mainModel::clean_string($_POST['Password_confirm_reg']);
            
            /*== comprobar campos vacios ==*/
            if($nombre=="" ||$apellido=="" || $telefono=="" || $password=="" || $password2=="" || $username==""){
                $alert = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No has llenado todos los campos que son obligatorios",
                    "Tipo" => "error"
                ];
                echo json_encode($alert);
                exit();
            }

            /*== Verificando integridad de los datos ==*/
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}", $nombre)){
                $alert = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Campo Nombre no coincide con el formato solicitado: [a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}",
                    "Tipo" => "error"
                ];
                echo json_encode($alert);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}", $apellido)){
                $alert = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Campo Apellido no coincide con el formato solicitado: [a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}",
                    "Tipo" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
            /*== Comprobando email ==*/
            if($email!=""){
                if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $check_email=mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
                    if($check_email->rowCount()>0){
                        $alert=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"El EMAIL ingresado ya se encuentra registrado en el sistema",
                            "Tipo"=>"error"
                        ];
                        echo json_encode($alert);
                        exit();
                    }
                }else{
                    $alert=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Ha ingresado un correo no valido",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }

                if(mainModel::verificar_datos("[0-9+]{11,15}",$telefono)){
                    $alert=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El Campo Telefono no coincide con el formato solicitado:[0-9+]{11,15}",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }
    
                if($rol==""){
                    $alert=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Selecione un rol de usuario",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }

                if($equipo==""){
                    $alert=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Selecione un equipo de usuario",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }

                if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}",$username)){
                    $alert=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El Campo Usuario no coincide con el formato solicitado:[a-zA-Z0-9]{1,35}",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }

                if(mainModel::verificar_datos("[a-zA-Z0-9ñÑ]{7,35}", $password2)){
                    $alert = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El Campo Repetir Contraseña no coincide con el formato solicitado: [a-zA-Z0-9ñÑ*$.#]{7,35}",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alert);
                    exit();
                }

                if($password != $password2){
                    $alert = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "Las contraseñas no coinciden",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alert);
                    exit();
                }

                $password = mainModel::encryption($password);
                
                $data = [
                    "Nombre" => $nombre,
                    "Apellido" => $apellido,
                    "Email" => $email,
                    "Telefono" => $telefono,
                    "Rol" => $rol,
                    "Equipo" => $equipo,
                    "Username" => $username,
                    "Password" => $password,
                    "Estatus" => 1
                ];

                $add_user = userModel::add_user_model($data);

                if($add_user->rowCount() == 1){
                    $alert = [
                        "Alerta" => "limpiar",
                        "Titulo" => "Usuario registrado",
                        "Texto" => "El usuario se ha registrado con éxito",
                        "Tipo" => "success"
                    ];
                }else{
                    $alert = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "No se ha podido registrar el usuario",
                        "Tipo" => "error"
                    ];
                }
                echo json_encode($alert);
                exit();
            }/*-- Fin controlador --*/
        }
    }