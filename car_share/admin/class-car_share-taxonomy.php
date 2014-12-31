<?php

class Car_share_Taxonomy {
    
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
        
        add_action("car-type_edit_form_fields", array($this, 'car_type_price_box'), 10);
    }      
    
    
    
    public function car_type_price_box($term){

        global $wpdb;

        $sql = "
            SELECT * FROM car_price WHERE term_id = '" . $term->term_id . "' AND start_price_id = 0
        ";

        $start_price = $wpdb->get_row($sql);

        $sql = "
            SELECT *
            FROM car_price
            WHERE term_id = $term->term_id
            AND start_price_id = " . (int) $start_price->car_price_id . "
            ORDER BY time_from ASC";

        $special_prices = $wpdb->get_results($sql);
        
        include 'partials/car-type/price_box.php';
        wp_nonce_field(__FILE__, 'car-type_nonce');
    }
}

