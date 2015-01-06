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
class Car_share_Single {

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
        
        add_action( 'admin_menu', array($this, 'register_menu_page' ));
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
    
    public function register_menu_page(){
        //add_menu_page( 'Single cars', 'Single cars', '', 'myplugin/myplugin-admin.php', '', plugins_url( 'myplugin/images/icon.png' ), 6 );        
        //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function ); 
        
        add_submenu_page( "edit.php?post_type=sc-car",  __('Single cars', $this->car_share), __('Single cars', $this->car_share), 'edit_posts', 'single-cars', array($this, 'single_cars')); 
        add_submenu_page( "edit.php?post_type=sc-car",  __('Add single cars', $this->car_share), __('Add single cars', $this->car_share), 'edit_posts', 'add-single-cars', array($this, 'single_cars')); 
    }
    
    public function single_cars(){        
        
    }
}
