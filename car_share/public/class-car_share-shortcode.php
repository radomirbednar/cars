<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Car_share_Shortcode {

    public $warning;

    public function __construct($car_share, $version) {

        $this->car_share = $car_share;
        $this->version = $version;

        add_shortcode('sc-search_for_car', array($this, 'search_for_car'));
        add_shortcode('sc-pick_car', array($this, 'pick_car'));
        add_shortcode('sc-extras', array($this, 'extras'));
        add_shortcode('sc-checkout', array($this, 'checkout')); 
        add_action('plugins_loaded', array($this, 'search_for_car_form'));

        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /*
     *
     * logic for the search shordcode
     *
     */

    public function search_for_car_form() { 
        //fix for permalinks 
        if (empty($GLOBALS['wp_rewrite']))
            $GLOBALS['wp_rewrite'] = new WP_Rewrite();

        $sc_options = get_option('sc-pages');
        $pick_car_url = isset($sc_options['pick_car']) ? get_permalink($sc_options['pick_car']) : '';

        //check if form is posted

        if (isset($_POST['pick_up_location']) && isset($_POST['car_datefrom']) && isset($_POST['car_dateto'])) { 
            //id lokace 
            $pick_up_location = sanitize_text_field($_POST['pick_up_location']);
 
            if (isset($_POST['returnlocation'])) {
                $drop_off_location = sanitize_text_field($_POST['drop_off_location']);
            } else {

                $drop_off_location = $pick_up_location;
            }
 
            //others infor from the form

            $car_datefrom = $_POST['car_datefrom'];
            $car_dateto = $_POST['car_dateto'];

            $car_hoursfrom = $_POST['car_hoursfrom'];
            $car_hoursto = $_POST['car_hoursto'];

            //get the kategory if any if not empty

            if (isset($_POST['car_category'])) {
                $car_category = sanitize_text_field($_POST['car_category']);
            } else {
                $car_category = '';
            }

            $format = 'd-m-Y H';
            $car_hoursfrom = DateTime::createFromFormat($format, $car_datefrom . ' ' . $car_hoursfrom);
            $car_hoursto = DateTime::createFromFormat($format, $car_dateto . ' ' . $car_hoursto);
            $car_hoursfrom = $car_hoursfrom->format('H:i:s');
            $car_hoursto = $car_hoursto->format('H:i:s');

            // name for a day

            $day_car_from = date('l', strtotime($car_datefrom));
            $day_car_dateto = date('l', strtotime($car_dateto));

            // check for opening hours

            global $wpdb;

            $sqlfrom = $wpdb->prepare("SELECT * FROM
                    opening_hours WHERE location_id = %s
                    AND
                    dayname = %s
                    AND open = 1
                    AND open_from <= %s
                    AND open_to >= %s", $pick_up_location, $day_car_from, $car_hoursfrom, $car_hoursfrom
            );
            $resultfrom = $wpdb->get_results($sqlfrom);

            $sqlto = $wpdb->prepare("SELECT * FROM
                    opening_hours WHERE location_id = %s
                    AND
                    dayname = %s
                    AND open = 1
                    AND open_from <= %s
                    AND open_to >= %s", $drop_off_location, $day_car_dateto, $car_hoursto, $car_hoursto
            );
            $resultto = $wpdb->get_results($sqlto);

            if (empty($resultfrom) || empty($resultto)) {

                $this->warning = __('Sorry, we won\'t be here. Please choose another time.', $this->car_share);
            } else {
 
                $Cars_cart = new Car_Cart('shopping_cart');
                $Cars_cart->setItemSearch($pick_up_location, $drop_off_location, $car_hoursfrom, $car_hoursto, $car_category);
                $Cars_cart->save();
 
                wp_redirect($pick_car_url);
                exit;
            }
        }
    }

    public function pick_car_form() {

        $sc_options = get_option('sc-pages');
        $extras_car_url = isset($sc_options['extras']) ? get_page_link($sc_options['extras']) : '';

        $Cars_cart = new Car_Cart('shopping_cart'); 
        $Cars_cart_items =  $Cars_cart->getItems();
         
        var_dump($Cars_cart_items); 
        
        $pick_up_location = $Cars_cart_items['pick_up_location']; 
        $drop_off_location = $Cars_cart_items['drop_off_location']; 
        $car_hoursfrom = $Cars_cart_items['car_hoursfrom']; 
        $car_hoursto = $Cars_cart_items['car_hoursto']; 
        $car_category = $Cars_cart_items['car_category'];
        
        echo $car_datefrom;
 
        echo $car_dateto;
    
        global $wpdb;
         
        $sql = "  
                SELECT
                     *
                    FROM
                    $wpdb->posts posts
                    JOIN     
                    sc_car_status sc_status
                    ON
                    sc_status.car_id = posts.ID        
                    WHERE 
                    posts.post_type = 'sc-car' 
                    OR
                    posts.post_type = 'sc-car-category'
                
                    AND
                    posts.post_status = 'publish'    
                    AND NOT EXISTS  
                    (     
                    SELECT * FROM sc_car_status
                    WHERE
                    date_from >= '2015-01-18 00:00:00' 
                    AND
                    date_to <= '2015-01-19 00:00:00'   
                    )
                     
             "; 
        $cars = $wpdb->get_results($sql);
                
       // var_dump($cars); 
        
         
       /* 
        "
        SELECT      key3.post_id
	FROM        $wpdb->postmeta key3
	INNER JOIN  $wpdb->postmeta key1 
	            ON key1.post_id = key3.post_id
	            AND key1.meta_key = %s 
	INNER JOIN  $wpdb->postmeta key2
	            ON key2.post_id = key3.post_id
	            AND key2.meta_key = %s
	WHERE       key3.meta_key = %s 
	            AND key3.meta_value = %s
	ORDER BY    key1.meta_value, key2.meta_value
	",         
	$meta_key1, 
	$meta_key2, 
	$meta_key3, 
	$meta_key3_value";
        */
        
  
    }

    public function search_for_car($atts) { 
        ob_start();
        include_once( 'partials/shortcode/search_for_car.php' );
        return ob_get_clean();
    }

    public function pick_car($atts) { 
        $this->pick_car_form(); 
        ob_start();
        include_once( 'partials/shortcode/pick_car.php' );
        return ob_get_clean();
    }

    public function extras() {
        ob_start();
        include_once( 'partials/shortcode/extras.php' );
        return ob_get_clean();
    }

    public function checkout() {
        ob_start();
        include_once( 'partials/shortcode/checkout.php' );
        return ob_get_clean();
    }

}
