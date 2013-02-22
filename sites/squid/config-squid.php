<?php

  $_CONFIG = array(
    // site configuration
    'app' => array(
      'face' => 'squid', // change to the theme of your site, e.g.  robot, squirrel, duck (must match the name of your site folder. oh, and don't use spaces)
      'faces' => 'squid', // plural form, e.g. zombies, robots, ...
      'domain' => 'squidfac.es', // your TLD
      'cookie' => 'squidfaces', // cookie namespace (to prevent overwrite on multi-site installations)
      'baseurl' => 'http://squidfac.es', // full base URL
      'copytext'  => 'Ctrl+C', // copy hint text for Windows
      'copytextMac'  => 'Cmd+C', // copy hint text for Mac
      'thumbsizes' => array( 120, 150 ), // thumbnail sizes (usually no need to change these)
      //'analytics' => 'UA-xxxxxxxx-x', // optional Google Analytics key
      //'flattr'    => 'http://flattr.com/thing/xxxxxx/My-cool-reaction-face-page', // optional Flattr, put thing URL here to enable Flattr button
      'notificationsTo' => 'your-email-address@example.com', // notifications about submissions and new tags will go there
    ),
  );

  // Your localhost setup
  if( $_SERVER['HTTP_HOST'] == $localname or $_SERVER['HTTP_HOST'] == $lanname or $_SERVER['SERVER_ADDR'] == $localaddr ) {
    $DBHOST = 'localhost';
    $DBUSER = 'root';
    $DBPASS = 'root';
    $DBNAME = 'squidfac.es';
    $_CONFIG['app']['baseurl'] = 'http://'.$lanname.'/Web/fac.es'; // set your localhost url here
  }
  // Your live setup
  else
  {
    $DBHOST = '';
    $DBUSER = '';
    $DBPASS = '';
    $DBNAME = '';
  }

?>