<?php
  $log = array(
    'api' => array(),
  );
  $sql = 'SELECT `time`,`ip`,`query` FROM log_api ORDER BY id DESC';
  $rs = mysql_query( $sql, $db );
  while( $data = mysql_fetch_assoc( $rs )) {
    array_push( $log['api'], $data );
  }
?>