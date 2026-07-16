<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once './view/inc/head.php'; ?>
</head>

<body>
  <?php
    $peticionAjax=false;
    require_once "./controller/viewController.php";
    // instancia al controlador vista
    $ins_view = new viewController();
    $view = $ins_view->get_view_controller();
    
    if ($view == "login" || $view == "recovery" || $view == "404") :
      require_once "./view/content/" . $view . "-view.php";
    else :
      session_start(['name'=>'EA']);
        
      $page=explode("/", $_GET['views']);

      require_once "./controller/loginController.php";
      $lc = new loginController();

      if(!isset($_SESSION['token_ea']) || !isset($_SESSION['usuario_ea'])){
        $lc->force_log_out_controller();
        exit();
      }
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
