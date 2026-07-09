<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once './view/inc/head.php'; ?>
</head>

<body>
  <?php
    require_once "./controller/viewController.php";
    // instancia al controlador vista
    $ins_view = new viewController();
    $view = $ins_view->get_view_controller();
    
    if ($view == "login" || $view == "recovery" || $view == "404") :
      require_once "./view/content/" . $view . "-view.php";
    else :
    
  ?>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <?php include_once './view/inc/sidebar.php'; ?>

    <div class="admin-main">
      <?php include_once 'view/inc/navbar.php'; ?>

      <main class="dashboard-content">
        <?php
          include $view;
        ?>
      </main>

      <?php include_once './view/inc/footer.php'; ?>
    </div>
  </div>
  <?php endif; ?>
  <?php include_once './view/inc/script.php'; ?>
</body>
</html>
