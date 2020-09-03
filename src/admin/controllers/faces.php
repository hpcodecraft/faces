<?php

  $_form_enabled = true;

  // save changes
  if( isset( $_POST['submit'] )) {

    foreach( $_POST['face'] as $id => $data ) {

      if( isset( $data['enabled'] ) and $data['enabled'] == 'on' ) $enabled = 1;
      else $enabled = 0;

      $sql = "UPDATE faces SET enabled=".$enabled.", category='".$data['category']."' WHERE id=".$id;
      mysqli_query( $db, $sql );
    }
  }

  // load from db
  $faces = array();

  $rs = mysqli_query( $db, 'SELECT id FROM faces ORDER BY id DESC' );
  while ($data = mysqli_fetch_array( $rs, MYSQLi_ASSOC )) {
    array_push( $faces, $data['id'] );
  }
  mysqli_free_result($rs);
  mysqli_close();

  // sort faces into different arrays
  $facesNewTag    = array();
  $facesDisabled  = array();
  $facesEnabled   = array();

  foreach( $faces as $id ) {
    $f = new Face( $id );

    if( count( $f->suggestedTags ) > 0 )
      array_push( $facesNewTag, $f );
    else if( $f->enabled == 0 )
      array_push( $facesDisabled, $f );
    else if( $f->enabled == 1 )
      array_push( $facesEnabled, $f );
  }
?>
