<?php
  session_start();

  if( isset( $_POST['cmd'] )) {
    $tmp    = explode( '.', $_POST['cmd'] );
    $class  = $tmp[0];
    $method = $tmp[1];

		try {
			$result = call_user_func ( array($class,$method), $_POST['args'] );
			echo json_encode( $result );
		}
		catch( Exception $e ) {
			$obj    = new $class();
			$result = $obj->{ $method }( $_POST['args'] );
			echo json_encode( $result );
		}
  }

  exit;
?>