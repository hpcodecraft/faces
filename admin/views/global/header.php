<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title><?=$_CONFIG['app']['domain']?> - <?=$_page?></title>

    <?php if( $conf->{'developer mode'} == 1 ): ?>
    <link rel="stylesheet/less" type="text/css" href="../sites/<?=$_CONFIG['app']['face']?>/css/admin-min.less"/>
    <script src="../js/lib/less-1.3.3.min.js"></script>
    <?php else: ?>
    <link rel="stylesheet" href="../sites/<?=$_CONFIG['app']['face']?>/css/min/admin-min.css"/>
    <?php endif; ?>

    <link rel="shortcut icon" href="../sites/<?=$_CONFIG['app']['face']?>/gfx/favicon.png"/>
  </head>

  <body>
    <header>
      <a class="logo" href="<?=$root?>/">
        <h1><?=$_CONFIG['app']['domain']?> - <?=$_page?></h1>
      </a>
      <div id="message" class="message"><?=$_page_msg?></div>

      <div class="misc">
        <?php if( $conf->{'developer mode'} == 1 ): ?>
          <div class="dev">
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