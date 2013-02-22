<img id="alert" src="<?=$root?>/sites/<?=$_CONFIG['app']['face']?>/gfx/alert.png"/>
<div id="alerttext">
  <img src="<?=$root?>/sites/<?=$_CONFIG['app']['face']?>/gfx/alertbubble.png"/>
  <div id="alertlabel"></div>
</div>

<h1>faces tagged "<?=$_GET['tag']?>"</h1>

<div id="faces">
  <?php if( count( $faces ) == 0 ): ?>
  <h4>no faces found :(</h4>
  <?php endif; ?>
</div>