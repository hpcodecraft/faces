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

      $this->log( $q );
      global $_CONFIG;

      $this->data = array(
        'unix_date' => NOW,
      );

      if( isset( $q['id'] )) { // search by id

        $stats = getStats();
        $this->data['total_faces'] = $stats['total_faces'];
        $this->data['total_views'] = $stats['total_views'];
        $this->data['items'] = array();

        $error = false;
        $ids = explode(',', $q['id'] );
        foreach( $ids as $id ) { // check if ids are all valid
          if( (int)$id == 0 ) {
            $this->data = null;
            $error = true;
            break;
          }
        }
        if( $error === false ) {
          foreach( $ids as $id ) {
            $f = new Face( $id );
            array_push( $this->data['items'], $this->mapFaceData( $f ));
          }
        }
      }
      else if( isset( $q['tag'] )) { // search by tag

        $stats = getStats();
        $this->data['total_faces'] = $stats['total_faces'];
        $this->data['total_views'] = $stats['total_views'];
        $this->data['items'] = array();

        $tags = mysql_real_escape_string( $q['tag'] );

        $sql = 'SELECT DISTINCT face FROM tags WHERE tag LIKE \'%'.mysql_real_escape_string( $q['tag'] ).'%\'';
        $result = mysql_query( $sql, $this->db );
        while( $data = mysql_fetch_assoc( $result )) {
          array_push( $this->data['items'], $this->mapFaceData( new Face( $data['face'] )));
        };
      }
      else if( isset( $q['cat'] )) { // search by category

        $stats = getStats();
        $this->data['total_faces'] = $stats['total_faces'];
        $this->data['total_views'] = $stats['total_views'];
        $this->data['items'] = array();

        $allowed = array_keys( $_CONFIG['category'] );
        if( in_array( $q['cat'], $allowed )) {
          $sql = 'SELECT id FROM faces WHERE category=\''.mysql_real_escape_string( $q['cat'] ).'\'';
          $result = mysql_query( $sql, $this->db );
          while( $data = mysql_fetch_assoc( $result )) {
            array_push( $this->data['items'], $this->mapFaceData( new Face( $data['id'] )));
          };
        }
        else {
          $this->data = null;
        }
      }
      else if( isset( $q['all'] )) { // search all (tags/cats)
        $this->data['items'] = array();
        if( $q['all'] == 'cats' ) {
          $i = 1;
          foreach( $_CONFIG['category'] as $c => $cd ) {
            array_push( $this->data['items'], array(
              'cat_id' => $i,
              'cat_name' => $c,
              'cat_displayname' => $cd,
            ));
            $i++;
          }
        }
        else if( $q['all'] == 'tags' ) {
          $tags = array();
          $sql = 'SELECT DISTINCT tag FROM tags ORDER BY tag ASC';
          $result = mysql_query( $sql, $this->db );

          while( $data = mysql_fetch_array( $result )) {
            array_push( $this->data['items'], array('tag_name' => $data[0] ));
          }
        }
        else {
          $this->data = null;
        }
      }
    }

    public function output() {
      $this->outputHandler->handle( $this->data );
    }

    private function mapFaceData( Face $f ) {

      global $_CONFIG;

      $fData = array(
        'face_id'        => $f->id,
        'face_views'     => $f->views,
        'face_hidden'    => ( $f->enabled == 1 ) ? 0 : 1,
        'face_category'  => $f->category,
        'face_filename'  => substr( $f->file, 0, -4 ),
        'face_url'       => a('faces/'.$f->file),
        'face_tags'      => implode( ', ', $f->tags ),
        'face_thumbnail' => a('thumbs/thumb_120_'.$f->file),
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