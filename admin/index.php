<?php

  // fac.es admin dispatcher

  session_start();

  require_once( '../bootstrap.php' );

  $_SESSION['admin'] = true; // needed for authed ajax requests
  $_SESSION['admin_override'] = false; // override maintenance & protest pages

  // determine view
  if( !isset( $_GET['p'] ) or $_GET['p'] == '' ) {
    $_GET['p'] = 'dashboard';
  }
  $_page      = $_GET['p'];
  $_page_msg  = '';

  // build page
  $controllerfile = 'controllers/'.$_page.'.php';
  if( file_exists( $controllerfile )) {
    require_once( $controllerfile );
  }

  require_once( 'views/partials/header.php' );
  require_once( '../views/partials/scroller.php' );

  $viewfile = 'views/'.$_page.'.php';
  if( file_exists( $viewfile )) {
    require_once( $viewfile );
  }

  require_once( 'views/partials/footer.php' );
?>