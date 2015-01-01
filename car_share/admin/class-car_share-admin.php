<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Car_share
 * @subpackage Car_share/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Car_share
 * @subpackage Car_share/admin
 * @author     My name <mail@example.com>
 */
class Car_share_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $car_share    The ID of this plugin.
     */
    private $car_share;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @var      string    $car_share       The name of this plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct($car_share, $version) {

        $this->car_share = $car_share;
        $this->version = $version;

        add_action('add_meta_boxes', array($this, 'add_custom_boxes'));
        add_action('save_post', array($this, 'save'));
    }

    /**
     * Register the stylesheets for the Dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Car_share_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Car_share_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->car_share, plugin_dir_url(__FILE__) . 'css/car_share-admin.css', array(), $this->version, 'all');
        
        //wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
        //wp_enqueue_style( 'jquery-ui' );
        
        //wp_enqueue_style($this->car_share . 'jquery-ui', plugin_dir_url(__FILE__) . 'css/datepicker/css/datepicker.css', array(), $this->version, 'all');
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    }

    /**
     * Register the JavaScript for the dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Car_share_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Car_share_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->car_share, plugin_dir_url(__FILE__) . 'js/car_share-admin.js', array('jquery'), $this->version, false);
        wp_enqueue_script( 'jquery-ui-datepicker', false, array(jquery));        
    }

    public function add_custom_boxes($post_id) {

        add_meta_box(
                'locations_box', __('Locations', $this->car_share), array($this, 'locations_box'), 'car'
        );

        add_meta_box(
                'service_price_box', __('Price', $this->car_share), array($this, 'service_price_box'), 'service'
        );
    }



    public function locations_box() {
        global $post;
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'location' AND post_status = 'publish' ORDER BY post_title ASC ";
        $locations = $wpdb->get_results($sql);

        $current_location = get_post_meta($post->ID, '_current_location', true);
        $allowed_locations = get_post_meta($post->ID, '_allowed_location', true);

        include 'partials/car/locations_box.php';
        wp_nonce_field(__FILE__, 'car_nonce');
    }

    ###################################### service ###################

    public function service_price_box() {
        global $post;

        $service_fee = get_post_meta($post->ID, '_service_fee', true);        

        include 'partials/service/price_box.php';
        wp_nonce_field(__FILE__, 'service_fee_nonce');
    }

    public function save() {
        global $post;
        global $wpdb;

        ################ save cars attributes #########################################################
        if (isset($_POST['car_nonce']) && wp_verify_nonce($_POST['car_nonce'], __FILE__)) {
            //
            $keys = array(
                '_current_location',
                '_allowed_location'
            );
            $this->save_post_keys($post->ID, $keys);
        }

        /*
         * saving services attributes 
         */
        if (isset($_POST['service_fee_nonce']) && wp_verify_nonce($_POST['service_fee_nonce'], __FILE__)) {
            update_post_meta($post->ID, '_service_fee', str_replace(',', '.', $_POST['_service_fee']));
        }
    }

    public function save_post_keys($post_id, $keys) {
        foreach ($keys as $key) {
            if (!empty($_POST[$key])) {
                update_post_meta($post_id, $key, $_POST[$key]);
            } else {
                delete_post_meta($post_id, $key);
            }
        }
    }

}
