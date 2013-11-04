<?php
  if( is_numeric( $_GET['face'] )) {

    $f = Face::load( $_GET['face'] );

    if( $f ) {

      $tmp = explode( '.', $f->file );
      $type = $tmp[1];

      switch( $type ) {

        case 'png':
          header('Content-Type: image/png');
          break;

        case 'gif':
          header('Content-Type: image/gif');
          break;

        case 'jpg':
        case 'jpeg':
          header('Content-Type: image/jpeg');
          break;

        default: die('no image');
      }

      readfile('../content/faces/'.$f->file);
    }
    else header('location: '.$_CONFIG['baseurl'].'/error/404');

  }
  else header('location: '.$_CONFIG['baseurl'].'/error/404');

  exit;
?>