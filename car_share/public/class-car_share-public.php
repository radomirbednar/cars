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
	public function __construct( $car_share, $version ) {

		$this->car_share = $car_share;
		$this->version = $version;

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

		wp_enqueue_style( $this->car_share, plugin_dir_url( __FILE__ ) . 'css/car_share-public.css', array(), $this->version, 'all' );

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

		wp_enqueue_script( $this->car_share, plugin_dir_url( __FILE__ ) . 'js/car_share-public.js', array( 'jquery' ), $this->version, false );

	}
        
        /**
         * 
         */
        public function register_custom_post(){
            
            $args = array(
                'labels' => array(
                    'name' => __('Cars', 'boilerplate'),
                    'singular_name' => __('Car', 'boilerplate'),
                    'add_new' => __('Add new', 'boilerplate'),
                    'add_new_item' => __('Add new car', 'boilerplate'),
                    'edit_item' => __('Edit car', 'boilerplate'),
                    'new_item' => __('New car', 'boilerplate'),
                    'all_items' => __('All cars', 'boilerplate'),
                    'view_item' => __('View car', 'boilerplate'),
                    'search_items' => __('Search car', 'boilerplate'),
                    'menu_name' => __('Cars', 'boilerplate')
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

            register_post_type('car', $args);   
            
            //
            $args = array(
                'labels' => array(
                    'name' => __('Location', 'boilerplate'),
                    'singular_name' => __('Location', 'boilerplate'),
                    'add_new' => __('Add new', 'boilerplate'),
                    'add_new_item' => __('Add new location', 'boilerplate'),
                    'edit_item' => __('Edit location', 'boilerplate'),
                    'new_item' => __('New location', 'boilerplate'),
                    'all_items' => __('All locations', 'boilerplate'),
                    'view_item' => __('View location', 'boilerplate'),
                    'search_items' => __('Search locations', 'boilerplate'),
                    'menu_name' => __('Locations', 'boilerplate')
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

            register_post_type('location', $args);       
            
            
            //
            $args = array(
                'labels' => array(
                    'name' => __('Service', 'boilerplate'),
                    'singular_name' => __('Service', 'boilerplate'),
                    'add_new' => __('Add new', 'boilerplate'),
                    'add_new_item' => __('Add new service', 'boilerplate'),
                    'edit_item' => __('Edit service', 'boilerplate'),
                    'new_item' => __('New service', 'boilerplate'),
                    'all_items' => __('All services', 'boilerplate'),
                    'view_item' => __('View service', 'boilerplate'),
                    'search_items' => __('Search services', 'boilerplate'),
                    'menu_name' => __('Services', 'boilerplate')
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

            register_post_type('service', $args);               
            
        }        

}
