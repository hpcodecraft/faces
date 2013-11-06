<?php

  if( $view == 'single' ) {
    $meta = array(
      'title'       => t('site-name').' / '.$f->id.' / '.implode(', ', $f->tags),
      'description' => t('site-description'),
      'keywords'    => t('site-keywords').', '.implode(', ', $f->tags),
      'image'       => $_CONFIG['baseurl'].'/'.$f->id.'/thumb',
    );
  }
  else {
    $meta = array(
      'title'       => t('site-title'),
      'description' => t('site-description'),
      'keywords'    => t('site-keywords'),
      'image'       => a('gfx/favicon.png'),
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
  <meta property="og:title" content="<?=$meta['title']?>">
  <meta property="og:image" content="<?=$meta['image']?>">
  <meta name="author" content="Volker Wieban">

  <link rel="stylesheet" href="<?=a('css/app-min.css')?>">
  <link rel="shortcut icon" href="<?=a('gfx/favicon.png')?>">
  <link rel="alternate" type="application/rss+xml" href="<?=$_CONFIG['baseurl']?>/feed/rss" title="<?=t('site-title')?>">
</head>

<body>
  <div class="wrapper <?=$view?>">
    <header class="<?=$view?>">
      <a class="logo" href="<?=$_CONFIG['baseurl']?>"><h1><?=t('site-name')?></h1></a>
      <?php if( $view == 'single' or $view == 'error' ): ?>
      <div id="message"></div>
      <?php elseif( $view == 'main' or $view == 'tag' ): ?>
      <input id="face-url" value="choose a <?=t('face-singular')?>" readonly />
      <?php endif; ?>
    </header>