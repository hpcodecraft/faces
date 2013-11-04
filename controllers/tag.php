<?php
  if( $_GET['tag'] == '' ) header('Location: ../');

  $cookie = new Cookie($_CONFIG['cookie']);
  $cookie->load();

  $_GET['tag'] = mysql_real_escape_string( $_GET['tag'] );

  $sql = "SELECT DISTINCT t.face FROM tags t LEFT JOIN faces f ON t.face=f.id WHERE f.enabled=1 AND t.tag='".$_GET['tag']."' ORDER BY t.face ASC";
  $rs = mysql_query( $sql, $db );
  while ($data = mysql_fetch_assoc( $rs )) {
    $f = new Face($data['face'] );
    array_push( $faces, $f );
  }
?>