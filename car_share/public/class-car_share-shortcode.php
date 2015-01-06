<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Car_share_Shortcode {

    public function __construct($car_share, $version) {

        $this->car_share = $car_share;
        $this->version = $version;

       
        
        add_shortcode('sc-search_for_car', array($this, 'search_for_car'));
        add_shortcode('sc-pick_car', array($this, 'pick_car'));
        add_shortcode('sc-extras', array($this, 'extras'));
        add_shortcode('sc-checkout', array($this, 'checkout'));
        
         
        add_action('plugins_loaded', array($this, 'search_for_car_form'));
  
        
    }

 
    public function search_for_car_form() {
   
        //fix pro permalinky
        if ( empty( $GLOBALS['wp_rewrite'] ) )
	$GLOBALS['wp_rewrite'] = new WP_Rewrite();
         
        $sc_options = get_option('sc-pages');  
        $pick_car_url = isset($sc_options['pick_car']) ? get_permalink($sc_options['pick_car']) : '';  
    
        
        //check if form is posted
        if (isset($_POST['pick_up_location']) && isset($_POST['car_datefrom']) && isset($_POST['car_dateto'])) {
   
        //id lokace
            $pick_up_location = sanitize_text_field($_POST['pick_up_location']);
            $drop_off_location = sanitize_text_field($_POST['drop_off_location']);

        //ostatní z formuláře
            $car_datefrom = $_POST['car_datefrom'];
            $car_dateto = $_POST['car_dateto'];

            $car_hoursfrom = $_POST['car_hoursfrom'];
            $car_hoursto = $_POST['car_hoursto'];

        //dej mi kategorie
            if (isset($_POST['$car_category'])) {
                $car_category = sanitize_text_field($_POST['$car_category']);
            }

            $format = 'd-m-Y H';
            $car_hoursfrom = DateTime::createFromFormat($format, $car_datefrom . ' ' . $car_hoursfrom);
            $car_hoursto = DateTime::createFromFormat($format, $car_dateto . ' ' . $car_hoursto);
            $car_hoursfrom = $car_hoursfrom->format('H:i:s');
            $car_hoursto = $car_hoursto->format('H:i:s');
 
        // jméno dne 
            $day_car_from = date('l', strtotime($car_datefrom));
            $day_car_dateto = date('l', strtotime($car_dateto));

        // TODO check if the location is disponible in this date and time
        // naplneni vyhledavani do SESSION
        // check jestli je zrovna otevreno kdyz si vybiram auto
            
            
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
                $warning = __('Sorry, we won\'t be here. Please choose another time.', $this->car_share);
                
            } else {
                
                
             
                
                
                wp_redirect($pick_car_url);
                exit;
            }
        }
    }
    
    
    
    

    public function search_for_car($atts) { 
        ob_start();
        include_once( 'partials/shortcode/search_for_car.php' );
        return ob_get_clean();
    }

    public function pick_car($atts) {
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
