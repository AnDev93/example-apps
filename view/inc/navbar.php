<nav class="navbar admin-navbar navbar-expand bg-white">
    <div class="container-fluid px-3 px-lg-4">
        <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
                <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
           

            <div class="dropdown">
                <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="avatar-img avatar-sm" src="<?php echo APP_URL;?>view/assets/images/avatar/avatar.jpg" alt="Admin Hasan">
                <span class="profile-name d-none d-sm-inline"><?php echo $_SESSION['nombre_ea']; ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Account settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form class="FormularioAjax" action="<?php echo APP_URL ?>router/requestLogin.php" method="POST" data-form="load" autocomplete="off">
                        <input type="hidden" name="id_ea" value="<?php echo $lc->encryption($_SESSION['id_ea']); ?>">
                        <input type="hidden" name="token" value="<?php echo $lc->encryption($_SESSION['token_ea']); ?>">
                        <input type="hidden" name="usuario" value="<?php echo $lc->encryption($_SESSION['usuario_ea']); ?>">
                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                </li>
                </ul>
            </div>
        </div>
    </div>
</nav>