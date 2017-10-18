<?php  
/* 
Plugin Name: UKM Media
Plugin URI: http://www.ukm-norge.no
Description: Organisering av UKM Media
Author: UKM Norge / M Mandal 
Version: 1.0 
Author URI: http://mariusmandal.no
*/

if(is_admin()) {
	add_action('admin_menu', 'UKMmedia_menu');
}
add_action('network_admin_menu', 'UKMmedia_network_menu');


// Regular menu
function UKMmedia_menu() {
	require_once('UKM/mediabruker.class.php');
	if( !mediabruker::existsByWpId( get_current_user_id() ) ) {
		return ;
	}
	$page = add_menu_page('UKM Media', 'UKM Media', 'ukm_idebank', 'UKMMedia', 'UKMMedia', 'http://ico.ukm.no/heart-menu.png',3);
	add_action( 'admin_print_styles-' . $page, 'UKMmedia_scripts_and_styles' );	
	
	// LIST UT ALLE IDÉBANKER
	global $ID_ARRANGOR;

	# Bytt til arrangor
	switch_to_blog( UKM_HOSTNAME == 'ukm.dev' ? 13 : 881 );
	
	# Hent alle sider
	$parent_page = get_page_by_path( 'ukmmedia' );
	# Hent alle sider
	$my_wp_query = new WP_Query();
	$children_pages = $my_wp_query->query( array('post_parent' => $parent_page->ID, 'post_type'=>'page', 'posts_per_page' => 100, 'orderby' => 'menu_order', 'order' => 'ASC') );

	# Restore til aktiv side
	### OBS - MÅ GJØRES FØR LOOPEN FOR Å KUNNE LEGGE TIL SIDER (ingen av brukerne har editor på arrangørbloggen!)
	restore_current_blog();

	# Legg til menyelementer og enqueue scripts + styles
	foreach( $children_pages as $child ) {
		$subpage = add_submenu_page('UKMMedia', $child->post_title, $child->post_title, 'ukm_idebank', 'UKMMedia_'.$child->post_name, 'UKMMedia');
		add_action( 'admin_print_styles-' . $subpage, 'UKMmedia_scripts_and_styles' );	
	}
	
}

function UKMmedia_scripts_and_styles(){
	wp_enqueue_script('jQuery-fastlivefilter');

	wp_enqueue_script('WPbootstrap3_js');
	wp_enqueue_style('WPbootstrap3_css');
//	wp_enqueue_style( 'UKMmedia_css', plugin_dir_url( __FILE__ ) .'UKMmediabank.css');
	wp_enqueue_script('UKMmedia_js', plugin_dir_url( __FILE__ ) .'UKMMedia.js' );

}

function UKMMedia() {
	$TWIGdata = array();
	
	$PAGE_SLUG = str_replace('UKMMedia_', '', $_GET['page']);
	switch( $PAGE_SLUG ) {
		case '':
		case 'UKMMedia':
			require_once('controller/home.controller.php');
			$VIEW = 'home';
			break;
		default:
			if( isset( $_GET['subpage'] ) ) {
				$PAGE_SLUG = $PAGE_SLUG .'/'. $_GET['subpage'];
			}
			require_once('controller/page.controller.php');
			$VIEW = 'page';
			break;
	}
	
	$TWIGdata['current_page'] = $_GET['page'];

	echo TWIG($VIEW. '.html.twig', $TWIGdata, dirname(__FILE__));
}

function UKMmedia_network_menu() {
	$page = add_menu_page('UKM Media', 'UKM Media', 'superadmin', 'UKMMedia_network_admin','UKMMedia_network_admin', '//ico.ukm.no/heart-menu.png',2119);
	add_action( 'admin_print_styles-' . $page, 'UKMmedia_scripts_and_styles' );
}

function UKMMedia_network_admin() {
	$TWIGdata = ['page'=>'UKMMedia_network_admin'];
	$VIEW = isset( $_GET['subpage'] ) ? $_GET['subpage'] : 'members';

	require_once('controller/network/'. $VIEW .'.controller.php');
	echo TWIG('network/'. $VIEW. '.html.twig', $TWIGdata, dirname(__FILE__));
}
