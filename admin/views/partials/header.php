<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title><?=$_CONFIG['app']['domain']?> - <?=$_page?></title>
    <link rel="stylesheet" href="../sites/<?=$_CONFIG['app']['face']?>/css/min/admin-min.css"/>
    <link rel="shortcut icon" href="../sites/<?=$_CONFIG['app']['face']?>/gfx/favicon.png"/>
  </head>

  <body>
    <header>
      <a class="logo" href="<?=$root?>/">
        <h1><?=$_CONFIG['app']['domain']?> - <?=$_page?></h1>
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