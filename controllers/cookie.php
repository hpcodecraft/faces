<?php
	$cookie = new Cookie($_CONFIG['app']['cookie']);
	$cookie->load();

	// set order
	if( in_array( $_POST['order'], array_keys($_CONFIG['order']) )) {
		$cookie->data->order = $_POST['order'];
	}

	// set category
	if( in_array( $_POST['category'], array_keys($_CONFIG['category']) )) {
		$cookie->data->category = $_POST['category'];
	}

	$cookie->save();

	echo json_encode( $cookie->data );
	exit;
?>