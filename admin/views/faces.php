<?php
  function drawCategorySelectBox( $face ) {
    global $_CONFIG;
    $html = '<select name="face['.$face->id.'][category]" id="category_'.$face->id.'">';
    foreach( $_CONFIG['category'] as $c ) {
      if( $c->id == 0 ) continue; // skip "All faces"
      $selected = '';
      if( $face->category == $c->id ) $selected = ' selected="selected"';
      $html.= '<option value="'.$c->id.'"'.$selected.'>'.$c->name.'</option>';
    }
    $html.= '</select>';
    return $html;
  }

  function drawTagList( $face ) {
    $html = '<ul id="tags_'.$f->id.'" class="taglist">
              <li><b>tags</b></li>';

    foreach( $face->tags as $t ) {
    $html.= '<li class="edittag_'.$face->id.'" data-tag="'.$t.'">
              '.$t.'
              <button class="edittag-cancel" data-face="'.$face->id.'" data-tag="'.$t.'">✖</button>
            </li>';
    }

    $html.= '</ul>';
    return $html;
  }

?>
<ul>
  <li class="col">
    <h3>new tags</h3>
    <ul>
      <?php
        foreach( $facesNewTag as $f ):
          $checked = '';
          if( $f->enabled == 1 ) $checked = 'checked="checked"';
      ?>

        <li class="fullwidth">
          <a href="<?=$_CONFIG['baseurl']?>/<?=$f->id?>" target="_new">
            <div class="thumb" style="background-image:url(<?=a('thumbs/'.$f->thumbnail)?>)">
            </div>
          </a>

          <div class="info">
            <b>#<?=$f->id?></b><br/>
            <label for="enabled_<?=$f->id?>">enabled</label>
            <input type="checkbox" id="enabled_<?=$f->id?>" name="face[<?=$f->id?>][enabled]" <?=$checked?>/><br/>

            <label for="category_<?=$f->id?>">category</label>
            <?=drawCategorySelectBox($f)?>
            <?=drawTagList($f)?>

            <ul class="taglist">
              <li><b>new tags</b></li>
              <?php foreach( $f->suggestedTags as $t ): ?>
              <li class="edittag_<?=$f->id?>" data-tag="<?=$t?>">
                <?=$t?>
                <button class="edittag-save" data-face="<?=$f->id?>" data-tag="<?=$t?>">✚</button>
                <button class="edittag-cancel" data-face="<?=$f->id?>" data-tag="<?=$t?>">✖</button>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </li>
  <li class="col">
    <h3>disabled</h3>
    <ul>
      <?php
        foreach( $facesDisabled as $f ):
          $checked = '';
          if( $f->enabled == 1 ) $checked = 'checked="checked"';
      ?>

        <li class="fullwidth">
          <a href="<?=$_CONFIG['baseurl']?>/<?=$f->id?>" target="_new">
            <div class="thumb" style="background-image:url(<?=a('thumbs/'.$f->thumbnail)?>)">
            </div>
          </a>

          <div class="info">
            <b>#<?=$f->id?></b><br/>
            <label for="enabled_<?=$f->id?>">enabled</label>
            <input type="checkbox" id="enabled_<?=$f->id?>" name="face[<?=$f->id?>][enabled]" <?=$checked?>/><br/>

            <label for="category_<?=$f->id?>">category</label>
            <?=drawCategorySelectBox($f)?>
            <?=drawTagList($f)?>
          </div>
        </li>


      <?php endforeach; ?>
    </ul>
  </li>
  <li class="col">
    <h3>enabled</h3>
    <ul>
      <?php
        foreach( $facesEnabled as $f ):
          $checked = '';
          if( $f->enabled == 1 ) $checked = 'checked="checked"';
      ?>

        <li class="fullwidth">
          <a href="<?=$_CONFIG['baseurl']?>/<?=$f->id?>" target="_new">
            <div class="thumb" style="background-image:url(<?=a('thumbs/'.$f->thumbnail)?>)">
            </div>
          </a>

          <div class="info">
            <b>#<?=$f->id?></b><br/>
            <label for="enabled_<?=$f->id?>">enabled</label>
            <input type="checkbox" id="enabled_<?=$f->id?>" name="face[<?=$f->id?>][enabled]" <?=$checked?>/><br/>

            <label for="category_<?=$f->id?>">category</label>
            <?=drawCategorySelectBox($f)?>
            <?=drawTagList($f)?>
          </div>
        </li>

      <?php endforeach; ?>
    </ul>
  </li>
</ul>