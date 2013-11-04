<?php

  class API_Output_JSONP {

    private $callback;

    public function __construct( $callback ) {
      $this->callback = $callback;
    }

    public function handle( $data ) {
      header('Cache-Control: no-cache, must-revalidate');
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
      echo $this->callback."(".json_encode( $data ).");";
    }
  }

?>