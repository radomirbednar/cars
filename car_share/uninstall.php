<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Car_share
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;
$sql = 'DROP TABLE `day_prices`, `opening_hours`, `postmeta_date`, `sc_single_car`, `sc_single_car_location`, `sc_single_car_status`';
$wpdb->query($sql);

delete_option('sc-setting'); 
delete_option('car_plugin_options_arraykey'); 
delete_option('second_set_arraykey');

$args = array(
	'posts_per_page' => -1,
	'post_type' => array(
                'sc-location', 
                'sc-season',
                'sc-car-category',
                'sc-location',
                'sc-location',
                'sc-location',
                'sc-location'
            ),
);
 
$posts = get_posts( $args );
if (is_array($posts)) {
   foreach ($posts as $post) {
// what you want to do;
       wp_delete_post( $post->ID, true);       
   }
}
