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

  // build page
  $controllerfile = 'controllers/'.$_page.'.php';
  if( file_exists( $controllerfile )) {
    require_once( $controllerfile );
  }

  require_once( 'views/partials/header.php' );
  require_once( '../core/views/partials/scroller.php' );

  $viewfile = 'views/'.$_page.'.php';
  if( file_exists( $viewfile )) {
    require_once( $viewfile );
  }

  require_once( 'views/partials/footer.php' );
?>