<?php

  header ('Content-Type:text/xml');

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

  echo $rss->xml();
  exit;
?>