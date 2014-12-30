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
	public function __construct( $car_share, $version ) {

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

		wp_enqueue_style( $this->car_share, plugin_dir_url( __FILE__ ) . 'css/car_share-admin.css', array(), $this->version, 'all' );

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

		wp_enqueue_script( $this->car_share, plugin_dir_url( __FILE__ ) . 'js/car_share-admin.js', array( 'jquery' ), $this->version, false );

	}

        public function add_custom_boxes($post_id){

            add_meta_box(
                    'car_price_atts',
                    __('Price', $this->car_share),
                    array($this, 'car_price_box'),
                    'car'
            );
            
            add_meta_box(
                    'select_hours',
                    __('Select hours', $this->car_share),
                    array($this, 'allow_select_hours_box'),
                    'car'
            );            

            add_meta_box(
                    'locations_box',
                    __('Locations', $this->car_share),
                    array($this, 'locations_box'),
                    'car'
            );
        }

        public function car_price_box() {
            global $post;
            global $wpdb;
            
            $sql = "
                SELECT * FROM car_price WHERE car_id = '" . $post->ID . "' AND start_price_id = 0
            ";
            
            $start_price = $wpdb->get_row($sql);
            
            $sql = "
                SELECT *
                FROM car_price 
                WHERE car_id = $post->ID
                AND start_price_id = " . (int) $start_price->car_price_id . "
                ORDER BY time_from ASC";
            
            $special_prices = $wpdb->get_results($sql);
            
            include 'partials/car_price_box.php';
            wp_nonce_field(__FILE__, 'car_price_nonce');
        }
        
        public function allow_select_hours_box(){
            global $post;
            $allow_select_hours = get_post_meta($post->ID, '_allow_select_hours', true);
            include 'partials/allow_select_hours_box.php';
        }
        
        public function locations_box(){
            global $post;
            global $wpdb;
            
            $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'location' AND post_status = 'publish' ORDER BY post_title ASC ";
            $locations = $wpdb->get_results($sql);
            
            $current_location = get_post_meta($post->ID, '_current_location', true);
            $allowed_locations = get_post_meta($post->ID, '_allowed_location', true);
            
            include 'partials/locations_box.php';            
        }

        public function save(){
            global $post;
            global $wpdb;

            ################ save cars attributes #########################################################
            if (isset($_POST['car_price_nonce']) && wp_verify_nonce($_POST['car_price_nonce'], __FILE__)) {

                // rent prices 
                $sql = "DELETE FROM car_price WHERE car_id = " . (int) $post->ID;
                $wpdb->query($sql);

                $price_by = (int) $_POST['price_by'];

                // start price
                $sql = "
                    INSERT INTO
                        car_price (car_id, price_type, price_value, time_type, time_from)
                    VALUES (
                        '" . (int) $post->ID . "',
                        '" . Car_share::PRICE_TYPE_AMOUNT . "',
                        '" . esc_attr(str_replace(',', '.', $_POST['start_price'])) . "',
                        '" . $price_by . "',
                        0
                    )
                ";

                $wpdb->query($sql);

                $start_price_id = $wpdb->insert_id;

                if(!empty($_POST['special_price']['next_price'])){
                    foreach($_POST['special_price']['next_price'] as $key => $val){
                        $sql = "
                            INSERT INTO
                                car_price (car_id, price_type, price_value, time_type, time_from, start_price_id)
                            VALUES (
                                '" . (int) $post->ID . "',
                                '" . $_POST['special_price']['price_type'][$key] . "',
                                '" . esc_attr(str_replace(',', '.', $_POST['special_price']['next_price'][$key])) . "',
                                '" . $price_by . "',
                                '" . esc_attr(str_replace(',', '.', $_POST['special_price']['next_time'][$key])) . "',
                                '" . $start_price_id . "'
                            )
                        ";
                        $wpdb->query($sql);
                    }
                }
                
                // allow to pick hours
                if(isset($_POST['_allow_select_hours']) && 1 == $_POST['_allow_select_hours']){
                    update_post_meta($post->ID, '_allow_select_hours', 1);
                } else {
                    delete_post_meta($post->ID, '_allow_select_hours');
                }
                
                //
                $keys = array(
                    '_current_location',
                    '_allowed_location'
                );
                
                foreach($keys as $key){
                    if(!empty($_POST[$key])){
                        update_post_meta($post->ID, $key, $_POST[$key]);
                    } else {
                        delete_post_meta($post->ID, $key);
                    }                    
                }
            }
            #------------------------------------------------------------------------------------------------
        }


}
