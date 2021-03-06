<?php
  // ---------------------------------------------------
  // faces sample site configuration for localhost
  // ---------------------------------------------------

  $_CONFIG = array(
    'baseurl' => 'http://localhost', // full base URL, without trailing slash
    'admin-email' => 'johndoe@gmail.com', // notifications about submissions will be sent there
    'cookie' => 'reactionfaces', // cookie namespace
    'thumbsize' => 120, //array( 120 ), // thumbnail sizes (you don't need to change this usually)
    //'analytics' => 'UA-xxxxxxxx-x', // optional: Google Analytics key
    //'flattr'    => 'http://flattr.com/thing/xxxxxx/My-cool-reaction-face-page', // optional: Flattr thing URL

    'text' => array(
      'site-name' => 'reactionfac.es',
      'site-title' => 'reactionfac.es, shoop da whoop!',
      'site-description' => 'a picture is worth a thousand words.',
      'site-keywords' => 'emoticon, smiley, chat, im, sms, gallery',
      'face-singular' => 'reactionface',
      'face-plural' => 'reactionfaces',
      'copy-win' => 'Press Ctrl+C now',
      'copy-mac' => 'Press Cmd+C now',
      'copy-touch' => 'Tap to copy',
    ),
  );

  // your database connection details
  $DBHOST = 'db';
  $DBUSER = 'mysql';
  $DBPASS = 'mysql';
  $DBNAME = 'faces';

?>