<?php

  class API {

    private $outputHandler;
    private $db;
    private $data;

    public function __construct( $outputHandler, $db ) {
      $this->outputHandler = $outputHandler;
      $this->db = $db;
      $this->data = null;
    }

    public function query( $q ) {

      global $_CONFIG, $stats;
      $this->log( $q );

      $q = explode(':', $q);
      $command = $q[0];
      $parameter = $q[1];

      $this->data = array(
        'timestamp' => NOW,
        'total_faces' => $stats['total_faces'],
        'total_views' => $stats['total_views'],
      );

      switch($command) {
        case 'id': // search by id
          $this->data['faces'] = array();
          $ids = explode(',', $parameter );
          foreach( $ids as $id ) {
            if( (int)$id == 0 ) {
              $this->data = null;
              break;
            }
            $f = new Face( $id );
            array_push( $this->data['faces'], $this->mapFaceData( $f ));
          }
          break;

        case 'tag': // search by tag
          $this->data['faces'] = array();
          $tags = mysql_real_escape_string( $parameter );
          $sql = 'SELECT DISTINCT face FROM tags WHERE tag LIKE \'%'.$tags.'%\'';
          $result = mysql_query( $sql, $this->db );
          while( $data = mysql_fetch_assoc( $result )) {
            array_push( $this->data['faces'], $this->mapFaceData( new Face( $data['face'] )));
          };
          break;

        case 'category': // search by category id
          $this->data['faces'] = array();
          $sql = 'SELECT id FROM faces WHERE category=\''.mysql_real_escape_string( $parameter ).'\'';
          $result = mysql_query( $sql, $this->db );
          while( $data = mysql_fetch_assoc( $result )) {
            array_push( $this->data['faces'], $this->mapFaceData( new Face( $data['id'] )));
          }
          break;

        case 'tags': // return all available tags
          $this->data['tags'] = array();
          $sql = 'SELECT DISTINCT tag FROM tags ORDER BY tag ASC';
          $result = mysql_query( $sql, $this->db );
          while( $data = mysql_fetch_array( $result )) {
            array_push( $this->data['tags'], $data[0] );
          }
          break;

        case 'categories': // return all available categories

          $this->data['category'] = array();
          foreach($_CONFIG['category'] as $c) {
            $category = array(
              'id'      => $c->id,
              'name'    => $c->name,
              'weight'  => $c->weight,
            );
            array_push($this->data['category'], $category);
          }
          break;


        default: die('unknown command');
      }
    }

    public function output() {
      $this->outputHandler->handle( $this->data );
    }

    private function mapFaceData( Face $f ) {
      global $_CONFIG;
      $fData = array(
        'id'        => $f->id,
        'views'     => $f->views,
        'enabled'   => $f->enabled,
        'link'      => $_CONFIG['baseurl'].'/'.$f->id,
        'image'     => $_CONFIG['baseurl'].'/'.$f->id.'/full',
        'thumbnail' => $_CONFIG['baseurl'].'/'.$f->id.'/thumb',
        'category'  => array(
          'id'        => $f->category,
          'name'      => $_CONFIG['category'][$f->category]->name,
        ),
        'tags'      => $f->tags,
      );
      return $fData;
    }

    private function log() {
      $time = time();
      $ip = $_SERVER['REMOTE_ADDR'];
      $query = mysql_real_escape_string( htmlentities( $_SERVER['QUERY_STRING'] ));
      $sql = 'INSERT INTO log_api (`time`,`ip`,`query`) VALUES ('.$time.',\''.$ip.'\',\''.$query.'\')';
      mysql_query( $sql, $this->db );
    }
  }

?>