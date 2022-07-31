<?php
/** 
 * Plugin Name:  Affiliate Filter List 
 * Plugin URI:   
 * Description:  Affiliate Filter List Plugin
 * Version:      0.0.1
 * Author:       
 * Author URI:   
 * License:      
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// 1. customize ACF path
add_filter('acf/settings/path', 'affiliate_acf_settings_path');
 
function affiliate_acf_settings_path( $path ) {
 
    // update path
    $path = plugin_dir_path(__FILE__)  . '/inc/theoptions/';
    
    // return
    return $path;
    
}
 

// 2. customize ACF dir
add_filter('acf/settings/dir', 'affiliate_acf_settings_dir');
 
function affiliate_acf_settings_dir( $dir ) {
 
    // update path

    $dir = plugins_url('/inc/theoptions/', __FILE__);
    
    // return
    return $dir;
    
}
 

// 3. Hide ACF field group menu item
//add_filter('acf/settings/show_admin', '__return_false');


// 4. Include ACF
include_once( plugin_dir_path(__FILE__) . '/inc/theoptions/acf.php' );


//Adds CSS and JS Files
function chr_enqueue_scripts() {
	wp_enqueue_style('chr-style-css', plugins_url('/assets/style.css',__FILE__ ));	
  wp_enqueue_script('affiliate-js',  plugins_url('/assets/affiliate.js', __FILE__ ), array('jquery'), null, true );
  wp_localize_script('affiliate-js',
	'myobj',
	array(
			'home_url'  => get_home_url(),
      'rest_url'  => rest_url(),
      'rest_nounce' => wp_create_nonce( 'wp_rest' ),
  ));

}

add_action('wp_enqueue_scripts', 'chr_enqueue_scripts');
function my_custom_post_types() {
  $labels = array(
    'name'               => _x( 'Bitcoins IRA', 'post type general name' ),
    'singular_name'      => _x( 'Bitcoins IRA', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'Bitcoins IRA' ),
    'add_new_item'       => __( 'Add New Bitcoins IRA' ),
    'edit_item'          => __( 'Edit' ),
    'new_item'           => __( 'New Item' ),
    'all_items'          => __( 'All Items' ),
    'view_item'          => __( 'View Item' ),
    'search_items'       => __( 'Search' ),
    'not_found'          => __( 'No items found' ),
    'not_found_in_trash' => __( 'No itemss found in the Trash' ), 
    'parent_item_colon'  => __( 'Parent Item:', 'text_domain' ),
    'menu_name'          => 'Bitcoins IRA'
  );
  $args = array(
      'labels'        => $labels,
      'description'   => '',
      'public'        => true,
      'supports'      => array( 'title' ),
      'has_archive'   => true,
      'show_in_rest'          => true,
      //'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_base'             => 'bitcoins_ira',
    );
    register_post_type( 'bitcoins_ira', $args ); 
    $labels2 = array(
        'name'               => _x( 'Mortgage Refinance', 'post type general name' ),
        'singular_name'      => _x( 'Mortgage Refinance', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'Mortgage Refinance' ),
        'add_new_item'       => __( 'Add New Mortgage Refinance' ),
        'edit_item'          => __( 'Edit' ),
        'new_item'           => __( 'New Item' ),
        'all_items'          => __( 'All Items' ),
        'view_item'          => __( 'View Item' ),
        'search_items'       => __( 'Search' ),
        'not_found'          => __( 'No items found' ),
        'not_found_in_trash' => __( 'No itemss found in the Trash' ), 
        'parent_item_colon'  => __( 'Parent Item:', 'text_domain' ),
        'menu_name'          => 'Mortgage Refinance'
      );
    $args2 = array(
      'labels'        => $labels2,
      'description'   => '',
      'public'        => true,
      'supports'      => array( 'title'),
      'has_archive'   => true,
      'show_in_rest'          => true,
      'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_base'             => 'mortgage_refinance',
    );
    register_post_type( 'mortgage_refinance', $args2 ); 
    $labels3 = array(
        'name'               => _x( 'Online Banking', 'post type general name' ),
        'singular_name'      => _x( 'Online Banking', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'Online Banking' ),
        'add_new_item'       => __( 'Add New Online Banking' ),
        'edit_item'          => __( 'Edit' ),
        'new_item'           => __( 'New Item' ),
        'all_items'          => __( 'All Items' ),
        'view_item'          => __( 'View Item' ),
        'search_items'       => __( 'Search' ),
        'not_found'          => __( 'No items found' ),
        'not_found_in_trash' => __( 'No itemss found in the Trash' ), 
        'parent_item_colon'  => __( 'Parent Item:', 'text_domain' ),
        'menu_name'          => 'Online Banking'
      );
    $args3 = array(
      'labels'        => $labels3,
      'description'   => '',
      'public'        => true,
      'supports'      => array( 'title'),
      'has_archive'   => true,
      'show_in_rest'          => true,
      'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_base'             => 'online_banking',
    );
    register_post_type( 'online_banking', $args3 ); 
    $labels4 = array(
        'name'               => _x( 'Personal Loans', 'post type general name' ),
        'singular_name'      => _x( 'Personal Loan', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'Personal Loan' ),
        'add_new_item'       => __( 'Add New Personal Loan' ),
        'edit_item'          => __( 'Edit' ),
        'new_item'           => __( 'New Item' ),
        'all_items'          => __( 'All Items' ),
        'view_item'          => __( 'View Item' ),
        'search_items'       => __( 'Search' ),
        'not_found'          => __( 'No items found' ),
        'not_found_in_trash' => __( 'No itemss found in the Trash' ), 
        'parent_item_colon'  => __( 'Parent Item:', 'text_domain' ),
        'menu_name'          => 'Personal Loan'
      );
    $args4 = array(
      'labels'        => $labels4,
      'description'   => '',
      'public'        => true,
      'supports'      => array( 'title'),
      'has_archive'   => true,
      'show_in_rest'          => true,
      'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_base'             => 'personal_loans',
    );
    register_post_type( 'personal_loans', $args4 ); 
    $labels5 = array(
        'name'               => _x( 'Insurance', 'post type general name' ),
        'singular_name'      => _x( 'Insurance', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'Insurance' ),
        'add_new_item'       => __( 'Add New Insurance' ),
        'edit_item'          => __( 'Edit' ),
        'new_item'           => __( 'New Item' ),
        'all_items'          => __( 'All Items' ),
        'view_item'          => __( 'View Item' ),
        'search_items'       => __( 'Search' ),
        'not_found'          => __( 'No items found' ),
        'not_found_in_trash' => __( 'No itemss found in the Trash' ), 
        'parent_item_colon'  => __( 'Parent Item:', 'text_domain' ),
        'menu_name'          => 'Insurance'
      );
    $args5 = array(
      'labels'        => $labels5,
      'description'   => '',
      'public'        => true,
      'supports'      => array( 'title'),
      'has_archive'   => 'insurance-archive',
      'show_in_rest'          => true,
      'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_base'             => 'insurance',
    );
    register_post_type( 'Insurance', $args5 ); 
    $labels6 = array(
        'name'               => _x( 'Business Loans', 'post type general name' ),
        'singular_name'      => _x( 'Business Loan', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'Business Loan' ),
        'add_new_item'       => __( 'Add New Business Loan' ),
        'edit_item'          => __( 'Edit' ),
        'new_item'           => __( 'New Item' ),
        'all_items'          => __( 'All Items' ),
        'view_item'          => __( 'View Item' ),
        'search_items'       => __( 'Search' ),
        'not_found'          => __( 'No items found' ),
        'not_found_in_trash' => __( 'No itemss found in the Trash' ), 
        'parent_item_colon'  => __( 'Parent Item:', 'text_domain' ),
        'menu_name'          => 'Business Loan'
      );
    $args6 = array(
      'labels'        => $labels6,
      'description'   => '',
      'public'        => true,
      'supports'      => array( 'title'),
      'has_archive'   => true,
      'show_in_rest'          => true,
      'rest_controller_class' => 'WP_REST_Posts_Controller',
      'rest_base'             => 'business_loans',
    );
    register_post_type( 'business_loans', $args6 ); 
    $labels7 = array(
      'name'               => _x( 'Gold IRAs', 'post type general name' ),
      'singular_name'      => _x( 'Gold IRA', 'post type singular name' ),
      'add_new'            => _x( 'Add New', 'Gold IRA' ),
      'add_new_item'       => __( 'Add New Gold IRA' ),
      'edit_item'          => __( 'Edit' ),
      'new_item'           => __( 'New Item' ),
      'all_items'          => __( 'All Items' ),
      'view_item'          => __( 'View Item' ),
      'search_items'       => __( 'Search' ),
      'not_found'          => __( 'No items found' ),
      'not_found_in_trash' => __( 'No itemss found in the Trash' ), 
      'parent_item_colon'  => __( 'Parent Item:', 'text_domain' ),
      'menu_name'          => 'Gold IRA'
    );
  $args7 = array(
    'labels'        => $labels7,
    'description'   => '',
    'public'        => true,
    'supports'      => array( 'title'),
    'has_archive'   => true,
    'show_in_rest'          => true,
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'rest_base'             => 'gold_ira',
  );
  register_post_type( 'gold_ira', $args7 ); 
  }
  add_action( 'init', 'my_custom_post_types' );

// Rest API

include_once( plugin_dir_path( __FILE__ ) . '/inc/gold-ira-endpoint.php');
include_once( plugin_dir_path( __FILE__ ) . '/inc/bitcoin-ira-endpoint.php');
include_once( plugin_dir_path( __FILE__ ) . '/inc/mortgage-refinance-endpoint.php');
include_once( plugin_dir_path( __FILE__ ) . '/inc/online-banking-endpoint.php');
include_once( plugin_dir_path( __FILE__ ) . '/inc/personal-loans-endpoint.php');
include_once( plugin_dir_path( __FILE__ ) . '/inc/business-loans-endpoint.php');
include_once( plugin_dir_path( __FILE__ ) . '/inc/insurance-endpoint.php');

//Add shortcodes
include_once( plugin_dir_path(__FILE__) . '/shortcodes.php' );