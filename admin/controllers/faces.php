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
      t('site-name'), // title
      t('site-description'), // description
      $_CONFIG['baseurl'] // link
    );

    $rss->setLogo(
      t('site-name'), //title
      a('gfx/feedicon.png'), // src
      $_CONFIG['baseurl'] // link
    );

    $width = 200;
    $sql = 'SELECT id FROM faces WHERE enabled=1 ORDER BY id DESC LIMIT 0,50';
    $rs = mysql_query( $sql, $db );
    while( $data = mysql_fetch_assoc( $rs )) {

      $f         = new Face( $data['id'] );
      $title     = t('face-singular').' #'.$data['id'];
      $link      = $_CONFIG['baseurl'].'/'.$f->id;
      $date      = utf8_encode(date("D, j M Y H:i:s ".'GMT', $f->added ));
      $guid      = $_CONFIG['baseurl'].'/'.$f->id;
      $enclosure = a('faces/'.$f->file);
      $length    = filesize( '../content/faces/'.$f->file );

      $body      = '&lt;p&gt;&lt;img src=&quot;'.htmlentities($enclosure).'&quot; alt=&quot;'.$link.'&quot; width=&quot;'.$width.'&quot; /&gt;&lt;/p&gt;';

      $rss->addItem( $title, $body, $link, $date, $guid, $enclosure, $length );
    }

    $feedUrl = '../content/feed/rss.xml';
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