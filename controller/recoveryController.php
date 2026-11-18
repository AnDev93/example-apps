<?php
if($peticionAjax){
    require_once "../model/recoveryModel.php";
    require_once "../config/APP.php";
}else{
    require_once "./model/recoveryModel.php";
    require_once "./config/APP.php";
}

class recoveryController extends recoveryModel{
    public function request_password_reset_controller(string $email): array{
        $email = trim($email);
        if(mb_strlen($email, "UTF-8") > 30 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            return [
                "status" => "danger",
                "message" => "Ingresa un correo electrónico válido."
            ];
        }

        $user = $this->find_recovery_user_model($email);
        if($user){
            $token = bin2hex(random_bytes(32));
            $tokenHash = hash("sha256", $token);

            if($this->save_reset_token_model((int)$user["usuario_id"], $tokenHash)){
                $resetUrl = APP_URL . "recovery/?token=" . rawurlencode($token);
                if(!$this->send_recovery_email($user["usuario_email"], $resetUrl)){
                    $this->delete_reset_token_model((int)$user["usuario_id"], $tokenHash);
                }
            }
        }

        return [
            "status" => "success",
            "message" => "Si existe una cuenta asociada a ese correo, recibirás un enlace para restablecer la contraseña. El enlace vence en 30 minutos."
        ];
    }

    public function is_valid_reset_token_controller(string $token): bool{
        if(!preg_match("/\\A[a-f0-9]{64}\\z/", $token)){
            return false;
        }

        return $this->is_valid_reset_token_model(hash("sha256", $token));
    }

    public function reset_password_controller(string $token, string $password, string $confirmation): array{
        if(!preg_match("/\\A[a-f0-9]{64}\\z/", $token)){
            return [
                "status" => "danger",
                "message" => "El enlace de recuperación no es válido o ya venció."
            ];
        }

        if(!preg_match("/\\A[a-zA-Z0-9$@.-]{7,30}\\z/", $password)){
            return [
                "status" => "danger",
                "message" => "La contraseña debe tener entre 7 y 30 caracteres: letras, números, $, @, punto o guion."
            ];
        }

        if($password !== $confirmation){
            return [
                "status" => "danger",
                "message" => "Las contraseñas no coinciden."
            ];
        }

        $tokenHash = hash("sha256", $token);
        if(!$this->reset_password_model($tokenHash, $this->encryption($password))){
            return [
                "status" => "danger",
                "message" => "El enlace de recuperación no es válido o ya venció."
            ];
        }

        return [
            "status" => "success",
            "message" => "Tu contraseña se actualizó correctamente. Ya puedes iniciar sesión."
        ];
    }

    private function send_recovery_email(string $email, string $resetUrl): bool{
        $mailerPath = dirname(__DIR__) . "/vendor/autoload.php";
        $mailConfig = require dirname(__DIR__) . "/config/MAIL.php";
        $encryption = strtolower($mailConfig["encryption"]);

        if(!is_file($mailerPath)
            || $mailConfig["host"] === ""
            || $mailConfig["username"] === ""
            || $mailConfig["password"] === ""
            || !filter_var($mailConfig["from_email"], FILTER_VALIDATE_EMAIL)
            || !in_array($encryption, ["tls", "ssl"], true)
            || $mailConfig["port"] < 1
            || $mailConfig["port"] > 65535
        ){
            error_log("Password recovery SMTP is not configured correctly.");
            return false;
        }

        require_once $mailerPath;

        try{
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $mailConfig["host"];
            $mail->SMTPAuth = true;
            $mail->Username = $mailConfig["username"];
            $mail->Password = $mailConfig["password"];
            $mail->SMTPSecure = $encryption === "ssl"
                ? \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS
                : \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $mailConfig["port"];
            $mail->Timeout = 15;
            $mail->CharSet = "UTF-8";
            $mail->setFrom($mailConfig["from_email"], $mailConfig["from_name"]);
            $mail->addAddress($email);
            $mail->Subject = "Recuperación de contraseña";
            $mail->Body = "Hola,\n\n"
                . "Recibimos una solicitud para restablecer la contraseña de tu cuenta.\n"
                . "Abre este enlace antes de 30 minutos para elegir una nueva contraseña:\n\n"
                . $resetUrl . "\n\n"
                . "Si no solicitaste este cambio, puedes ignorar este mensaje.";
            $mail->send();
            return true;
        }catch(\PHPMailer\PHPMailer\Exception $exception){
            error_log("Password recovery email could not be sent through SMTP.");
            return false;
        }
    }
}
