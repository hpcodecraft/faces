<?php
	$errorview = 'views/error/'.$e.'.php';
	if( file_exists( $errorview )) {
		require_once( 'views/error/'.$e.'.php' );
	}
?>