<?php
require_once "./controller/userController.php";
$userController = new userController();
$users = $userController->list_users_controller();
$escape = static function($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
?>
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Gestión</p>
                <h1 class="h3 mb-1">Usuarios</h1>
                <p class="text-muted mb-0">Consulta y administra cuentas, roles, estatus y equipos.</p>
            </div>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Listado de usuarios</span></h2>
                <p class="text-muted mb-0">Total de usuarios registrados: <?php echo count($users); ?></p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <input class="form-control form-control-sm table-search" type="search" placeholder="Buscar usuarios" data-table-search="usersTable" aria-label="Buscar usuarios">
                <a class="btn btn-primary btn-sm" href="<?php echo APP_URL; ?>user-add"><i class="bi bi-person-plus" aria-hidden="true"></i> Agregar usuario</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="usersTable" data-searchable-table>
                <thead>
                    <tr>
                        <th scope="col">Usuario</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Estatus</th>
                        <th scope="col" class="text-end">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($users) === 0): ?>
                        <tr><td class="text-center text-muted py-4" colspan="6">No hay usuarios registrados.</td></tr>
                    <?php else: ?>
                        <?php foreach($users as $user):
                            $id = (int)$user['usuario_id'];
                            $isProtected = $id === 1 || $id === (int)$_SESSION['id_ea'];
                            $isActive = (int)$user['usuario_estatus'] === 1;
                        ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img class="avatar-img avatar-sm" src="<?php echo APP_URL; ?>view/assets/images/avatar/avatar.jpg" alt="">
                                        <div>
                                            <p class="fw-semibold mb-0"><?php echo $escape($user['usuario_nombre']." ".$user['usuario_apellido']); ?></p>
                                            <p class="text-muted small mb-0"><?php echo $escape($user['usuario_username']); ?> · <?php echo $escape($user['usuario_email']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $escape($user['rol_descripcion'] ?? "Sin rol"); ?></td>
                                <td><?php echo $escape($user['equipo_descripcion'] ?? "Sin equipo"); ?></td>
                                <td><?php echo $escape($user['usuario_telefono']); ?></td>
                                <td>
                                    <span class="badge <?php echo $isActive ? 'text-bg-success' : 'text-bg-secondary'; ?>">
                                        <?php echo $isActive ? "Activo" : "Inactivo"; ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex flex-wrap justify-content-end gap-1">
                                        <a class="btn btn-light btn-sm" href="<?php echo APP_URL; ?>user-view/<?php echo $id; ?>" aria-label="Ver usuario <?php echo $escape($user['usuario_username']); ?>">
                                            <i class="bi bi-eye" aria-hidden="true"></i> Ver
                                        </a>
                                        <a class="btn btn-outline-primary btn-sm" href="<?php echo APP_URL; ?>user-edit/<?php echo $id; ?>" aria-label="Modificar usuario <?php echo $escape($user['usuario_username']); ?>">
                                            <i class="bi bi-pencil" aria-hidden="true"></i> Modificar
                                        </a>
                                        <?php if(!$isProtected): ?>
                                            <form class="FormularioAjax d-inline" action="<?php echo APP_URL; ?>router/requestUser.php" method="POST" data-form="update" autocomplete="off">
                                                <input type="hidden" name="cambiarEstatusUsuario" value="1">
                                                <input type="hidden" name="usuario_id" value="<?php echo $id; ?>">
                                                <input type="hidden" name="usuario_estatus" value="<?php echo $isActive ? 0 : 1; ?>">
                                                <button class="btn btn-outline-secondary btn-sm" type="submit">
                                                    <i class="bi bi-toggle-<?php echo $isActive ? 'on' : 'off'; ?>" aria-hidden="true"></i>
                                                    <?php echo $isActive ? "Desactivar" : "Activar"; ?>
                                                </button>
                                            </form>
                                            <form class="FormularioAjax d-inline" action="<?php echo APP_URL; ?>router/requestUser.php" method="POST" data-form="delete" autocomplete="off">
                                                <input type="hidden" name="eliminarUsuario" value="1">
                                                <input type="hidden" name="usuario_id" value="<?php echo $id; ?>">
                                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                                    <i class="bi bi-trash" aria-hidden="true"></i> Eliminar
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
