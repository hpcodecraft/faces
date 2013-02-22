<?php
  $sql = 'SELECT id FROM faces ORDER BY id ASC';
  $rs = mysql_query( $sql, $db );
  while ($data = mysql_fetch_array( $rs, MYSQL_ASSOC )) {
    array_push( $faces, new Face($data['id'] ));
  }

  usort( $faces, 'sortPopularity');
  $limit = 10;
?>