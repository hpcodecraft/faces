<?php

  $saved = false;

  $skip = array('.', '..'); // skip these when scanning directories

  $confData = $conf->{'*'}; // get config

  // load available protest templates
  $protestTemplates = array_diff( scandir( '../views/protest' ), $skip );

  if( isset( $_POST['submit'] )) {

    // save updated config
    foreach( $confData as $k => $v ) {
      if( $v['has_checkbox'] != 1 ) continue;
      if( isset( $_POST['config'][$k] ) and $_POST['config'][$k] == 'on' ) {
        $conf->{ $k } = 1;

        // save protest mode
        if( $k == 'protest' ) {
          //var_dump($_POST);

          $conf->{'protest type'} = $_POST['protest_type'];
        }
      }
      else $conf->{ $k } = 0;
    }
    $conf->save();
    $confData = $conf->{'*'}; // get updated data
    $saved = true;
  }

  // thumbnail stuff
  $faceDir  = '../content/faces';
  $thumbDir = '../content/thumbs';

  $faces  = array_diff( scandir( $faceDir ), $skip );
  $thumbs = array_diff( scandir( $thumbDir ), $skip );

  $thumbSizes = array( 120, 150 );

  if( isset( $_POST['thumb'] )) {
    if( $_POST['thumb'] == 'all' ) {
      foreach( $faces as $face ) {
        $fi = new Image( $faceDir.'/'.$face );
        foreach( $_CONFIG['thumbsizes'] as $thumbsize ) {
          $fi->createThumbnail( $thumbsize, $thumbDir );
        }
      }
    }
  }

  // maintenance/protest override
  if( isset( $_POST['admin_override'] )) {
    if( $_POST['admin_override'] == true ) {
      $_SESSION['admin_override'] = true;
    }
    else {
      $_SESSION['admin_override'] = false;
    }
  }

  if( $saved ) $_page_msg = 'settings saved!';
?>