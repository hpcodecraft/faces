<?php

  // fac.es admin dispatcher

  session_start();

  // load config for this host
  require_once( '../config/'.$_SERVER['SERVER_NAME'].'.php' );
  // bootstrap application
  require_once( '../core/bootstrap.php' );

  $_SESSION['admin'] = true; // needed for authed ajax requests
  $_SESSION['admin_override'] = false; // override maintenance mode

  // determine view
  if( !isset( $_GET['page'] ) or $_GET['page'] == '' ) {
    $_GET['page'] = 'dashboard';
  }
  $_page      = $_GET['page'];
  $_page_msg  = '';
  $_form_enabled = false;

  // build page
  $controllerfile = 'controllers/'.$_page.'.php';
  if( file_exists( $controllerfile )) {
    require_once( $controllerfile );
  }

  require_once( 'templates/partials/header.php' );
  require_once( '../core/templates/partials/scroller.php' );

  $viewfile = 'templates/'.$_page.'.php';
  if( file_exists( $viewfile )) {
    require_once( $viewfile );
  }

  require_once( 'templates/partials/footer.php' );
?>