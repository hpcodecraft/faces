<?php
  $f = $_GET['f'];

  switch( $f ) {
    case 'rss':
      header ('Content-Type:text/xml');
      readfile('sites/'.$_CONFIG['app']['face'].'/feed/rss.xml');
      break;
    default:
      die;
      break;
  }

  exit;
?>