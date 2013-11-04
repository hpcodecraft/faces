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
      <a class="logo" href="<?=$root?>/">
        <h1><?=t('site-name').' - '.$_page?></h1>
      </a>
      <div id="message" class="message"><?=$_page_msg?></div>

      <div class="misc">
        <a class="back" href="../">back to page →</a>
      </div>
    </header>

    <nav>
      <a href="dashboard">dashboard</a>
      <a href="faces">faces</a>
      <a href="import">import</a>
      <a href="changelog">changelog</a>
      <a href="settings">settings</a>
      <a href="logs">logs</a>
    </nav>

    <section class="<?=$_page?>">