<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Car_share
 * @subpackage Car_share/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Car_share
 * @subpackage Car_share/includes
 * @author     My name <mail@example.com>
 */
class Car_share {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Car_share_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $car_share    The string used to uniquely identify this plugin.
     */
    protected $car_share;

    const PICK_UP_LOCATION = 1;
    const DROP_OFF_LOCATION = 2;
    
    const STATUS_UNAVAILABLE = 0;    
    const STATUS_RENTED = 1;
    const STATUS_BOOKED = 3;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the Dashboard and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->car_share = 'car_share';
        $this->version = '1.0.0';

        $this->load_dependencies();
        
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Car_share_Loader. Orchestrates the hooks of the plugin.
     * - Car_share_i18n. Defines internationalization functionality.
     * - Car_share_Admin. Defines all hooks for the dashboard.
     * - Car_share_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         *
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/functions.php';


        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-car_share-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-car_share-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the Dashboard.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-admin.php';

        /**
         * Car taxonomies
         */
        //require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-taxonomy.php';

        /**
         * session post type
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-season.php';

        /**
         *
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-location.php';
        
        /**
         * 
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-order.php';

        /**
         *
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-car-category.php';
        
        /**
         *
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-voucher.php';       


        /*
         *
         * The class setting page in admin
         *
         *
         */

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-setting.php';
        
        /**
         * 
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-car_share-booking.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-car_share-public.php';


        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-car_share-shortcode.php';


        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-car_session.php';

        /**
         *
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'class/car.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'class/location.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'class/season.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'class/category.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'class/booking.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'class/currency.php';

        $this->loader = new Car_share_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Car_share_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Car_share_i18n();
        $plugin_i18n->set_domain($this->get_car_share());
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the dashboard functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Car_share_Admin($this->get_car_share(), $this->get_version());
        $plugin_setting = new Car_share_Setting($this->get_car_share(), $this->get_version());
        //$plugin_taxonomy = new Car_share_Taxonomy($this->get_car_share(), $this->get_version());
        $season = new Car_share_Season($this->get_car_share(), $this->get_version());
        $location = new Car_share_Location($this->get_car_share(), $this->get_version());
        $car_category = new Car_share_CarCategory($this->get_car_share(), $this->get_version());
        $car_order = new Car_share_Order($this->get_car_share(), $this->get_version());
        $voucher = new Car_share_Voucher($this->get_car_share(), $this->get_version());
        $booking = new Car_share_Booking($this->get_car_share(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Car_share_Public($this->get_car_share(), $this->get_version());
        $car_shortcode = new Car_share_Shortcode($this->get_car_share(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

        $this->loader->add_action('init', $plugin_public, 'register_custom_post');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_car_share() {
        return $this->car_share;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Car_share_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
