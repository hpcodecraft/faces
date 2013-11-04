<?php
  $fid = (int)$_GET['face'];

  try {
    $f = new Face( $fid );
  }
  catch( Exception $e ) {
    header('Location: '.$_CONFIG['baseurl'].'/error/404');
    exit;
  }

  // increment views
  $f->views++;
  mysql_query('UPDATE faces SET views='.$f->views.',last_view='.NOW.' WHERE id='.$f->id, $db );

  // get id of previous face
  $sql  = "SELECT id FROM faces WHERE id < ".$f->id." AND enabled=1 ORDER BY id DESC LIMIT 0,1";
  $rs   = mysql_query( $sql, $db );
  $prev = @mysql_result( $rs, 0, 0 );
  if( $prev == false ) {
    $sql  = "SELECT MAX(id) FROM faces WHERE enabled=1";
    $rs   = mysql_query( $sql, $db );
    $prev = mysql_result( $rs, 0, 0 );
  }

  // get id of next face
  $sql  = "SELECT id FROM faces WHERE id > ".$f->id." AND enabled=1 ORDER BY id ASC LIMIT 0,1";
  $rs   = mysql_query( $sql, $db );
  $next = @mysql_result( $rs, 0, 0 );
  if( $next == false ) {
    $sql  = "SELECT MIN(id) FROM faces WHERE enabled=1";
    $rs   = mysql_query( $sql, $db );
    $next = mysql_result( $rs, 0, 0 );
  }

?>