<?php
  // ----------------------------------------
  // faces dispatcher
  // ----------------------------------------

  // load config for this host
  require_once( 'config/'.$_SERVER['SERVER_NAME'].'.php' );

  // bootstrap application
  require_once( 'core/bootstrap.php' );

  // determine view
  if( !isset( $_GET['page'] )) $view = 'main';
  else $view = $_GET['page'];

  $controllerfile = 'core/controllers/'.$view.'.php';
  if( file_exists( $controllerfile )) {
    require_once( $controllerfile );
  }

  // include templates
  require_once getView( 'partials/header' );

  if( !( $view == 'single' or $view == 'error' )) {
    require_once getView( 'partials/nav' );
  }

  require_once getView( 'partials/scroller' );
  require_once getView( $view );
  require_once getView( 'partials/footer' );
?>