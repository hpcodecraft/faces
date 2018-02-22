<?php
  $form_title = '';
  switch($_page) {
    case 'dashboard': $form_title = 'Total image views: '.$stats['total_views']; break;
    case 'faces': $form_title = "Manage your image collection"; break;
    case 'import': $form_title = 'Found '.count($faces).' new images'; break;
    case 'settings': $form_title = 'Site settings'; break;
    case 'logs': $form_title = 'API hits'; break;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title><?=t('site-name').' - '.$_page?></title>
    <link rel="stylesheet" href="<?=a('css/admin-min.css')?>"/>
    <link rel="shortcut icon" href="<?=a('gfx/favicon.png')?>"/>
  </head>

  <body>
    <header>
      <a class="logo" href="<?=$_CONFIG['baseurl']?>/admin">
        <h1><?=t('site-name').' - '.$_page?></h1>
      </a>
      <div id="message" class="message"><?=$_page_msg?></div>

      <div class="misc">
        <a class="back" href="<?=$_CONFIG['baseurl']?>">back to page →</a>
      </div>
    </header>

    <nav>
      <a href="dashboard">dashboard</a>
      <a href="faces">faces</a>
      <a href="import">import</a>
      <a href="settings">settings</a>
      <a href="logs">logs</a>
    </nav>

    <?php if($_form_enabled): ?>
    <form action="<?=$_page?>" method="POST">
    <div class="form-actions">
      <h2><?=$form_title?></h2>
      <button type="submit" name="submit">save</button>
    </div>
    <?php else: ?>
    <div class="form-actions">
      <h2><?=$form_title?></h2>
    </div>
    <?php endif; ?>
    <section class="<?=$_page?>">