<?php
require_once "./config/APP.php";
require_once "./controller/recoveryController.php";

if(!isset($_SESSION["recovery_csrf"]) || !is_string($_SESSION["recovery_csrf"])){
    $_SESSION["recovery_csrf"] = bin2hex(random_bytes(32));
}

$recovery = new recoveryController();
$feedback = null;
$requestMethod = $_SERVER["REQUEST_METHOD"] ?? "GET";
$actionInput = $_POST["recovery_action"] ?? "";
$action = $requestMethod === "POST" && is_string($actionInput) ? $actionInput : "";
$resetTokenInput = $_GET["token"] ?? $_POST["reset_token"] ?? "";
$resetToken = is_string($resetTokenInput) ? $resetTokenInput : "";
$resetMode = $resetToken !== "";

if($requestMethod === "POST"){
    $csrfTokenInput = $_POST["csrf_token"] ?? "";
    $csrfToken = is_string($csrfTokenInput) ? $csrfTokenInput : "";
    if(!hash_equals($_SESSION["recovery_csrf"], $csrfToken)){
        $feedback = [
            "status" => "danger",
            "message" => "La solicitud expiró. Recarga la página e inténtalo nuevamente."
        ];
    }elseif($action === "request"){
        $emailInput = $_POST["recovery_email"] ?? "";
        $feedback = $recovery->request_password_reset_controller(
            is_string($emailInput) ? $emailInput : ""
        );
    }elseif($action === "reset"){
        $passwordInput = $_POST["new_password"] ?? "";
        $confirmationInput = $_POST["confirm_password"] ?? "";
        $feedback = $recovery->reset_password_controller(
            $resetToken,
            is_string($passwordInput) ? $passwordInput : "",
            is_string($confirmationInput) ? $confirmationInput : ""
        );
    }else{
        $feedback = [
            "status" => "danger",
            "message" => "No se pudo procesar la solicitud."
        ];
    }
}

$resetTokenValid = $resetMode && $recovery->is_valid_reset_token_controller($resetToken);
?>
<button class="icon-button theme-toggle auth-theme-toggle" type="button" data-theme-toggle aria-label="Cambiar tema" title="Cambiar tema">
    <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
</button>
<main class="auth-page">
    <section class="auth-card">
        <a class="auth-brand" href="<?php echo APP_URL; ?>login/">
            <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
            <span><strong>adminHMD</strong><small>Recuperación de acceso</small></span>
        </a>

        <?php if($feedback !== null): ?>
            <div class="alert alert-<?php echo htmlspecialchars($feedback["status"], ENT_QUOTES, "UTF-8"); ?>" role="status" aria-live="polite">
                <?php echo htmlspecialchars($feedback["message"], ENT_QUOTES, "UTF-8"); ?>
            </div>
        <?php endif; ?>

        <?php if($resetMode): ?>
            <?php if($feedback !== null && $action === "reset" && $feedback["status"] === "success"): ?>
                <h1 class="h3 mb-2">Contraseña actualizada</h1>
                <p class="text-muted">Ya puedes ingresar con tu nueva contraseña.</p>
                <a class="btn btn-primary w-100" href="<?php echo APP_URL; ?>login/">Volver al inicio de sesión</a>
            <?php elseif($resetTokenValid): ?>
                <h1 class="h3 mb-2">Crear nueva contraseña</h1>
                <p class="text-muted mb-4">Elige una contraseña de entre 7 y 30 caracteres.</p>
                <form action="<?php echo APP_URL; ?>recovery/?token=<?php echo rawurlencode($resetToken); ?>" method="POST" autocomplete="off">
                    <input type="hidden" name="recovery_action" value="reset">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION["recovery_csrf"], ENT_QUOTES, "UTF-8"); ?>">
                    <input type="hidden" name="reset_token" value="<?php echo htmlspecialchars($resetToken, ENT_QUOTES, "UTF-8"); ?>">
                    <div class="mb-3">
                        <label class="form-label" for="newPassword">Nueva contraseña</label>
                        <input class="form-control" id="newPassword" name="new_password" type="password" minlength="7" maxlength="30" pattern="[A-Za-z0-9$@.\-]{7,30}" autocomplete="new-password" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="confirmPassword">Confirmar nueva contraseña</label>
                        <input class="form-control" id="confirmPassword" name="confirm_password" type="password" minlength="7" maxlength="30" pattern="[A-Za-z0-9$@.\-]{7,30}" autocomplete="new-password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Guardar contraseña</button>
                </form>
            <?php else: ?>
                <h1 class="h3 mb-2">Enlace no válido o vencido</h1>
                <p class="text-muted">Solicita un nuevo enlace para recuperar el acceso a tu cuenta.</p>
                <a class="btn btn-primary w-100" href="<?php echo APP_URL; ?>recovery/">Solicitar otro enlace</a>
            <?php endif; ?>
        <?php else: ?>
            <h1 class="h3 mb-2">¿Olvidaste tu contraseña?</h1>
            <p class="text-muted mb-4">Ingresa el correo asociado a tu cuenta y te enviaremos un enlace de recuperación.</p>
            <form action="<?php echo APP_URL; ?>recovery/" method="POST" autocomplete="off">
                <input type="hidden" name="recovery_action" value="request">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION["recovery_csrf"], ENT_QUOTES, "UTF-8"); ?>">
                <div class="mb-4">
                    <label class="form-label" for="recoveryEmail">Correo electrónico</label>
                    <input class="form-control" id="recoveryEmail" name="recovery_email" type="email" maxlength="30" autocomplete="email" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Enviar enlace de recuperación</button>
            </form>
        <?php endif; ?>

        <p class="auth-footer mb-0"><a href="<?php echo APP_URL; ?>login/">Volver al inicio de sesión</a></p>
    </section>
</main>
