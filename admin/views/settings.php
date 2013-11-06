<ul class="form-group">
  <?php foreach( $confData as $k => $v ):
    if( $v['has_checkbox'] != 1 ) continue;
  ?>
  <li>
    <label>
      <input type="checkbox" name="config[<?=$k?>]" <?=(($v['value'] == 1) ? 'checked="checked"' : '')?>/>Enable <?=$k?>
    </label>
    <i><?=$v['description']?></i>
  </li>
  <?php endforeach; ?>
</ul>

<ul class="form-group">
  <li>
    <h3>Categories</h3>
    <i>Hit Return when editing a category name to save it.</i>
  </li>
  <?php foreach( $_CONFIG['category'] as $c ): if( $c->id == 0 ) continue; ?>
  <li class="category" data-id="<?=$c->id?>" data-weight="<?=$c->weight?>">
    <input type="text" class="category-name" value="<?=$c->name?>">
    <button type="button" class="category-delete">✖</button>
    <button type="button" class="category-up">⬆</button>
    <button type="button" class="category-down">⬇</button>
  </li>
  <?php endforeach; ?>
  <li>
    <input type="text" id="category-add" placeholder="new category">
    <button type="button" class="add">✚</button>
  </li>
</ul>

<ul class="form-group">
  <li>
    <h3>Maintenance override</h3>
    <i>Enable this to be able to view your site when maintenance mode is enabled. The administration tools will always work, regardless of this setting.</i>
  </li>
  <li>
    <label><input type="radio" name="admin_override" value="1" <?php if( $_SESSION['admin_override'] == true ) echo 'checked="checked"'; ?>/>Enabled</label>
  </li>
  <li>
    <label><input type="radio" name="admin_override" value="0" <?php if( $_SESSION['admin_override'] == false) echo 'checked="checked"'; ?>/>Disabled</label>
  </li>
</ul>

<ul class="form-group">
  <li>
    <h3>Thumbnails</h3>
    <i>If thumbnails are missing you should generate new ones.</i>
  </li>
  <li class="thumbnail-status" title="thumbnail status">Thumbnails are <b><?=(count($thumbs) < count($faces))?'missing':'complete';?></b>
  </li>
  <li>
    <label><input type="radio" name="thumb" value="noop" checked="checked"/>Do nothing</label>
  </li>
  <li>
    <label><input type="radio" name="thumb" value="all"/>Generate new thumbnails</label>
  </li>
</ul>