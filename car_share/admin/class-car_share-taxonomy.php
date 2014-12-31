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

        add_action("car-type_edit_form_fields", array($this, 'car_type_attributes'), 10);
        add_action('edited_car-type', array($this, 'save_car_type'));
    }

    public function car_type_attributes($term) {

        global $wpdb;

        $sql = "
            SELECT * FROM car_price WHERE term_id = '" . $term->term_id . "' AND parent_price_id = 0
        ";

        $start_price = $wpdb->get_row($sql);

        $sql = "
            SELECT *
            FROM car_price
            WHERE term_id = $term->term_id
            AND parent_price_id = " . (int) $start_price->car_price_id . "
            ORDER BY time_from ASC";

        $special_prices = $wpdb->get_results($sql);

        include 'partials/car-type/attributes.php';
        wp_nonce_field(__FILE__, 'car-type_nonce');
    }

    public function save_car_type($term_id) {

        if (isset($_POST['car-type_nonce']) && wp_verify_nonce($_POST['car-type_nonce'], __FILE__)) {
            
            global $wpdb;

            // rent prices
            $sql = "DELETE FROM car_price WHERE car_id = " . (int) $term_id;
            $wpdb->query($sql);
            $price_by = (int) $_POST['price_by'];
            // start price
            $sql = "
                    INSERT INTO
                        car_price (term_id, price_value, time_from)
                    VALUES (
                        '" . (int) $term_id . "',                        
                        '" . esc_attr(str_replace(',', '.', $_POST['start_price'])) . "',                        
                        0
                    )
                ";
            
            $wpdb->query($sql);
            $parent_price_id = $wpdb->insert_id;

            if (!empty($_POST['special_price']['next_price'])) {
                foreach ($_POST['special_price']['next_price'] as $key => $val) {
                    $sql = "
                            INSERT INTO
                                car_price (term_id, price_value, time_from, parent_price_id)
                            VALUES (
                                '" . (int) $term_id . "',                                
                                '" . esc_attr(str_replace(',', '.', $_POST['special_price']['next_price'][$key])) . "',                                
                                '" . esc_attr(str_replace(',', '.', $_POST['special_price']['next_time'][$key])) . "',
                                '" . $parent_price_id . "'
                            )
                        ";
                    $wpdb->query($sql);
                }
            }
        }
    }

}
