<?php	
require_once('WPOO/WPOO/Post.php');
require_once('WPOO/WPOO/Author.php');

$TWIGdata['image_path'] = 'http://arrangor.'.UKM_HOSTNAME.'/';

switch_to_blog( UKM_HOSTNAME == 'ukm.dev' ? 13 : 881 );
	$page = get_page_by_path( 'ukmmedia/'.$PAGE_SLUG );
	$TWIGdata['page'] = new WPOO_Post( $page );	
restore_current_blog();
$TWIGdata['image_path'] = 'http://arrangor.ukm.no/';