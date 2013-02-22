<?php

  class Config {

    private $_data;

    public function __construct() {
      global $db;
      $sql = 'SELECT `key`, `value`, `has_checkbox`, `description` FROM settings';
      $rs = mysql_query( $sql, $db );
      while( $data = mysql_fetch_array( $rs )) {
        $this->_data[$data['key']] = $data;
      }
    }

    public function __get( $key ) {
      if( $key == '*' ) {
        return $this->_data;
      }
      if( isset( $this->_data[$key] ))
        return $this->_data[$key]['value'];
      else
        return false;
    }

    public function __set( $key, $value ) {
      $this->_data[$key]['value'] = $value;
    }

    public function save() {
      global $db;
      foreach( $this->_data as $k => $v ) {
        $sql = "UPDATE settings SET `value`='".$v['value']."' WHERE `key`='".$k."'";
        mysql_query( $sql, $db );
      }
    }

  }

?>