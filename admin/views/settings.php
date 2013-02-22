<h2>settings</h2>
<form action="settings" method="POST" class="settings">
  <ul>
    <li class="settings-block" id="settings-config">
      <h3>config</h3>
      <i>Manage your site configuration.</i>
      <ul>
        <?php foreach( $confData as $k => $v ):
          if( $v['has_checkbox'] != 1 ) continue;
        ?>
        <li>
          <input type="checkbox" id="config-<?=str_replace(' ','-',$k)?>" name="config[<?=$k?>]" <?=(($v['value'] == 1) ? 'checked="checked"' : '')?>/>
          <label for="config-<?=$k?>">enable <?=$k?>
            <?php if( $k == 'protest' ): ?>
            against <select name="protest_type">
              <?php foreach( $protestTemplates as $t ):
                $val = substr( $t, 0, -4 );
                $checked = '';
                if( $val == $conf->{'protest type'} ) $checked = ' selected';
              ?>
              <option value="<?=$val?>"<?=$checked?>><?=$val?></option>
              <?php endforeach; ?>
            </select>
            <?php endif; ?>
          </label>
          <i><?=$v['description']?></i>
        </li>
        <?php endforeach; ?>
      </ul>
    </li>

    <li class="settings-block" id="setting-categories">
      <h3>categories</h3>
      <i>Hit Return when editing a category name to save it.</i>
      <ul>
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
    </li>

    <li class="settings-block">
      <h3>thumbnails</h3>
      <i>If thumbnails are missing you should generate new ones.</i>
      <ul>
        <li class="thumbnail-status" title="thumbnail sizes: <?php foreach( $thumbSizes as &$size ) $size.='px'; echo implode(', ', $thumbSizes); ?>">
          <?=count($thumbSizes)?> sizes defined, thumbnails <b><?=(count($thumbs)<(count($faces)*count($thumbSizes)))?'missing':'complete';?></b>
        </li>
        <li>
          <input type="radio" id="thumb-noop" name="thumb" value="noop" checked="checked"/>
          <label for="thumb-noop">do nothing</label>
        </li>
        <li>
          <input type="radio" id="thumb-all" name="thumb" value="all"/>
          <label for="thumb-all">generate new thumbnails</label>
        </li>
      </ul>
    </li>

    <li class="settings-block">
      <h3>maintenance/protest override</h3>
      <i>Enable this to be able to view your site when maintenance or protest mode are enabled.<br>
        Note: The admin frontend will always work, regardless of this setting.</i>
      <ul>
        <li>
          <input type="radio" name="admin_override" value="1" id="admin-override-on" <?php if( $_SESSION['admin_override'] == true ) echo 'checked="checked"'; ?>/>
          <label for="admin-override-on">enabled</label>
        </li>
        <li>
          <input type="radio" name="admin_override" value="0" id="admin-override-off" <?php if( $_SESSION['admin_override'] == false) echo 'checked="checked"'; ?>/>
          <label for="admin-override-off">disabled</label>
        </li>
      </ul>
    </li>
  </ul>

  <div class="save">
    <button type="submit" name="submit">save</button>
  </div>
</form>