<div class="container-fluid px-3 px-lg-4 py-4">
  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Gestión</p>
        <h1 class="h3 mb-1">Agregar usuario</h1>
        <p class="text-muted mb-0">Crea una nueva cuenta de usuario con roles y asignaciones de equipo.</p>
      </div>
    </div>
  </div>
  <section class="row g-3">
    <div class="col-12 col-xl-8">
      <form class="panel FormularioAjax" action="<?php echo APP_URL; ?>router/requestUser.php" method="POST" data-form="save" autocomplete="off" >
        <div class="panel-header"><div><h2 class="h5 mb-1 section-title"><i class="bi bi-person-plus" aria-hidden="true"></i><span>User Information</span></h2><p class="text-muted mb-0">Crea una cuenta de usuario con campos validados.</p></div></div>
        <input type="hidden" name="guardarUsuario" value="1">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label" for="Nombres">Nombres</label>
            <input class="form-control" id="Nombres" name="Nombres_reg" type="text" required>
            <div class="invalid-feedback">
              El campo nombres Es requerido.
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="Apellidos">Apellidos</label>
            <input class="form-control" id="Apellidos" name="Apellidos_reg" type="text" required>
            <div class="invalid-feedback">
              El campo apellidos Es requerido.
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="Email">Email</label>
            <input class="form-control" id="Email" name="Email_reg" type="email" required>
            <div class="invalid-feedback">Ingrese un correo valido</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="Telefono">Telefono</label>
            <input class="form-control" id="Telefono" name="Telefono_reg" type="tel" required>
            <div class="invalid-feedback">El campo telefono Es requerido.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="Rol">Rol</label>
            <select class="form-select" id="Rol" name="Rol_reg" required>
              <option value="">Choose role</option>
              <option value="1">Admin</option>
              <option value="2">Manager</option>
              <option value="3">Editor</option>
              <option value="4">Viewer</option>
            </select>
            <div class="invalid-feedback">Elige un rol.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="Equipo">Equipo</label>
            <select class="form-select" id="Equipo" name="Equipo_reg" required>
              <option value="">Choose team</option>
              <option value="1">Operations</option>
              <option value="2">Sales</option>
              <option value="3">Content</option>
              <option value="4">Finance</option>
            </select>
            <div class="invalid-feedback">Choose a team.</div>
          </div>
          <div class="col-md-12">
            <label class="form-label" for="username">usuario</label>
            <input class="form-control" id="username" name="Username_reg" type="text" required>
            <div class="invalid-feedback">El campo usuario es requerido.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="password">Contraseña</label>
            <input class="form-control" id="password" name="Password_reg" type="password" required>
            <div class="invalid-feedback">El campo contraseña es requerido.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="password">Confirmar Contraseña</label>
            <input class="form-control" id="password_confirm" name="Password_confirm_reg" type="password" required>
            <div class="invalid-feedback">El campo confirmar contraseña es requerido.</div>
          </div>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
          
          <button class="btn btn-outline-secondary" type="reset">
            Cancel
          </button>
          <button class="btn btn-primary" type="submit">
            <i class="bi bi-person-check" aria-hidden="true"></i> Create User
          </button>
        </div>
      </form>
    </div>
    <div class="col-12 col-xl-4">
      <div class="panel h-100">
        <h2 class="h5 mb-3 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Access Checklist</span></h2>
        <div class="activity-list">
          <div class="activity-item"><span class="activity-dot bg-success"></span><div><p class="mb-1 fw-semibold">Assign role</p><p class="text-muted small mb-0">Start with the least privileged role.</p></div></div>
          <div class="activity-item"><span class="activity-dot bg-primary"></span><div><p class="mb-1 fw-semibold">Add team</p><p class="text-muted small mb-0">Team ownership controls dashboards.</p></div></div>
          <div class="activity-item"><span class="activity-dot bg-warning"></span><div><p class="mb-1 fw-semibold">Send invite</p><p class="text-muted small mb-0">Users receive activation by email.</p></div></div>
        </div>
      </div>
    </div>
  </section>
</div>
      