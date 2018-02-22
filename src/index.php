<?php
  // ----------------------------------------
  // faces dispatcher
  // ----------------------------------------

  // load config for this host
  require_once( 'config/'.$_SERVER['SERVER_NAME'].'.php' );

  // determine view
  if( !isset( $_GET['page'] )) $view = 'main';
  else $view = $_GET['page'];

  // bootstrap application
  require_once( 'core/bootstrap.php' );

  $controllerfile = 'core/controllers/'.$view.'.php';
  if( file_exists( $controllerfile )) {
    require_once( $controllerfile );
  }

  // include templates
  require_once getTemplate( 'partials/header' );
  if( $view == 'maintenance' ) {
    require_once getTemplate( $view );
    exit;
  }

  if( !( $view == 'single' or $view == 'error' )) {
    require_once getTemplate( 'partials/nav' );
  }

  require_once getTemplate( 'partials/scroller' );
  require_once getTemplate( $view );
  require_once getTemplate( 'partials/footer' );
?>