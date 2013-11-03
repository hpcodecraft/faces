<?php
  // ----------------------------------------
  // faces dispatcher
  // ----------------------------------------

  require_once( 'bootstrap.php' );

  // determine view
  if( !isset( $_GET['p'] )) {
    $view = 'main';
  }
  else {
    $view = $_GET['p'];
  }

  $controllerfile = 'controllers/'.$view.'.php';
  if( file_exists( $controllerfile )) {
    require_once( $controllerfile );
  }

  if( $view == 'tag' or $view == 'error' ) $root = '..';

  // include templates
  require_once getView( 'partials/header' );

  if( !( $view == 'single' or $view == 'error' )) {
    require_once getView( 'partials/nav' );
  }

  require_once getView( 'partials/scroller' );
  require_once getView( $view );
  require_once getView( 'partials/footer' );
?>