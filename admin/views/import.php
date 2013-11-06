<ul>
  <?php foreach( $faces as $f ) :?>
  <li class="col">
    <div class="title"><?=$f['file']?></div>
    <a href="<?=$path?>/<?=$f['file']?>" target="_new">
      <div class="thumb" style="background-image:url(<?=$path?>/<?=$f['file']?>);"></div>
    </a>
    <div class="action">
      <b>action</b>
      <ul>
        <li>
          <input type="radio" id="noop_<?=$f['hash']?>" name="face[<?=$f['file']?>][action]" value="noop" checked="checked"/>
          <label for="noop_<?=$f['hash']?>">do nothing</label>
        </li>
        <li>
          <input type="radio" id="import_<?=$f['hash']?>" name="face[<?=$f['file']?>][action]" value="import"/>
          <label for="import_<?=$f['hash']?>">import</label>
        </li>
        <li>
          <input type="radio" id="reject_<?=$f['hash']?>" name="face[<?=$f['file']?>][action]" value="reject"/>
          <label for="reject_<?=$f['hash']?>">reject</label>
        </li>
      </ul>
    </div>
    <div class="tags">
      <b>suggested tags</b>
      <br/>
      <input type="text" name="face[<?=$f['file']?>][tags]" value="<?=$f['tags']?>"/>
    </div>
  </li>
  <?php endforeach; ?>

  <input type="hidden" name="import" value="true"/>
</ul>