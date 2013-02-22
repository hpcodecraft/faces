<?php

  $saved = false;

  if( isset( $_POST['changelog-text'] ) and strlen( $_POST['changelog-text'] ) > 0 ) {
    $sql = "INSERT INTO changelog (posted, content) VALUES (".time().",'".$_POST['changelog-text']."')";
    mysql_query( $sql, $db );
    $saved = true;
  }

  $log = array();
  $sql = "SELECT id, posted, content FROM changelog ORDER BY id DESC";
  $rs  = mysql_query( $sql, $db );
  while ($data = mysql_fetch_array( $rs, MYSQL_ASSOC )) {
    array_push( $log, $data );
  }
  mysql_free_result($rs);
  mysql_close();

  if( $saved ) $_page_msg = 'saved new changelog entry!';
?>