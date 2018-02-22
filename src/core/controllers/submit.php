<?php
  $allowed = array( 'gif','png','jpg','jpeg');
  $maxsize = 2048000; // 2MB

  $thisFile = basename( __FILE__, '.php' );

  $msg = null;

  if( isset( $_POST['submit'] )) {

    if( $_FILES['submit_file']['size'] != 0 ) {

      if( $_FILES['submit_file']['size'] <= $maxsize ) {

        $file = basename($_FILES['submit_file']['name']);
        $suffix = array_pop( explode( '.', $file ));
        if( in_array( $suffix, $allowed )) {

          $uploaddir = '../content/import';
          $uploadfile = $uploaddir.'/'.$file;

          if (move_uploaded_file($_FILES['submit_file']['tmp_name'], $uploadfile)) {
            // save tags
            if( strlen( $_POST['submit_tags'] ) > 0 ) {
              $tags = mysql_real_escape_string( $_POST['submit_tags'] );
              $sql = "INSERT INTO tag_suggestions (file,tags,from_import) VALUES('".$file."','".$tags."',1)";
              mysql_query( $sql, $db );
            }
            $msg = 'Your face has been submitted, thanks!';

            if( isset( $_CONFIG['admin-email'] ) and strlen($_CONFIG['admin-email']) > 0 ) {
              $from = '"submission@'.t('site-name').'"';
              $subject = t('site-name').' - new face submission';
              $message = 'a new face has been submitted at '.t('site-name').'<br/>
  login at <a href="'.$_CONFIG['baseurl'].'/admin/import">'.$_CONFIG['baseurl'].'/admin/import</a> to review it.';

              $mail = new Email( $from, $_CONFIG['admin-email'], $subject, $message );
              $mail->send();
            }
          }
        }
        else $msg = 'Error: Filetype "'.$suffix.'" is not allowed';
      }
      else $msg = 'Error: Your file is too big (max. '.$maxsize.' bytes)';
    }
    else $msg = 'Error: You selected no file for uploading.';
  }
?>