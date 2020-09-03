<?php
  $cookie = new Cookie($_CONFIG['cookie']);
  $cookie->load();

  $sql = 'SELECT id FROM faces WHERE enabled=1 ORDER BY id ASC';
  $rs = mysqli_query( $db, $sql );
  while ($data = mysqli_fetch_assoc( $rs )) {
    $f = new Face($data['id'] );
    array_push( $faces, $f );
  }
?>
