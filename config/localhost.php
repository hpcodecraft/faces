<?php

  // site configuration
  $_CONFIG = array(
    'baseurl' => 'http://localhost:8888/Github/faces/', // full base URL

    'app' => array(
      'face' => 'reaction', // change to the theme of your site, e.g.  robot, squirrel, duck (must match the name of your site folder. oh, and don't use spaces)
      'faces' => 'reaction', // plural form, e.g. zombies, robots, ...
      'domain' => 'reactionfac.es', // your TLD
      'cookie' => 'reactionfaces', // cookie namespace (to prevent overwrite on multi-site installations)
      'copytext'  => 'Ctrl+C', // copy hint text for Windows
      'copytextMac'  => 'Cmd+C', // copy hint text for Mac
      'thumbsizes' => array( 120, 150 ), // thumbnail sizes (usually no need to change these)
      //'analytics' => 'UA-xxxxxxxx-x', // optional Google Analytics key
      //'flattr'    => 'http://flattr.com/thing/xxxxxx/My-cool-reaction-face-page', // optional Flattr, put thing URL here to enable Flattr button
      'notificationsTo' => 'your-email-address@example.com', // notifications about submissions and new tags will go there
    ),
  );

  // your database connection details
  $DBHOST = 'localhost';
  $DBUSER = 'root';
  $DBPASS = 'root';
  $DBNAME = 'reactionfaces';

?>