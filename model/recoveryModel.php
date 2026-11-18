<?php
require_once __DIR__ . "/mainModel.php";

class recoveryModel extends mainModel{
    protected function find_recovery_user_model($email){
        $sql = self::conectar()->prepare(
            "SELECT usuario_id, usuario_email
            FROM usuario
            WHERE usuario_email=:Email AND usuario_estatus=1
            LIMIT 1"
        );
        $sql->bindParam(":Email", $email);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    protected function save_reset_token_model($userId, $tokenHash){
        $connection = self::conectar();
        $connection->beginTransaction();

        try{
            $lockUser = $connection->prepare(
                "SELECT usuario_id
                FROM usuario
                WHERE usuario_id=:ID AND usuario_estatus=1
                FOR UPDATE"
            );
            $lockUser->bindParam(":ID", $userId, PDO::PARAM_INT);
            $lockUser->execute();
            if($lockUser->fetchColumn() === false){
                $connection->commit();
                return false;
            }

            $recentRequest = $connection->prepare(
                "SELECT created_at > DATE_SUB(UTC_TIMESTAMP(), INTERVAL 60 SECOND)
                FROM password_reset_tokens
                WHERE usuario_id=:ID
                FOR UPDATE"
            );
            $recentRequest->bindParam(":ID", $userId, PDO::PARAM_INT);
            $recentRequest->execute();
            if((int)$recentRequest->fetchColumn() === 1){
                $connection->commit();
                return false;
            }

            $saveToken = $connection->prepare(
                "INSERT INTO password_reset_tokens (usuario_id, token_hash, expires_at, created_at)
                VALUES (:ID, :Token, DATE_ADD(UTC_TIMESTAMP(), INTERVAL 30 MINUTE), UTC_TIMESTAMP())
                ON DUPLICATE KEY UPDATE
                    token_hash=VALUES(token_hash),
                    expires_at=VALUES(expires_at),
                    created_at=VALUES(created_at)"
            );
            $saveToken->bindParam(":ID", $userId, PDO::PARAM_INT);
            $saveToken->bindParam(":Token", $tokenHash);
            $saveToken->execute();
            $connection->commit();
            return true;
        }catch(PDOException $exception){
            if($connection->inTransaction()){
                $connection->rollBack();
            }
            throw $exception;
        }
    }

    protected function delete_reset_token_model($userId, $tokenHash){
        $sql = self::conectar()->prepare(
            "DELETE FROM password_reset_tokens
            WHERE usuario_id=:ID AND token_hash=:Token"
        );
        $sql->bindParam(":ID", $userId, PDO::PARAM_INT);
        $sql->bindParam(":Token", $tokenHash);
        $sql->execute();
    }

    protected function is_valid_reset_token_model($tokenHash){
        $sql = self::conectar()->prepare(
            "SELECT 1
            FROM password_reset_tokens t
            INNER JOIN usuario u ON u.usuario_id=t.usuario_id
            WHERE t.token_hash=:Token
                AND t.expires_at > UTC_TIMESTAMP()
                AND u.usuario_estatus=1
            LIMIT 1"
        );
        $sql->bindParam(":Token", $tokenHash);
        $sql->execute();
        return $sql->fetchColumn() !== false;
    }

    protected function reset_password_model($tokenHash, $password){
        $connection = self::conectar();
        $connection->beginTransaction();

        try{
            $findToken = $connection->prepare(
                "SELECT t.usuario_id
                FROM password_reset_tokens t
                INNER JOIN usuario u ON u.usuario_id=t.usuario_id
                WHERE t.token_hash=:Token
                    AND t.expires_at > UTC_TIMESTAMP()
                    AND u.usuario_estatus=1
                FOR UPDATE"
            );
            $findToken->bindParam(":Token", $tokenHash);
            $findToken->execute();
            $userId = $findToken->fetchColumn();

            if($userId === false){
                $connection->rollBack();
                return false;
            }

            $updatePassword = $connection->prepare(
                "UPDATE usuario SET usuario_password=:Password WHERE usuario_id=:ID"
            );
            $updatePassword->bindParam(":Password", $password);
            $updatePassword->bindParam(":ID", $userId, PDO::PARAM_INT);
            $updatePassword->execute();

            $deleteToken = $connection->prepare(
                "DELETE FROM password_reset_tokens WHERE usuario_id=:ID AND token_hash=:Token"
            );
            $deleteToken->bindParam(":ID", $userId, PDO::PARAM_INT);
            $deleteToken->bindParam(":Token", $tokenHash);
            $deleteToken->execute();

            if($deleteToken->rowCount() !== 1){
                $connection->rollBack();
                return false;
            }

            $connection->commit();
            return true;
        }catch(PDOException $exception){
            if($connection->inTransaction()){
                $connection->rollBack();
            }
            throw $exception;
        }
    }
}
