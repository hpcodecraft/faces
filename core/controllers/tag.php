<?php
  if( $_GET['sub'] == '' ) header('Location: '.$_CONFIG['baseurl']);

  $cookie = new Cookie($_CONFIG['cookie']);
  $cookie->load();

  $_GET['sub'] = mysql_real_escape_string( $_GET['sub'] );

  $sql = "SELECT DISTINCT t.face FROM tags t LEFT JOIN faces f ON t.face=f.id WHERE f.enabled=1 AND t.tag='".$_GET['sub']."' ORDER BY t.face ASC";
  $rs = mysql_query( $sql, $db );
  while ($data = mysql_fetch_assoc( $rs )) {
    $f = new Face($data['face'] );
    array_push( $faces, $f );
  }
?>