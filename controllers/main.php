<?php
  $cookie = new Cookie($_CONFIG['app']['cookie']);
  $cookie->load();

  $sql = 'SELECT id FROM faces WHERE enabled=1 ORDER BY id ASC';
  $rs = mysql_query( $sql, $db );
  while ($data = mysql_fetch_assoc( $rs )) {
    $f = new Face($data['id'] );
    array_push( $faces, $f );
  }
?>