<?php
require_once "./controller/userController.php";
$userController = new userController();
$id = filter_var($page[1] ?? '', FILTER_VALIDATE_INT);
$user = $id !== false && $id > 0 ? $userController->get_user_controller($id) : false;
$escape = static function($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
?>
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-person-vcard" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Gestión</p>
                <h1 class="h3 mb-1">Detalle del usuario</h1>
                <p class="text-muted mb-0">Información de la cuenta seleccionada.</p>
            </div>
        </div>
    </div>

    <?php if(!$user): ?>
        <div class="alert alert-warning mt-3" role="alert">No se encontró el usuario solicitado.</div>
        <a class="btn btn-outline-secondary" href="<?php echo APP_URL; ?>user-list">Volver al listado</a>
    <?php else: ?>
        <section class="panel mt-3">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h2 class="h5 mb-1"><?php echo $escape($user['usuario_nombre']." ".$user['usuario_apellido']); ?></h2>
                    <p class="text-muted mb-0"><?php echo $escape($user['usuario_username']); ?></p>
                </div>
                <span class="badge <?php echo (int)$user['usuario_estatus'] === 1 ? 'text-bg-success' : 'text-bg-secondary'; ?>">
                    <?php echo (int)$user['usuario_estatus'] === 1 ? "Activo" : "Inactivo"; ?>
                </span>
            </div>
            <hr>
            <dl class="row mb-0">
                <dt class="col-sm-3">Correo</dt>
                <dd class="col-sm-9"><?php echo $escape($user['usuario_email']); ?></dd>
                <dt class="col-sm-3">Teléfono</dt>
                <dd class="col-sm-9"><?php echo $escape($user['usuario_telefono']); ?></dd>
                <dt class="col-sm-3">Rol</dt>
                <dd class="col-sm-9"><?php echo $escape($user['rol_descripcion'] ?? "Sin rol"); ?></dd>
                <dt class="col-sm-3">Equipo</dt>
                <dd class="col-sm-9"><?php echo $escape($user['equipo_descripcion'] ?? "Sin equipo"); ?></dd>
            </dl>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="<?php echo APP_URL; ?>user-list">Volver al listado</a>
                <a class="btn btn-primary" href="<?php echo APP_URL; ?>user-edit/<?php echo (int)$user['usuario_id']; ?>">
                    <i class="bi bi-pencil" aria-hidden="true"></i> Modificar usuario
                </a>
            </div>
        </section>
    <?php endif; ?>
</div>
