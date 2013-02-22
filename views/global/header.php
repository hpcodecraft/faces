<?php

  if( $view == 'single' ) {
    $meta = array(
      'title'       => $_CONFIG['app']['domain'].' / '.$f->id.' / '.implode(', ', $f->tags),
      'description' => 'Collection of '.$_CONFIG['app']['face'].'faces. For instant messaging, imageboards, twitter, text messages, SMS, etc.',
      'keywords'    => $_CONFIG['app']['face'].' faces, '.$_CONFIG['app']['face'].'faces, '.$_CONFIG['app']['face'].'face, face, '.$_CONFIG['app']['face'].', gallery, collection, list, source, sms, '.implode(', ', $f->tags),
      'image'       => $_CONFIG['app']['baseurl'].'/'.$f->id.'/thumb',
    );
  }
  else {
    $meta = array(
      'title'       => $_CONFIG['app']['domain'].' - say it with a '.$_CONFIG['app']['face'],
      'description' => 'Collection of '.$_CONFIG['app']['face'].'faces. For instant messaging, imageboards, twitter, text messages, SMS, etc.',
      'keywords'    => $_CONFIG['app']['face'].' faces, '.$_CONFIG['app']['face'].'faces, '.$_CONFIG['app']['face'].'face, face, '.$_CONFIG['app']['face'].', gallery, collection, list, source, sms, twitter, facebook',
      'image'       => $_CONFIG['app']['baseurl'].'/sites/'.$_CONFIG['app']['face'].'/gfx/favicon.png',
    );
  }

?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
  <title><?=$meta['title']?></title>
  <meta name="description" content="<?=$meta['description']?>">
  <meta name="keywords" content="<?=$meta['keywords']?>">
  <meta property="og:title" content="<?=$_CONFIG['app']['domain']?> - say it with a <?=$_CONFIG['app']['face']?>">
  <meta property="og:image" content="<?=$meta['image']?>">

  <?php if( $conf->{'developer mode'} == 1 ): ?>
  <link rel="stylesheet/less" type="text/css" href="<?=$root?>/sites/<?=$_CONFIG['app']['face']?>/css/app-min.less">
  <script src="<?=$root?>/js/lib/less-1.3.3.min.js"></script>
  <?php else: ?>
  <link rel="stylesheet" href="<?=$root?>/sites/<?=$_CONFIG['app']['face']?>/css/min/app-min.css">
  <?php endif; ?>

  <link rel="shortcut icon" href="<?=$root?>/sites/<?=$_CONFIG['app']['face']?>/gfx/favicon.png">
  <link rel="alternate" type="application/rss+xml" href="<?=$root?>/feed/rss" title="<?=$_CONFIG['app']['face']?>feed">
</head>

<body>
  <div class="wrapper <?=$view?>">
    <header class="<?=$view?>">
      <a class="logo" href="<?=$root?>/"><h1><?=$_CONFIG['app']['domain']?></h1></a>
      <?php if( $view == 'single' or $view == 'error' ): ?>
      <div id="message"></div>
      <?php elseif( $view == 'main' ): ?>
      <input id="face-url" value="choose a <?=$_CONFIG['app']['face']?>" readonly />
      <?php endif; ?>

      <?php if( $conf->{'developer mode'} == 1 ): ?>
        <div style="position: absolute; top: .5em; right: 1em;">
          <form action="<?=$root?>/" method="post">
            <select name="_SITE">
              <?php foreach( $sites as $s ): ?>
              <option value="<?=$s?>" <?=($_SITE==$s)?'selected':''?>><?=$s?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit">▶</button>
          </form>
        </div>
      <?php endif; ?>
    </header>