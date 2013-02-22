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
      $rs = mysql_query( $sql, $db );
      $data = mysql_fetch_array( $rs, MYSQL_ASSOC );
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
        $rs = mysql_query( $sql, $db );
        while( $t = mysql_fetch_array( $rs, MYSQL_ASSOC )) {

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
        $sql = "INSERT INTO tags (face,tag,source,enabled) VALUES (".$args['id'].",'".mysql_real_escape_string( $args['tag'] )."','view',0)";
        $rs = mysql_query( $sql, $db );
        if( mysql_affected_rows() == 1 ) {
          $args['success'] = true;
          $args['msg'] = 'Thank you for your help! Your suggestion will be reviewed and published as soon as possible!';

          if( isset( $_CONFIG['app']['notificationsTo'] ) and strlen($_CONFIG['app']['notificationsTo']) > 0 ) {
            $from = '"tags@'.$_CONFIG['app']['domain'].'" <tags@'.$_CONFIG['app']['domain'].'>';
            $subject = $_CONFIG['app']['domain'].' - new face tag';
            $message = 'a new face tag has been added at '.$_CONFIG['app']['domain'].'<br/>
  login at <a href="'.$_CONFIG['app']['baseurl'].'/admin/faces">'.$_CONFIG['app']['baseurl'].'/admin/faces</a> to review it.';

            $mail = new Email( $from, $_CONFIG['app']['notificationsTo'], $subject, $message );
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
      $rs = mysql_query( $sql, $db );
      if( mysql_affected_rows() == 1 ) {
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
      $rs = mysql_query( $sql, $db );
      if( mysql_affected_rows() == 1 ) {
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