<?php
require_once('UKM/mediabrukere.collection.php');

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require_once('UKM/mediabruker.class.php');
	$mediabruker = write_mediabruker::create( $_POST['delta-bruker'], $_POST['wordpress-bruker'], $_POST['region']);

#	var_dump( $mediabruker );

	if( is_object( $mediabruker ) && $mediabruker->getDeltaId() == $_POST['delta-bruker'] ) {
		$TWIGdata['message'] = array('level'=>'success', 'message'=>'Bruker lagt til!');
	} else {
		$TWIGdata['message'] = array('level'=>'danger', 'message'=>'Brukeren ble dessverre ikke lagt til');
	}
}

$collection = new mediabrukere_collection();

$TWIGdata['brukere'] = $collection->getAll();