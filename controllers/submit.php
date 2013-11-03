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

          $uploaddir = 'import';
          $uploadfile = $uploaddir.'/'.$file;

          if (move_uploaded_file($_FILES['submit_file']['tmp_name'], $uploadfile)) {
            // save tags
            if( strlen( $_POST['submit_tags'] ) > 0 ) {
              $tags = mysql_real_escape_string( $_POST['submit_tags'] );
              $sql = "INSERT INTO tag_suggestions (file,tags,from_import) VALUES('".$file."','".$tags."',1)";
              mysql_query( $sql, $db );
            }
            $msg = 'Your face has been submitted, thanks!';

            if( isset( $_CONFIG['app']['notificationsTo'] ) and strlen($_CONFIG['app']['notificationsTo']) > 0 ) {
              $from = '"submission@'.$_CONFIG['app']['domain'].'" <submission@'.$_CONFIG['app']['domain'].'>';
              $subject = $_CONFIG['app']['domain'].' - new face submission';
              $message = 'a new face has been submitted at '.$_CONFIG['app']['domain'].'<br/>
  login at <a href="'.$_CONFIG['baseurl'].'/admin/import">'.$_CONFIG['baseurl'].'/admin/import</a> to review it.';

              $mail = new Email( $from, $_CONFIG['app']['notificationsTo'], $subject, $message );
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