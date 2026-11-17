<?php
require_once "./controller/userController.php";
require_once "./model/mainModel.php";
$userController = new userController();
$userFormModel = new mainModel();
$id = filter_var($page[1] ?? '', FILTER_VALIDATE_INT);
$user = $id !== false && $id > 0 ? $userController->get_user_controller($id) : false;
$escape = static function($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
?>
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-person-gear" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Gestión</p>
                <h1 class="h3 mb-1">Modificar usuario</h1>
                <p class="text-muted mb-0">Actualiza la información de la cuenta.</p>
            </div>
        </div>
    </div>

    <?php if(!$user): ?>
        <div class="alert alert-warning mt-3" role="alert">No se encontró el usuario solicitado.</div>
        <a class="btn btn-outline-secondary" href="<?php echo APP_URL; ?>user-list">Volver al listado</a>
    <?php else: ?>
        <form class="panel FormularioAjax mt-3" action="<?php echo APP_URL; ?>router/requestUser.php" method="POST" data-form="update" autocomplete="off">
            <input type="hidden" name="editarUsuario" value="1">
            <input type="hidden" name="usuario_id" value="<?php echo (int)$user['usuario_id']; ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="Nombres">Nombres</label>
                    <input class="form-control" id="Nombres" name="Nombres_reg" type="text" value="<?php echo $escape($user['usuario_nombre']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="Apellidos">Apellidos</label>
                    <input class="form-control" id="Apellidos" name="Apellidos_reg" type="text" value="<?php echo $escape($user['usuario_apellido']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="Email">Correo</label>
                    <input class="form-control" id="Email" name="Email_reg" type="email" value="<?php echo $escape($user['usuario_email']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="Telefono">Teléfono</label>
                    <input class="form-control" id="Telefono" name="Telefono_reg" type="tel" value="<?php echo $escape($user['usuario_telefono']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="Rol">Rol</label>
                    <select class="form-select" id="Rol" name="Rol_reg" required>
                        <option value="" disabled>Seleccione un rol</option>
                        <?php echo $userFormModel->generar_select_db("rol", "rol_id", "rol_descripcion", (int)$user['usuario_rol'], "rol_estatus"); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="Equipo">Equipo</label>
                    <select class="form-select" id="Equipo" name="Equipo_reg" required>
                        <option value="" disabled>Seleccione un equipo</option>
                        <?php echo $userFormModel->generar_select_db("equipo", "equipo_id", "equipo_descripcion", (int)$user['usuario_equipo'], "equipo_estatus"); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="Username">Nombre de usuario</label>
                    <input class="form-control" id="Username" name="Username_reg" type="text" value="<?php echo $escape($user['usuario_username']); ?>" required>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="<?php echo APP_URL; ?>user-list">Cancelar</a>
                <button class="btn btn-primary" type="submit"><i class="bi bi-save" aria-hidden="true"></i> Guardar cambios</button>
            </div>
        </form>
    <?php endif; ?>
</div>
