<?php
    require_once 'mainModel.php';

    /*------------Modelo de usuario ------------------*/
    class userModel extends mainModel{
        // INSERT INTO Tabla(campo1,campo2,campo3) VALUES(:marcador1,:marcador2,:marcador3)
        protected function add_user_model($data){
            $sql = mainModel::conectar()->prepare("INSERT INTO usuario(usuario_nombre,usuario_apellido,usuario_email,usuario_telefono,usuario_rol,usuario_equipo,usuario_username,usuario_password,usuario_estatus) VALUES(:Nombre,:Apellido,:Email,:Telefono,:Rol,:Equipo,:Username,:Password,:Estatus)");
            $sql->bindParam(":Nombre",$data['Nombre']);
            $sql->bindParam(":Apellido",$data['Apellido']);
            $sql->bindParam(":Email",$data['Email']);
            $sql->bindParam(":Telefono",$data['Telefono']);
            $sql->bindParam(":Rol",$data['Rol']);
            $sql->bindParam(":Equipo",$data['Equipo']);
            $sql->bindParam(":Username",$data['Username']);
            $sql->bindParam(":Password",$data['Password']);
            $sql->bindParam(":Estatus",$data['Estatus']);
            $sql->execute();
            return $sql;
        }

        //UPDATE usuario SET usuario_nombre=:Nombre,usuario_username=:Username WHERE usuario_id=:ID"
        protected function update_user_model($data){
            $sql=mainModel::conectar()->prepare("UPDATE usuario SET usuario_nombre=:Nombre,usuario_apellido=:Apellido,usuario_email=:Email,usuario_telefono=:Telefono,usuario_rol=:Rol,usuario_equipo=:Equipo,usuario_username=:Username WHERE usuario_id=:ID");
            $sql->bindParam(":ID",$data['ID']);
            $sql->bindParam(":Nombre",$data['Nombre']);
            $sql->bindParam(":Apellido",$data['Apellido']);
            $sql->bindParam(":Email",$data['Email']);
            $sql->bindParam(":Telefono",$data['Telefono']);
            $sql->bindParam(":Rol",$data['Rol']);
            $sql->bindParam(":Equipo",$data['Equipo']);
            $sql->bindParam(":Username",$data['Username']);
            $sql->execute();
            return $sql;
        }

        //DELETE FROM tabla WHERE usuario_id=:ID
        protected function delete_user_model($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM usuario WHERE usuario_id=:ID");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        protected function list_users_model(){
            $sql = mainModel::conectar()->prepare(
                "SELECT u.usuario_id, u.usuario_nombre, u.usuario_apellido, u.usuario_email, u.usuario_telefono, u.usuario_rol, u.usuario_equipo, u.usuario_username, u.usuario_estatus, r.rol_descripcion, e.equipo_descripcion
                FROM usuario u
                LEFT JOIN rol r ON r.rol_id=u.usuario_rol
                LEFT JOIN equipo e ON e.equipo_id=u.usuario_equipo
                ORDER BY u.usuario_id DESC"
            );
            $sql->execute();
            return $sql;
        }

        protected function get_user_model($id){
            $sql = mainModel::conectar()->prepare(
                "SELECT u.usuario_id, u.usuario_nombre, u.usuario_apellido, u.usuario_email, u.usuario_telefono, u.usuario_rol, u.usuario_equipo, u.usuario_username, u.usuario_estatus, r.rol_descripcion, e.equipo_descripcion
                FROM usuario u
                LEFT JOIN rol r ON r.rol_id=u.usuario_rol
                LEFT JOIN equipo e ON e.equipo_id=u.usuario_equipo
                WHERE u.usuario_id=:ID"
            );
            $sql->bindParam(":ID", $id, PDO::PARAM_INT);
            $sql->execute();
            return $sql;
        }

        protected function user_exists_model($email, $username, $id){
            $sql = mainModel::conectar()->prepare(
                "SELECT usuario_id FROM usuario
                WHERE (usuario_email=:Email OR usuario_username=:Username) AND usuario_id!=:ID
                LIMIT 1"
            );
            $sql->bindParam(":Email", $email);
            $sql->bindParam(":Username", $username);
            $sql->bindParam(":ID", $id, PDO::PARAM_INT);
            $sql->execute();
            return $sql;
        }

        protected function active_role_model($id){
            $sql = mainModel::conectar()->prepare("SELECT rol_id FROM rol WHERE rol_id=:ID AND rol_estatus=1");
            $sql->bindParam(":ID", $id, PDO::PARAM_INT);
            $sql->execute();
            return $sql;
        }

        protected function active_team_model($id){
            $sql = mainModel::conectar()->prepare("SELECT equipo_id FROM equipo WHERE equipo_id=:ID AND equipo_estatus=1");
            $sql->bindParam(":ID", $id, PDO::PARAM_INT);
            $sql->execute();
            return $sql;
        }

        protected function update_user_status_model($id, $status){
            $sql = mainModel::conectar()->prepare("UPDATE usuario SET usuario_estatus=:Estatus WHERE usuario_id=:ID");
            $sql->bindParam(":Estatus", $status, PDO::PARAM_INT);
            $sql->bindParam(":ID", $id, PDO::PARAM_INT);
            $sql->execute();
            return $sql;
        }

        //SELECT * FROM tabla WHERE usuario_id=:ID
        protected function data_user_model($type, $id){
            if($type == "Only"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE usuario_id=:ID");
                $sql->bindParam(":ID", $id);
            }elseif($type == "Count"){
                $sql = mainModel::conectar()->prepare("SELECT usuario_id FROM usuario WHERE usuario_id!=1");
            }elseif($type == "All"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE usuario_estatus=1 ORDER BY usuario_id DESC");
            }
            $sql->execute();
            return $sql;
        }
    }