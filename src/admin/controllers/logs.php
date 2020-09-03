<?php
  $log = array(
    'api' => array(),
  );
  $sql = 'SELECT `time`,`ip`,`query` FROM log_api ORDER BY id DESC';
  $rs = mysqli_query( $db, $sql );
  while( $data = mysqli_fetch_assoc( $rs )) {
    array_push( $log['api'], $data );
  }
?>
