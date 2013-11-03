<?php

  // save changes
  if( isset( $_POST['face'] )) {
    foreach( $_POST['face'] as $id => $data ) {

      if( isset( $data['enabled'] ) and $data['enabled'] == 'on' ) $enabled = 1;
      else $enabled = 0;

      $sql = "UPDATE faces SET enabled=".$enabled.", category='".$data['category']."' WHERE id=".$id;
      mysql_query($sql);
    }
  }

  // load from db
  $faces = array();

  $rs = mysql_query( 'SELECT id FROM faces ORDER BY id DESC', $db );
  while ($data = mysql_fetch_array( $rs, MYSQL_ASSOC )) {
    array_push( $faces, $data['id'] );
  }
  mysql_free_result($rs);
  mysql_close();

  if( isset( $_POST['refresh_feeds'] ) and $_POST['refresh_feeds'] == 'on' ) {

    $rss = new RSS();
    $rss->setMeta(
      $_CONFIG['app']['domain'], // title
      $_CONFIG['app']['domain'].' - '.'say it with a '.$_CONFIG['app']['face'], // description
      $_CONFIG['baseurl'] // link
    );

    $rss->setLogo(
      $_CONFIG['app']['domain'].' - '.'say it with a '.$_CONFIG['app']['face'], //title
      $_CONFIG['baseurl'].'/sites/'.$_CONFIG['app']['face'].'/gfx/feedicon.png', // src
      $_CONFIG['app']['domain'] // link
    );

    $width = 200;
    $sql = 'SELECT id FROM faces WHERE enabled=1 ORDER BY id DESC LIMIT 0,50';
    $rs = mysql_query( $sql, $db );
    while( $data = mysql_fetch_assoc( $rs )) {

      $f         = new Face( $data['id'] );
      $title     = $_CONFIG['app']['domain'].'/'.$data['id'];
      $link      = $_CONFIG['baseurl'].'/'.$f->id;
      $date      = utf8_encode(date("D, j M Y H:i:s ".'GMT', $f->added ));
      $guid      = $_CONFIG['baseurl'].'/'.$f->id;
      $enclosure = $_CONFIG['baseurl'].'/sites/'.$_CONFIG['app']['face'].'/faces/'.$f->file;
      $length    = filesize( '../sites/'.$_CONFIG['app']['face'].'/faces/'.$f->file );

      $body      = '&lt;p&gt;&lt;img src=&quot;'.htmlentities($enclosure).'&quot; alt=&quot;'.$link.'&quot; width=&quot;'.$width.'&quot; /&gt;&lt;/p&gt;';

      $rss->addItem( $title, $body, $link, $date, $guid, $enclosure, $length );
    }

    $feedUrl = '../sites/'.$_CONFIG['app']['face'].'/feed/rss.xml';
    unlink( $feedUrl );
    $rss->save( $feedUrl );
  }


  // sort faces into different arrays
  $facesNewTag    = array();
  $facesDisabled  = array();
  $facesEnabled   = array();

  foreach( $faces as $id ) {
    $f = new Face( $id );

    if( count( $f->suggestedTags ) > 0 )
      array_push( $facesNewTag, $f );
    else if( $f->enabled == 0 )
      array_push( $facesDisabled, $f );
    else if( $f->enabled == 1 )
      array_push( $facesEnabled, $f );
  }
?>