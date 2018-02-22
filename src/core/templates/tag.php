<img id="alert" src="<?=a('gfx/alert.png')?>"/>
<div id="alerttext">
  <img src="<?=a('gfx/alertbubble.png')?>"/>
  <div id="alertlabel"><?=$copytext?></div>
</div>
<div id="faces">
  <?php if( count( $faces ) == 0 ): ?>
  <h4>no faces found :(</h4>
  <?php endif; ?>
</div>