<?php

  class Face {
    public $id;
    public $file;
    public $views;
    public $last_view;
    public $added;
    public $category;
    public $enabled;

    public $thumbnail;
    public $popularity;
    public $tags = array();
    public $suggestedTags = array();

    public static function load( $id ) {
      try {
        return new Face( $id );
      } catch( Exception $e ) {
        return false;
      }
    }

    public function __construct( $id ) {
      global $db;

      $sql = 'SELECT id, file, views, last_view, added, category, enabled FROM faces WHERE id='.$id;
      $rs = mysqli_query( $db, $sql );
      $data = mysqli_fetch_array( $rs, MYSQLI_ASSOC );
      if( $data != false ) {
        $this->id         = $data['id'];
        $this->file       = $data['file'];
        $this->views      = $data['views'];
        $this->last_view  = $data['last_view'];
        $this->added      = $data['added'];
        $this->category   = $data['category'];
        $this->enabled    = $data['enabled'];

        $this->thumbnail  = 'thumb_120_'.$data['file'];
        $this->popularity = $this->getPopularity();

        $sql = 'SELECT tag, enabled FROM tags WHERE face='.$id.' ORDER BY tag ASC';
        $rs = mysqli_query( $db, $sql );
        while( $t = mysqli_fetch_array( $rs, MYSQLI_ASSOC )) {

          if( (int)$t['enabled'] == 1 ) {
            array_push( $this->tags, $t['tag'] );
          }
          else {
            array_push( $this->suggestedTags, $t['tag'] );
          }
        };
      }
      else throw new Exception();
    }

    static public function addTag( $args ) {
      global $db, $_CONFIG;
      if( !is_numeric( $args['id'] )
       || $args['id'] < 1
       || strlen( $args['tag'] ) == 0
       //|| ctype_punct( $args['tag'] )) {
       || filter_var( $args['tag'], FILTER_SANITIZE_STRING, array('flags' => array( FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH ))) != $args['tag'] ) {
        $args['success'] = false;
        $args['msg'] = 'You have to enter a valid tag! (only letters A-Z, numbers and spaces)';
      }
      else {
        $sql = "INSERT INTO tags (face,tag,source,enabled) VALUES (".$args['id'].",'".mysqli_real_escape_string( $db, $args['tag'] )."','view',0)";
        $rs = mysqli_query( $db, $sql );
        if( mysqli_affected_rows() == 1 ) {
          $args['success'] = true;
          $args['msg'] = 'Thank you for your help! Your suggestion will be reviewed and published as soon as possible!';

          if( isset( $_CONFIG['admin-email'] ) and strlen($_CONFIG['admin-email']) > 0 ) {
            $from = '"tags@'.t('site-name').'"';
            $subject = t('site-name').' - new face tag';
            $message = 'a new face tag has been added at '.t('site-name').'<br/>
  login at <a href="'.$_CONFIG['baseurl'].'/admin/faces">'.$_CONFIG['baseurl'].'/admin/faces</a> to review it.';

            $mail = new Email( $from, $_CONFIG['admin-email'], $subject, $message );
            $mail->send();
          }
        }
        else {
          $args['success'] = false;
          $args['msg'] = 'This tag already exists for this face. Maybe it has not been reviewed yet - please be patient, it will be checked soon!';
        }
      }
      return $args;
    }

    static public function enableTag( $args ) {
      if( $_SESSION['admin'] !== true ) return false;

      global $db;
      $sql = "UPDATE tags SET enabled=1 WHERE face=".$args['id']." AND tag='".$args['tag']."'";
      $rs = mysqli_query( $db, $sql );
      if( mysqli_affected_rows() == 1 ) {
        $args['success'] = true;
        $args['msg'] = 'The tag "'.$args['tag'].'" has been enabled.';
      }
      else {
        $args['success'] = false;
        $args['msg'] = 'Enabling of tag "'.$args['tag'].'" failed.';
      }
      return $args;
    }

    static public function deleteTag( $args ) {
      if( $_SESSION['admin'] !== true ) return false;

      global $db;
      $sql = "DELETE FROM tags WHERE face=".$args['id']." AND tag='".$args['tag']."'";
      $rs = mysqli_query( $db, $sql );
      if( mysqli_affected_rows() == 1 ) {
        $args['success'] = true;
        $args['msg'] = 'The tag "'.$args['tag'].'" has been deleted.';
      }
      else {
        $args['success'] = false;
        $args['msg'] = 'Deletion of tag "'.$args['tag'].'" failed.';
      }
      return $args;
    }

    private function getPopularity() { // popularity = views per day
      $daysOld = (NOW - $this->added) / 86400;
      if( $daysOld < 1 ) return 0; // we don't divide with zero
      return $this->views/$daysOld;
    }

  }
