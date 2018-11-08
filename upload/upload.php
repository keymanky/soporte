<?php
    session_start();
    $id = $_SESSION['id'];


	if ( !empty( $_FILES ) ){

	    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
	    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];
	    move_uploaded_file( $tempPath, $uploadPath );
	}

	$post = [
	    'id' => $id,
	    'archivo' => 'upload/uploads/' . substr($uploadPath, strrpos($uploadPath,"\\")+1)
	];


	$ch = curl_init( 'http://207.254.73.11:888/detexis/soporte/api/subir' );
	# Setup request to send json via POST.
	$payload = json_encode( $post );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	# Return response instead of printing.
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	# Send request.
	$result = curl_exec($ch);
	curl_close($ch);
	echo $result
?>