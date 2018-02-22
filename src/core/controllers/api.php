<?php
  // ----------------------------------------
  // faces API endpoint
  // ----------------------------------------

  $format = explode(':', $_GET['format']);
  switch($format[0]) {
    case 'json':
      $output = new API_Output_JSON();
      break;
    case 'xml':
      $output = new API_Output_XML();
      break;
    case 'jsonp':
      $output = new API_Output_JSONP($format[1]);
      break;
    default: die('unknown output format');
  }

  $api = new API( $output, $db );
  $api->query( $_GET['query'] );
  $api->output();
  exit;
?>