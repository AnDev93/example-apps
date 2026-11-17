<?php
require_once "./controller/userController.php";
$userController = new userController();
$profile = $userController->get_profile_controller();
$escape = static function($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
?>
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Cuenta</p>
                <h1 class="h3 mb-1">Mi perfil</h1>
                <p class="text-muted mb-0">Actualiza tus datos personales.</p>
            </div>
        </div>
    </div>

    <?php if(!$profile): ?>
        <div class="alert alert-warning mt-3" role="alert">No se encontró la cuenta asociada a tu sesión.</div>
    <?php else: ?>
        <section class="row g-3 mt-1">
            <div class="col-12 col-xl-8">
                <form class="panel FormularioAjax" action="<?php echo APP_URL; ?>router/requestUser.php" method="POST" data-form="update" autocomplete="off">
                    <input type="hidden" name="actualizarPerfil" value="1">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-person-lines-fill" aria-hidden="true"></i><span>Datos personales</span></h2>
                            <p class="text-muted mb-0">Los cambios se aplicarán a tu cuenta actual.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="Nombres">Nombres</label>
                            <input class="form-control" id="Nombres" name="Nombres_reg" type="text" value="<?php echo $escape($profile['usuario_nombre']); ?>" maxlength="30" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="Apellidos">Apellidos</label>
                            <input class="form-control" id="Apellidos" name="Apellidos_reg" type="text" value="<?php echo $escape($profile['usuario_apellido']); ?>" maxlength="30" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="Email">Correo electrónico</label>
                            <input class="form-control" id="Email" name="Email_reg" type="email" value="<?php echo $escape($profile['usuario_email']); ?>" maxlength="30" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="Telefono">Teléfono</label>
                            <input class="form-control" id="Telefono" name="Telefono_reg" type="tel" value="<?php echo $escape($profile['usuario_telefono']); ?>" maxlength="15" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="Username">Nombre de usuario</label>
                            <input class="form-control" id="Username" name="Username_reg" type="text" value="<?php echo $escape($profile['usuario_username']); ?>" maxlength="30" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-save" aria-hidden="true"></i> Guardar cambios</button>
                    </div>
                </form>
                <form class="panel FormularioAjax mt-3" action="<?php echo APP_URL; ?>router/requestUser.php" method="POST" data-form="update" data-clear-sensitive autocomplete="off">
                    <input type="hidden" name="cambiarContrasenaPerfil" value="1">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-key" aria-hidden="true"></i><span>Cambiar contraseña</span></h2>
                            <p class="text-muted mb-0">Confirma tu contraseña actual antes de establecer una nueva.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="CurrentPassword">Contraseña actual</label>
                            <input class="form-control" id="CurrentPassword" name="CurrentPassword_reg" type="password" autocomplete="current-password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="NewPassword">Nueva contraseña</label>
                            <input class="form-control" id="NewPassword" name="NewPassword_reg" type="password" autocomplete="new-password" minlength="7" maxlength="30" pattern="[A-Za-z0-9$@.\-]{7,30}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="ConfirmPassword">Confirmar nueva contraseña</label>
                            <input class="form-control" id="ConfirmPassword" name="ConfirmPassword_reg" type="password" autocomplete="new-password" minlength="7" maxlength="30" pattern="[A-Za-z0-9$@.\-]{7,30}" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-shield-lock" aria-hidden="true"></i> Cambiar contraseña</button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-xl-4">
                <section class="panel h-100">
                    <h2 class="h5 mb-3 section-title"><i class="bi bi-shield-lock" aria-hidden="true"></i><span>Datos de acceso</span></h2>
                    <dl class="mb-0">
                        <dt>Rol</dt>
                        <dd><?php echo $escape($profile['rol_descripcion'] ?? "Sin rol"); ?></dd>
                        <dt>Equipo</dt>
                        <dd><?php echo $escape($profile['equipo_descripcion'] ?? "Sin equipo"); ?></dd>
                        <dt>Estatus</dt>
                        <dd><?php echo (int)$profile['usuario_estatus'] === 1 ? "Activo" : "Inactivo"; ?></dd>
                    </dl>
                    <p class="text-muted small mb-0">El rol, el equipo y el estatus son administrados por el sistema.</p>
                </section>
            </div>
        </section>
    <?php endif; ?>
</div>
