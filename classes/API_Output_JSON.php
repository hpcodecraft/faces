<?php

  class API_Output_JSON {

    public function handle( $data ) {
      header('Cache-Control: no-cache, must-revalidate');
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
      echo json_encode( $data );
    }
  }

?>