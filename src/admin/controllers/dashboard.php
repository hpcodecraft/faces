<?php
  $sql = 'SELECT id FROM faces ORDER BY id ASC';
  $rs = mysql_query( $sql, $db );
  while ($data = mysql_fetch_array( $rs, MYSQL_ASSOC )) {
    array_push( $faces, new Face($data['id'] ));
  }

  mysql_free_result($rs);

  usort( $faces, 'sortPopularity');
  $limit = 10;

  // data for column "newest"
  $newest = $faces;
  usort( $newest, 'sortAdded');
  $newest = array_slice( $newest, 0, $limit );

  // data for column "most popular"
  $best = array_slice( $faces, 0, $limit );

  // data for column "most unpopular"
  $worst = array_slice( array_reverse($faces), 0, $limit );
?>