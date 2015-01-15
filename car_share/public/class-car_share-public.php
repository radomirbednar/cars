<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Car_share
 * @subpackage Car_share/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Car_share
 * @subpackage Car_share/public
 * @author     My name <mail@example.com>
 */
class Car_share_Public {

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
     * @var      string    $car_share       The name of the plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct($car_share, $version) {

        $this->car_share = $car_share;
        $this->version = $version;
        
        add_action('wp_ajax_nopriv_refresh_checkout_price', array($this, 'ajax_refresh_checkout_price'));
        add_action('wp_ajax_refresh_checkout_price', array($this, 'ajax_refresh_checkout_price'));

        //shordcode for the page Search for a car
        /* add_shortcode('searchforacar', array($this, 'car_share_searchforacar'));*/
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Car_share_Public_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Car_share_Public_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->car_share, plugin_dir_url(__FILE__) . 'css/car_share-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Car_share_Public_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Car_share_Public_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        /*
         * WE NEED DAPICKER 
         */
        
        wp_enqueue_script('jquery-ui-datepicker', array('jquery-ui-core'), $this->version, true); 
        wp_enqueue_script($this->car_share, plugin_dir_url(__FILE__) . 'js/car_share-public.js', array('jquery'), $this->version, true);
    } 
    /** 
     */
    public function register_custom_post() {

        // cars
        $args = array(
            'labels' => array(
                'name' => __('Cars', $this->car_share),
                'singular_name' => __('Car', $this->car_share),
                'add_new' => __('Add new', $this->car_share),
                'add_new_item' => __('Add new car', $this->car_share),
                'edit_item' => __('Edit car', $this->car_share),
                'new_item' => __('New car', $this->car_share),
                'all_items' => __('All cars', $this->car_share),
                'view_item' => __('View car', $this->car_share),
                'search_items' => __('Search car', $this->car_share),
                'menu_name' => __('Cars', $this->car_share)
            ),
            'public' => true,
            'show_ui' => true,
            'supports' => array(
                'thumbnail',
                'title',
                'editor',
                //'page-attributes'
            ),
            'hierarchical' => false
        );

        register_post_type('sc-car', $args);

        // locations
        $args = array(
            'labels' => array(
                'name' => __('Location', $this->car_share),
                'singular_name' => __('Location', $this->car_share),
                'add_new' => __('Add new', $this->car_share),
                'add_new_item' => __('Add new location', $this->car_share),
                'edit_item' => __('Edit location', $this->car_share),
                'new_item' => __('New location', $this->car_share),
                'all_items' => __('All locations', $this->car_share),
                'view_item' => __('View location', $this->car_share),
                'search_items' => __('Search locations', $this->car_share),
                'menu_name' => __('Locations', $this->car_share)
            ),
            'public' => true,
            'show_ui' => true,
            'supports' => array(
                'thumbnail',
                'title',
                'editor',
            //'page-attributes'
            ),
            'hierarchical' => false
        );

        register_post_type('sc-location', $args);

        // service
        $args = array(
            'labels' => array(
                'name' => __('Service', $this->car_share),
                'singular_name' => __('Service', $this->car_share),
                'add_new' => __('Add new', $this->car_share),
                'add_new_item' => __('Add new service', $this->car_share),
                'edit_item' => __('Edit service', $this->car_share),
                'new_item' => __('New service', $this->car_share),
                'all_items' => __('All services', $this->car_share),
                'view_item' => __('View service', $this->car_share),
                'search_items' => __('Search services', $this->car_share),
                'menu_name' => __('Services', $this->car_share)
            ),
            'public' => false,
            'show_ui' => true,
            'supports' => array(
                'thumbnail',
                'title',
                'editor',
            //'page-attributes'
            ),
            'hierarchical' => false
        );

        register_post_type('sc-service', $args);

        // season
        $args = array(
            'labels' => array(
                'name' => __('Season', $this->car_share),
                'singular_name' => __('Season', $this->car_share),
                'add_new' => __('Add new season', $this->car_share),
                'add_new_item' => __('Add new season', $this->car_share),
                'edit_item' => __('Edit season', $this->car_share),
                'new_item' => __('New season', $this->car_share),
                'all_items' => __('All seasons', $this->car_share),
                'view_item' => __('View season', $this->car_share),
                'search_items' => __('Search season', $this->car_share),
                'menu_name' => __('Seasons', $this->car_share)
            ),
            'public' => false,
            'show_ui' => true,
            'supports' => array(
                'thumbnail',
                'title',
                'editor',
            //'page-attributes'
            ),
            'hierarchical' => false
        );

        register_post_type('sc-season', $args);
        
        // typ auta
        $args = array(
            'labels' => array(
                'name' => __('Car category', $this->car_share),
                'singular_name' => __('Car category', $this->car_share),
                'add_new' => __('Add car category', $this->car_share),
                'add_new_item' => __('Add car category', $this->car_share),
                'edit_item' => __('Edit car category', $this->car_share),
                'new_item' => __('New car category', $this->car_share),
                'all_items' => __('All car categories', $this->car_share),
                'view_item' => __('View car category', $this->car_share),
                'search_items' => __('Search car categories', $this->car_share),
                'menu_name' => __('Car categories', $this->car_share)
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'supports' => array(
                'thumbnail',
                'title',
                'editor',
            //'page-attributes'
            ),
            'hierarchical' => false
        );

        register_post_type('sc-car-category', $args);        
        
        // order
        $args = array(
            'labels' => array(
                'name' => __('Booking', $this->car_share),
                'singular_name' => __('Booking', $this->car_share),
                'add_new' => __('Make a new booking', $this->car_share),
                'add_new_item' => __('Make a new booking', $this->car_share),
                'edit_item' => __('Edit booking', $this->car_share),
                'new_item' => __('Make a new booking', $this->car_share),
                'all_items' => __('All booking', $this->car_share),
                'view_item' => __('View car booking', $this->car_share),
                'search_items' => __('Search car booking', $this->car_share),
                'menu_name' => __('Car booking', $this->car_share)
            ),
            'public' => false,
            //'publicly_queryable' => true,
            'show_ui' => true,
            'supports' => array(
                'thumbnail',
                'title',
                'editor',
            //'page-attributes'
            ),
            'hierarchical' => false
        );

        register_post_type('sc-booking', $args);                
        
        // voucher
        $args = array(
            'labels' => array(
                'name' => __('Voucher', $this->car_share),
                'singular_name' => __('Voucher', $this->car_share),
                'add_new' => __('Add new', $this->car_share),
                'add_new_item' => __('Add new voucher', $this->car_share),
                'edit_item' => __('Edit voucher', $this->car_share),
                'new_item' => __('New voucher', $this->car_share),
                'all_items' => __('All vouchers', $this->car_share),
                'view_item' => __('View voucher', $this->car_share),
                'search_items' => __('Search voucher', $this->car_share),
                'menu_name' => __('Vouchers', $this->car_share)
            ),
            'public' => false,
            //'publicly_queryable' => true,
            'show_ui' => true,
            'supports' => array(
                //'thumbnail',
                'title',
                //'editor',
                //'page-attributes'
            ),
            'hierarchical' => false
        );

        register_post_type('sc-voucher', $args);                   
    }  
    
    
    function ajax_refresh_checkout_price(){
        
        $Cars_cart = new Car_Cart('shopping_cart');
        $Cars_cart_items = $Cars_cart->getItemSearch();   
        
        $apply_surcharge = $_POST['apply_surcharge'];
        
        $Cars_cart->applySurcharge($apply_surcharge);
        
        
        $total_price = $Cars_cart->getTotalPrice();
        
        $paypable_now = 22;
        
        $return = array(
            'total_price' => $total_price,
            'paypable_now' => $paypable_now
        );

        echo json_encode($return);
        
        die();        
    }
    
}
