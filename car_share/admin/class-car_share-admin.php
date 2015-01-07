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
     * jednotlive kusy aut, napr 5x fabie,
     *
     * @var type
     */
    public static $single_cars = array();

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

        add_action('in_admin_footer', array($this, 'single_car_js'));
    }

    public function single_car_js(){
        include 'partials/car/js-statuses.php';
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
        wp_enqueue_script( 'jquery-ui-datepicker', false, array('jquery'));
    }

    public function add_custom_boxes() {
        /*
        add_meta_box(
                'single_cars_box', __('Single cars', $this->car_share), array($this, 'single_cars_box'), 'sc-car'
        );*/

        global $post;
        $this->load_single_cars($post->ID);

        //$i = 10;

        foreach(Car_share_Admin::$single_cars as $key => $value){
            add_meta_box(
                    'single_car_box_' . $value, sprintf(__('Single car #%d', $this->car_share), $value), array($this, 'single_car_box'), 'sc-car'
            );
            //$i++;
        }
        reset(Car_share_Admin::$single_cars);


        add_meta_box(
                'car_category_box', __('Category', $this->car_share), array($this, 'car_category_box'), 'sc-car'
        );

        add_meta_box(
                'car_details_box', __('Details', $this->car_share), array($this, 'details_box'), 'sc-car'
        );

        add_meta_box(
                'service_price_box', __('Price', $this->car_share), array($this, 'service_price_box'), 'sc-service'
        );

        add_meta_box(
                'service_quantity_box', __('Quantity', $this->car_share), array($this, 'service_quantity_box'), 'sc-service'
        );
    }

    public function single_car_box(){
        global $post;
        global $wpdb;

        $car_id = current(Car_share_Admin::$single_cars);
        next(Car_share_Admin::$single_cars);

        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-location' AND post_status = 'publish' ORDER BY post_title ASC ";
        $locations = $wpdb->get_results($sql);

        $sql = "SELECT location_id FROM sc_single_car_location WHERE single_car_id = '" . (int) $car_id . "' AND location_type = '" . Car_share::PICK_UP_LOCATION . "'";
        $pickup_location = $wpdb->get_col($sql);

        $sql = "SELECT location_id FROM sc_single_car_location WHERE single_car_id = '" . (int) $car_id . "' AND location_type = '" . Car_share::DROP_OFF_LOCATION . "'";
        $dropoff_location = $wpdb->get_col($sql);
        
        $sql = "SELECT * FROM sc_single_car_status WHERE single_car_id = '" . (int) $car_id . "'";
        $statuses = $wpdb->get_results($sql);

        include 'partials/car/single_car.php';
    }

    /*
    public function single_cars_box(){
        global $post;
        global $wpdb;

        //$sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-location' AND post_status = 'publish' ORDER BY post_title ASC ";
        //$locations = $wpdb->get_results($sql);

        include 'partials/car/single_cars_box.php';
    }*/

    public function car_category_box(){
        global $post;
        global $wpdb;

        $current_car_category = get_post_meta($post->ID, '_car_category', true);

        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-car-category' AND post_status IN ('publish', 'pending', 'draft', 'private') ORDER BY post_title DESC";
        $car_categories = $wpdb->get_results($sql);
        include 'partials/car/category.php';

        wp_nonce_field(__FILE__, 'car_nonce');
    }

    /*
    public function locations_box() {
        global $post;
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-location' AND post_status = 'publish' ORDER BY post_title ASC ";
        $locations = $wpdb->get_results($sql);

        $current_location = get_post_meta($post->ID, '_current_location', true);
        $pickup_location = get_post_meta($post->ID, '_pickup_location', true);
        $dropoff_location = get_post_meta($post->ID, '_dropoff_location', true);

        include 'partials/car/locations_box.php';
        wp_nonce_field(__FILE__, 'car_nonce');
    }*/

    public function unavailability_box(){
        include 'partials/car/unavailability_box.php';
    }

    public function details_box(){
        global $post;

        $number_of_seats = get_post_meta($post->ID, '_number_of_seats', true);
        $number_of_doors = get_post_meta($post->ID, '_number_of_doors', true);
        $number_of_suitcases = get_post_meta($post->ID, '_number_of_suitcases', true);
        $transmission = get_post_meta($post->ID, '_transmission', true);

        include 'partials/car/details.php';
    }

    /**
     * @global type $post
     */

    public function service_price_box() {
        global $post;

        $service_fee = get_post_meta($post->ID, '_service_fee', true);
        $per_service = get_post_meta($post->ID, '_per_service', true);

        include 'partials/service/price_box.php';
        wp_nonce_field(__FILE__, 'service_fee_nonce');

    }

    public function service_quantity_box() {
        global $post;

        $service_quantity_box = get_post_meta($post->ID, '_service_quantity_box', true);

        include 'partials/service/quantity_box.php';
        wp_nonce_field(__FILE__, 'service_qt_nonce');

    }

    public function save() {
        global $post;
        global $wpdb;

        /*
        *
        * save car atributs
        *
        */
        if (isset($_POST['car_nonce']) && wp_verify_nonce($_POST['car_nonce'], __FILE__)) {
            //
            $keys = array(
                //'_current_location',
                //'_pickup_location',
                //'_dropoff_location',
                '_number_of_seats',
                '_number_of_doors',
                '_number_of_suitcases',
                '_transmission',
                '_car_category'
            );
            $this->save_post_keys($post->ID, $keys);


            // clean pick up / drop off locations
            $sql = "DELETE FROM sc_single_car_location WHERE single_car_id IN (SELECT single_car_id FROM sc_single_car WHERE parent = '" . $post->ID . "')";
            $wpdb->query($sql);
            
            // clean 
            $sql = "DELETE FROM sc_single_car_status WHERE single_car_id IN (SELECT single_car_id FROM sc_single_car WHERE parent = '" . $post->ID . "')";
            $wpdb->query($sql);            

            
            /*
            if(!empty($_POST['_pickup_location'])){
                foreach($_POST['_pickup_location'] as $car_id => $location_ids){

                    foreach($location_ids as $location_id){

                        $sql = "
                            INSERT INTO
                                sc_single_car_location (single_car_id, location_id, location_type)
                            VALUES (
                                '" . (int) $car_id . "',
                                '" . (int) $location_id . "',
                                '" . Car_share::PICK_UP_LOCATION . "'
                            )
                        ";

                        $wpdb->query($sql);
                    }
                }
            }
            */

            /*
            if(!empty($_POST['_dropoff_location'])){
                foreach($_POST['_dropoff_location'] as $car_id => $location_ids){

                    foreach($location_ids as $location_id){
                        $sql = "
                            INSERT INTO
                                sc_single_car_location (single_car_id, location_id, location_type)
                            VALUES (
                                '" . (int) $car_id . "',
                                '" . (int) $location_id . "',
                                '" . Car_share::DROP_OFF_LOCATION . "'
                            )";

                        $wpdb->query($sql);
                    }
                }
            }
            */



            /*
            if(!empty($_POST['status'])){
                foreach($_POST['status'] as $single_car_id => $car_statuses){
                    foreach($car_statuses as $car_status){

                        $date_from_string = $car_status['from'] . ' ' . sprintf("%02s", $car_status['from_hour']) . ' ' . sprintf("%02s", $car_status['from_min']);
                        $date_from = DateTime::createFromFormat('d.m.Y H i', $date_from_string);
                        
                        $date_to_string = $car_status['to'] . ' ' . sprintf("%02s", $car_status['to_hour']) . ' ' . sprintf("%02s", $car_status['to_min']);
                        $date_to = DateTime::createFromFormat('d.m.Y H i', $date_to_string);

                        $sql = "
                            INSERT INTO
                                sc_single_car_status (single_car_id, date_from, date_to, status)
                            VALUES (
                                '" . $single_car_id . "',
                                '" . (empty($date_from) ? "" : $date_from->format('Y-m-d H:i:s')) . "',
                                '" . (empty($date_to) ? "" : $date_to->format('Y-m-d H:i:s')) . "',
                                '" . (int) $car_status['status'] . "'
                            )";

                        $wpdb->query($sql);
                    }
                }
            }
            */
        }

        /*
         * saving services attributes
         */
        if (isset($_POST['service_fee_nonce']) && wp_verify_nonce($_POST['service_fee_nonce'], __FILE__)) {

            update_post_meta($post->ID, '_service_fee', sanitize_text_field(str_replace(',', '.', $_POST['_service_fee'])));
            //0 - per day 1 - per rental
            update_post_meta($post->ID, '_per_service', $_POST['_per_service']);
        }

        if (isset($_POST['service_qt_nonce']) && wp_verify_nonce($_POST['service_qt_nonce'], __FILE__)) {


            if(ctype_digit($_POST['_service_quantity_box']))
            {
            update_post_meta($post->ID, '_service_quantity_box', $_POST['_service_quantity_box']);
            }
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

    public function load_single_cars($post_id){

        if(!empty(Car_share_Admin::$single_cars)){
            return Car_share_Admin::$single_cars;
        }

        global $wpdb;

        $sql = "
            SELECT
                single_car_id
            FROM
                sc_single_car
            WHERE
                parent = '" . $post_id . "'
            ORDER BY
                single_car_id
            ASC
        ";

        $result = $wpdb->get_col($sql);

        if(!empty($result)){
            self::$single_cars = $result;
        } else {
            Car_share_Admin::$single_cars = array(
                '0' => '1'
            );
        }

        return Car_share_Admin::$single_cars;
    }

}
