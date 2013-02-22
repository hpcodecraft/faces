
<?php
  $onlyBackLink = array('changelog','copyright','imprint');
  if( in_array( $view, $onlyBackLink )) :
?>

  <nav>
    <a class="back" href="./">← back</a>
  </nav>

<?php else: ?>

  <nav id="nav-main">
    <ul class="pages">
      <li>
        <a class="page<?=($view=='main')?' active':''?>" href="<?=$root?>/">Faces</a>
      </li>
      <li>
        <a class="page<?=($view=='developer')?' active':''?>" href="<?=$root?>/developer">Developer</a>
      </li>

      <?php if( $conf->submissions == 1 ) : ?>
      <li>
        <a class="page<?=($view=='submit')?' active':''?>" href="<?=$root?>/submit">Submit a <?=$_CONFIG['app']['face']?></a>
      </li>
      <?php endif; ?>
    </ul>

    <?php if( $view == 'main' or $view == 'tag' ): ?>

      <div class="search">
        <input class="query" type="text" id="search" placeholder="search"/>
        <div class="clear" id="search-clear">✖</div>
      </div>

      <div class="spacer">&nbsp;</div>

      <?php if( count( $_CONFIG['category'] ) > 2 ): ?>
      <h4 class="category"><?=$_CONFIG['app']['face']?></h4>
      <ul class="category">
        <?php
          foreach( $_CONFIG['category'] as $c ) {
            echo '<li>
                    <a class="category'.(($cookie->data->category == $c->id) ? ' active': '').'" rel="'.$c->id.'">'.$c->name.'</a>
                  </li>';
          }
        ?>
      </ul>
      <?php endif; ?>

      <?php if( count( $_CONFIG['order'] ) > 1 ): ?>
      <h4 class="order">order</h4>
      <ul class="order">
        <?php
          foreach( $_CONFIG['order'] as $o => $od ) {
            echo '<li>
                  <a class="order'.(($cookie->data->order == $o) ? ' active': '').'" rel="'.$o.'">'.$od.'</a>
                 </li>';
          }
        ?>
      </ul>
      <?php endif; ?>

    <?php endif; ?>

    <?php if( $view == 'developer' ): ?>

    <h4 class="api">API Docs</h4>
    <ul class="api">
      <li><a href="#overview">Overview</a></li>
      <li><a href="#functionality">API Functionality</a></li>
      <li><a href="#response">API Response</a></li>
      <li><a href="#examples">Examples</a>
        <ul style="margin-left:10px;">
          <li><a href="#example1">Single ID</a></li>
          <li><a href="#example2">Multiple ID</a></li>
          <li><a href="#example3">Tag</a></li>
          <li><a href="#example4">Category</a></li>
          <li><a href="#example5">List categories</a></li>
          <li><a href="#example6">List tags</a></li>
        </ul>
      </li>
    </ul>
    <?php endif; ?>

    <ul class="extra">
      <li>
        <a href="http://squidpeople.com/bookmarklets/instaface" target="_blank">Get the Bookmarklet!</a>
      </li>

    </ul>
  </nav>

<?php endif; ?>

  <section class="content <?=$view?>">