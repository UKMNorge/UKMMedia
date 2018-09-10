<?php
$sql = new SQL('SELECT  
				`id`,
				CONCAT(`first_name`," ", `last_name`) AS `name`,
				`phone`
				FROM `ukm_user` 
				ORDER BY `first_name`, `last_name`, `phone`', array(), 'ukmdelta');
$res = $sql->run();

while( $row = SQL::fetch( $res ) ) {
	$TWIGdata['delta_users'][] = $row;
}


// The Query
global $wpdb;
$users = $wpdb->get_results("SELECT * FROM $wpdb->users LIMIT 100000" );

foreach ( $users as $user ) {
	$userdata = new stdClass();
	$userdata->id = $user->ID;
	$userdata->username = $user->user_login;
	$userdata->name = $user->user_nicename;
	$TWIGdata['wp_users'][] = $userdata;
}
