
<div class="meta">
  <h3 class="views">
    <?=number_format( $f->views, 0, ',', '.')?> views
  </h3>

  <?php
    foreach( $f->tags as &$tag ) {
      $tag = '<a href="'.$_CONFIG['baseurl'].'/tag/'.$tag.'">'.$tag.'</a>';
    }
  ?>
  <p class="tags">
    <b>tags</b> <?=implode('', $f->tags)?>
    <button id="show-new-tag">add a tag</button>
    <span class="new-tag-form">
      <input type="text" id="newtag" placeholder="enter tag" autofocus>
      <button id="newtag-save">✚</button>
      <button id="newtag-cancel">✖</button>
    </span>
  </p>

  <ul class="embed">
    <li>
      <label>short URL</label>
      <input type="text" value="<?=$_CONFIG['baseurl']?>/<?=$f->id?>" title="<?=$_CONFIG['baseurl']?>/<?=$f->id?>" readonly>
    </li>
    <li>
      <label>BBCode</label>
      <input type="text" value="[url=<?=$_CONFIG['baseurl']?>/<?=$f->id?>][img]<?=$_CONFIG['baseurl']?>/<?=$f->id?>/thumb[/img][/url]" title="[url=<?=$_CONFIG['baseurl']?>/<?=$f->id?>][img]<?=$_CONFIG['baseurl']?>/<?=$f->id?>/thumb[/img][/url]" readonly>
    </li>
    <li>
      <label>HTML</label>
      <input type="text" value='<a href="<?=$_CONFIG['baseurl']?>/<?=$f->id?>" target="_blank"><img src="<?=$_CONFIG['baseurl']?>/<?=$f->id?>/thumb"/></a>' title='<a href="<?=$_CONFIG['baseurl']?>/<?=$f->id?>" target="_blank"><img src="<?=$_CONFIG['baseurl']?>/<?=$f->id?>/thumb"/></a>' readonly>
    </li>
    <li>
      <label>Image URL</label>
      <input type="text" value="<?=$_CONFIG['baseurl']?>/<?=$f->id?>/full" title="<?=$_CONFIG['baseurl']?>/<?=$f->id?>/full" readonly>
    </li>
  </ul>
</div>

<script type="text/javascript">
  var faceId = <?=$f->id?>;
</script>