<?php
  // *fac.es API

  if( isset( $_GET['out'] ) and $_GET['out'] == 'xml' )
    $output = new API_Output_XML();
  else if( isset( $_GET['callback'] ))
    $output = new API_Output_JSONP( $_GET['callback'] );
  else
    $output = new API_Output_JSON();

  unset( $_GET['callback'] );
  unset( $_GET['out'] );

  $api = new API( $output, $db );
  $api->query( $_GET );
  $api->output();

  exit;
?>