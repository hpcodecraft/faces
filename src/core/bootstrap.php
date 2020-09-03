<?php
  // ----------------------------------------
  // faces bootstrap script
  // ----------------------------------------

  // autoloader
  class Loader {

    static public function init() {
      $loaders = array('autoload_a','autoload_b');
      foreach( $loaders as $l ) {
        self::register( $l );
      }
    }

    static public function register( $loader ) {
      spl_autoload_register( array( 'Loader', $loader ) );
    }

    static private function autoload_a( $class ) {
      if( file_exists( 'core/classes/'.$class.'.php' )) {
        require_once( 'core/classes/'.$class.'.php' );
      }
    }

    static private function autoload_b( $class ) {
      if( file_exists( '../core/classes/'.$class.'.php' )) {
        require_once( '../core/classes/'.$class.'.php' );
      }
    }
  }

  Loader::init();

  // init some time-related stuff
  date_default_timezone_set('Europe/Berlin');
  define('NOW', time());

  // init db
  $db = @mysqli_connect($DBHOST, $DBUSER, $DBPASS, $DBNAME); // or die( 'trying' );

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

  // mysqli_select_db($DBNAME,$db);
  mysqli_query( $db, "SET NAMES 'utf8'" );

  // init config from DB
  $conf = new Config();

  if($view != 'maintenance') {

    if( (int)$conf->maintenance === 1 ) {
      $p = pathinfo($_SERVER['PHP_SELF'] );
      $d = substr( $p['dirname'], -5 );

      session_start();
      $hasOverride = (isset($_SESSION['admin_override'])) ? $_SESSION['admin_override'] : false;

      if( $d != 'admin' and !$hasOverride ) {
        if( (int)$conf->maintenance === 1 ) $jumpTo = 'maintenance';
        header('location: '.$_CONFIG['baseurl'].'/'.$jumpTo );
      }
    }
  }

  // some functions

  function getStats() {
    global $db;
    $sql = 'SELECT COUNT(id) AS total_faces, SUM(views) AS total_views FROM faces WHERE enabled=1';
    $rs = mysqli_query( $db, $sql );
    $stats = mysqli_fetch_assoc( $rs );
    return $stats;
  }

  function sortPopularity( $a, $b ) {
    if( $a->popularity > $b->popularity ) return -1;
    else if( $a->popularity < $b->popularity ) return 1;
    else return 0;
  }

  function sortAdded( $a, $b ) {
    if( $a->added > $b->added ) return -1;
    else if( $a->added < $b->added ) return 1;
    else return 0;
  }

  function detectOS() {
    $ua = $_SERVER["HTTP_USER_AGENT"];
    // Mobile
    if(strpos($ua, 'iPhone')) return array( 'name' => 'iPhone', 'type' => 'Mobile' );
    if(strpos($ua, 'iPad')) return array( 'name' => 'iPad', 'type' => 'Mobile' );
    if(strpos($ua, 'Android')) return array( 'name' => 'Android', 'type' => 'Mobile' );
    if(strpos($ua, 'BlackBerry')) return array( 'name' => 'BlackBerry', 'type' => 'Mobile' );
    // Desktop
    if(strpos($ua, 'Windows')) return array( 'name' => 'Windows', 'type' => 'Desktop' );
    if(strpos($ua, 'Macintosh')) return array( 'name' => 'Macintosh', 'type' => 'Desktop' );
    if(strpos($ua, 'Linux')) return array( 'name' => 'Linux', 'type' => 'Desktop' );
  }

  function getTemplate( $view ) {
    global $_CONFIG;
    $userfile = 'content/templates/'.$view.'.php';
    $worldfile = 'core/templates/'.$view.'.php';
    if( file_exists( $userfile  )) return $userfile;
    else if( file_exists( $worldfile )) return $worldfile;
    else return false;
  }

  // get a text from the config
  function t($id) {
    global $_CONFIG;
    return $_CONFIG['text'][$id];
  }

  // get an asset
  function a($path) {
    global $_CONFIG;
    return $_CONFIG['baseurl'].'/content/'.$path;
  }

  // extend config
  $_CONFIG['sites'] = array(
    'pony' => 'http://ponyfac.es',
    'lauer'=> 'http://lauerfac.es',
  );

  // detect OS and select according copy hint text
  $os = detectOS();
  $copytext = t('copy-win');
  if( $os['name'] == 'Macintosh' ) $copytext = t('copy-mac');

  // set up ordering
  $_CONFIG['order'] = array(
    'id' => 'Default order',
    'popularity' => 'Most popular',
    'added' => 'Newest',
  );

  // load categories
  $_CONFIG['category'] = array( 0 => new Category( 0, 'All faces', 0 ));
  $sql = 'SELECT `id`, `name`, `weight` FROM categories ORDER BY weight ASC';
  $rs = mysqli_query( $db, $sql );
  while( $data = mysqli_fetch_assoc( $rs )) {
    $c = new Category( (int)$data['id'], $data['name'], $data['weight'] );
    $_CONFIG['category'][$c->id] = $c;
  }

  // some variables
  $faces    = array();
  $stats    = getStats();
?>
