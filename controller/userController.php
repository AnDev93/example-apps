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
            $nombre = mainModel::clean_string($_POST['Nombres_reg']);
            $apellido = mainModel::clean_string($_POST['Apellidos_reg']);
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
                $estatus=true;
                $data = [
                    "Nombre" => $nombre,
                    "Apellido" => $apellido,
                    "Email" => $email,
                    "Telefono" => $telefono,
                    "Rol" => $rol,
                    "Equipo" => $equipo,
                    "Username" => $username,
                    "Password" => $password,
                    "Estatus" => $estatus
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
        } // fin Controlador add_user_controller

        private function user_alert($alert, $title, $text, $type){
            echo json_encode([
                "Alerta" => $alert,
                "Titulo" => $title,
                "Texto" => $text,
                "Tipo" => $type
            ], JSON_UNESCAPED_UNICODE);
            exit();
        }

        public function list_users_controller(){
            return $this->list_users_model()->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_user_controller($id){
            return $this->get_user_model($id)->fetch(PDO::FETCH_ASSOC);
        }

        public function update_user_controller(){
            $id = filter_var($_POST['usuario_id'] ?? '', FILTER_VALIDATE_INT);
            $nombre = mainModel::clean_string($_POST['Nombres_reg'] ?? '');
            $apellido = mainModel::clean_string($_POST['Apellidos_reg'] ?? '');
            $email = mainModel::clean_string($_POST['Email_reg'] ?? '');
            $telefono = mainModel::clean_string($_POST['Telefono_reg'] ?? '');
            $rol = filter_var($_POST['Rol_reg'] ?? '', FILTER_VALIDATE_INT);
            $equipo = filter_var($_POST['Equipo_reg'] ?? '', FILTER_VALIDATE_INT);
            $username = mainModel::clean_string($_POST['Username_reg'] ?? '');

            if($id === false || $id < 1 || $nombre == "" || $apellido == "" || $email == "" || $telefono == "" || $rol === false || $equipo === false || $username == ""){
                $this->user_alert("simple", "Datos incompletos", "Completa todos los campos obligatorios.", "error");
            }

            if(!$this->get_user_model($id)->fetch(PDO::FETCH_ASSOC)){
                $this->user_alert("simple", "Usuario no encontrado", "El usuario seleccionado no existe.", "error");
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}", $nombre) || mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}", $apellido)){
                $this->user_alert("simple", "Datos inválidos", "El nombre y el apellido deben tener entre 3 y 30 caracteres.", "error");
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 30){
                $this->user_alert("simple", "Correo inválido", "Ingresa un correo electrónico válido.", "error");
            }

            if(mainModel::verificar_datos("[0-9+]{11,15}", $telefono) || mainModel::verificar_datos("[a-zA-Z0-9]{1,30}", $username)){
                $this->user_alert("simple", "Datos inválidos", "Verifica el formato del teléfono y del nombre de usuario.", "error");
            }

            if($this->user_exists_model($email, $username, $id)->rowCount() > 0){
                $this->user_alert("simple", "Usuario duplicado", "El correo o nombre de usuario ya está registrado.", "error");
            }

            if($this->active_role_model($rol)->rowCount() !== 1 || $this->active_team_model($equipo)->rowCount() !== 1){
                $this->user_alert("simple", "Rol o equipo inválido", "Selecciona un rol y un equipo activos.", "error");
            }

            $updated = $this->update_user_model([
                "ID" => $id,
                "Nombre" => $nombre,
                "Apellido" => $apellido,
                "Email" => $email,
                "Telefono" => $telefono,
                "Rol" => $rol,
                "Equipo" => $equipo,
                "Username" => $username
            ]);

            if($updated){
                $this->user_alert("recargar", "Usuario actualizado", "Los datos del usuario se actualizaron correctamente.", "success");
            }

            $this->user_alert("simple", "Error", "No se pudo actualizar el usuario.", "error");
        }

        public function update_user_status_controller(){
            $id = filter_var($_POST['usuario_id'] ?? '', FILTER_VALIDATE_INT);
            $status = filter_var($_POST['usuario_estatus'] ?? '', FILTER_VALIDATE_INT);

            if($id === false || $id < 1 || !in_array($status, [0, 1], true)){
                $this->user_alert("simple", "Datos inválidos", "No se pudo modificar el estatus del usuario.", "error");
            }

            if($id === 1 || $id === (int)$_SESSION['id_ea']){
                $this->user_alert("simple", "Operación no permitida", "No puedes modificar el estatus de esta cuenta.", "error");
            }

            if(!$this->get_user_model($id)->fetch(PDO::FETCH_ASSOC)){
                $this->user_alert("simple", "Usuario no encontrado", "El usuario seleccionado no existe.", "error");
            }

            $updated = $this->update_user_status_model($id, $status);
            if($updated){
                $this->user_alert("recargar", "Estatus actualizado", "El estatus del usuario se actualizó correctamente.", "success");
            }

            $this->user_alert("simple", "Error", "No se pudo modificar el estatus del usuario.", "error");
        }

        public function delete_user_controller(){
            $id = filter_var($_POST['usuario_id'] ?? '', FILTER_VALIDATE_INT);

            if($id === false || $id < 1){
                $this->user_alert("simple", "Datos inválidos", "No se pudo eliminar el usuario.", "error");
            }

            if($id === 1 || $id === (int)$_SESSION['id_ea']){
                $this->user_alert("simple", "Operación no permitida", "No puedes eliminar esta cuenta.", "error");
            }

            if(!$this->get_user_model($id)->fetch(PDO::FETCH_ASSOC)){
                $this->user_alert("simple", "Usuario no encontrado", "El usuario seleccionado no existe.", "error");
            }

            $deleted = $this->delete_user_model($id);
            if($deleted){
                $this->user_alert("recargar", "Usuario eliminado", "El usuario se eliminó correctamente.", "success");
            }

            $this->user_alert("simple", "Error", "No se pudo eliminar el usuario.", "error");
        }

        


    }