<?php

  $_form_enabled = true;
  $faces = array();
  $allowed = array('jpg','gif','png','jpeg');

  $path     = '../content/import';
  $dest     = '../content/faces';
  $thumbDir = '../content/thumbs';

  $dir = new DirectoryIterator($path);
  foreach( $dir as $m ) {

    $file = $m->getFilename();

    if( !$m->isDot()
    and in_array( array_pop( explode( '.', $file )), $allowed )
    and substr( $file, 0, 1 ) != '.' ) {


      $hash = hash_file('crc32b', $path.'/'.$file );
      $type = array_pop( explode( '.', $file ));
      if( $type == 'jpeg' ) $type = 'jpg';

      $sql = "SELECT id, tags FROM tag_suggestions WHERE file='".$file."'";
      $rs = mysqli_query( $db, $sql );
      $data = mysqli_fetch_assoc( $rs );

      $face = array('file' => $file, 'hash' => $hash, 'type' => $type, 'tags' => $data['tags'], 'suggestion_id' => $data['id'] );

      if( isset($_POST['face'][$file] )) $face = array_merge( $face, $_POST['face'][$file] );
      $faces[$file] =  $face;
    }
  }

  if( isset( $_POST['submit'] )) {

    // import
    $imported = 0;

    foreach( $faces as $i => $f ) {

      $delete = false;

      switch( $f['action'] ) {

        case 'reject':
          $delete = true;
          break;

        case 'import':
          $sql = 'INSERT INTO faces (file,added,enabled) VALUES(\''.$f['hash'].'.'.$f['type'].'\','.NOW.',0)';
          @mysqli_query( $db, $sql );
          $id = mysqli_insert_id();

          // create tags
          if( strlen( $f['tags'] ) > 0 ) {
            $tags = explode(',',$f['tags']);
            foreach( $tags as $t ) {
              $t    = mysqli_real_escape_string( $db, trim( $t ));
              $sql  = "INSERT INTO tags (face,tag,source,enabled) VALUES(".$id.",'".$t."','import',1)";
              @mysqli_query( $db, $sql );
            }
          }

          // copy file
          copy( $path.'/'.$f['file'], $dest.'/'.$f['hash'].'.'.$f['type'] );

          // create thumbnails
          $fi = new Image( $dest.'/'.$f['hash'].'.'.$f['type'] );
          $fi->createThumbnail( $_CONFIG['thumbsize'], $thumbDir );

          $imported++;
          $delete = true;
          break;
      }

      if( $delete == true ) {
        // delete uploaded file
        unlink( $path.'/'.$f['file'] );
        // delete tag suggestions
        if( (int)$f['suggestion_id'] > 0 ) {
          $sql = 'DELETE FROM tag_suggestions WHERE id='.$f['suggestion_id'];
          @mysqli_query( $db, $sql );
        }

        unset($faces[$i]);
      }

    } // foreach

    if( $imported > 0 ) {
      header('Location: faces');
      exit;
    }
  }
?>
