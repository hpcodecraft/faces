<?php
  $fid = (int)$_GET['sub'];

  try {
    $f = new Face( $fid );
  }
  catch( Exception $e ) {
    header('Location: '.$_CONFIG['baseurl'].'/error/404');
    exit;
  }

  // increment views
  $f->views++;
  mysqli_query($db, 'UPDATE faces SET views='.$f->views.',last_view='.NOW.' WHERE id='.$f->id );

  // get id of previous face
  $sql  = "SELECT id FROM faces WHERE id < ".$f->id." AND enabled=1 ORDER BY id DESC LIMIT 0,1";
  $rs   = mysqli_query( $db, $sql );
  $prev = @mysqli_fetch_field( $rs );
  if( $prev == false ) {
    $sql  = "SELECT MAX(id) FROM faces WHERE enabled=1";
    $rs   = mysqli_query( $db, $sql );
    $prev = mysqli_fetch_field( $rs );
  }

  // get id of next face
  $sql  = "SELECT id FROM faces WHERE id > ".$f->id." AND enabled=1 ORDER BY id ASC LIMIT 0,1";
  $rs   = mysqli_query( $db, $sql );
  $next = @mysqli_fetch_field( $rs );
  if( $next == false ) {
    $sql  = "SELECT MIN(id) FROM faces WHERE enabled=1";
    $rs   = mysqli_query( $db, $sql );
    $next = mysqli_fetch_field( $rs );
  }

?>
