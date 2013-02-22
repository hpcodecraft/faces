<?php

  // *fac.es dispatcher

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
  require_once getView( 'global/header' );

  if( !( $view == 'single' or $view == 'error' )) {
    require_once getView( 'global/nav' );
  }

  require_once getView( 'global/scroller' );
  require_once getView( $view );
  require_once getView( 'global/footer' );
?>