<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Car_share_Shortcode {

    public $warning;
    public $cars; 
    public $extras_car_url;

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

            $car_dfrom = DateTime::createFromFormat($format, $car_datefrom . ' ' . $car_hoursfrom);
            $car_dto = DateTime::createFromFormat($format, $car_dateto . ' ' . $car_hoursto);

            $car_hoursfrom = $car_dfrom->format('H:i:s');
            $car_hoursto = $car_dto->format('H:i:s');

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
                $Cars_cart->setItemSearch($pick_up_location, $drop_off_location, $car_dfrom, $car_dto, $car_category);
                $Cars_cart->save();
                wp_redirect($pick_car_url);
                exit;
            }
        }
    }

    public function pick_car_form() {

        $sc_options = get_option('sc-pages');
        $this->extras_car_url = isset($sc_options['extras']) ? get_page_link($sc_options['extras']) : '';
        $Cars_cart = new Car_Cart('shopping_cart');
        $Cars_cart_items = $Cars_cart->getItems();
 
        //improve for sanitize
        
        $pick_up_location = $Cars_cart_items['pick_up_location'];
        $drop_off_location = $Cars_cart_items['drop_off_location'];

        $car_dfrom = $Cars_cart_items['car_datefrom'];
        $car_dto = $Cars_cart_items['car_dateto'];
        $car_category = $Cars_cart_items['car_category'];

        $car_dfrom_string = $car_dfrom->format('Y-m-d H:i:s');
        $car_dto_string = $car_dto->format('Y-m-d H:i:s');

        //get me all cars

        global $wpdb;
        if ($car_category != '') {

            $sql = "
              SELECT DISTINCT
                    *
                    FROM
                    $wpdb->posts posts
                    JOIN
                    sc_single_car sc_single_car
                    ON
                    sc_single_car.parent = posts.ID
                    JOIN
                    sc_single_car_location sc_location
                    ON
                    sc_location.single_car_id = sc_single_car.single_car_id
                    JOIN
                    sc_single_car_location sc_locationto
                    ON
                    sc_locationto.single_car_id = sc_single_car.single_car_id
                    WHERE sc_single_car.single_car_id NOT IN
                    (
                    SELECT single_car_id FROM sc_single_car_status WHERE
                    '$car_dto_string' >= date_from AND date_to >= '$car_dfrom_string'
                    )
                    AND
                    posts.post_type = 'sc-car'
                    AND
                    (sc_location.location_id = '$pick_up_location' AND sc_location.location_type = '1')
                    AND
                    (sc_locationto.location_id = '$drop_off_location' AND sc_locationto.location_type = '2')
                    AND
                    posts.post_status = 'publish'
                    GROUP BY posts.ID";
        } else {
            $sql = "
              SELECT DISTINCT
                    *
                    FROM
                    $wpdb->posts posts
                    JOIN
                    sc_single_car sc_single_car
                    ON
                    sc_single_car.parent = posts.ID
                    JOIN
                    sc_single_car_location sc_location
                    ON
                    sc_location.single_car_id = sc_single_car.single_car_id
                    JOIN
                    sc_single_car_location sc_locationto
                    ON
                    sc_locationto.single_car_id = sc_single_car.single_car_id
                    WHERE sc_single_car.single_car_id NOT IN
                    (
                    SELECT single_car_id FROM sc_single_car_status WHERE
                    '$car_dto_string' >= date_from AND date_to >= '$car_dfrom_string'
                    )
                    AND
                    posts.post_type = 'sc-car'
                    AND
                    (sc_location.location_id = '$pick_up_location' AND sc_location.location_type = '1')
                    AND
                    (sc_locationto.location_id = '$drop_off_location' AND sc_locationto.location_type = '2')
                    AND
                    posts.post_status = 'publish'
                    GROUP BY posts.ID";
        }

        $this->cars = $wpdb->get_results($sql);
    }

    public function extras_form() {
        /*
         * Add the id of the chose car
         */
        if (isset($_GET['chcar'])) {
            $id_code = sanitize_text_field($_GET['chcar']);
            $Cars_cart = new Car_Cart('shopping_cart');
            $Cars_cart->setItemId($id_code);
            $Cars_cart->save();
        }
        
        
        /*
         *  information form extras
         */
    }

    public function checkout_form() {

        if (isset($_POST['service'])) {
            $service = $_POST['service'];
            $Cars_cart = new Car_Cart('shopping_cart');
            $Cars_cart->setItemService($service);
            $Cars_cart->save(); 
        }
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
        $this->extras_form();
        ob_start();
        include_once( 'partials/shortcode/extras.php' );
        return ob_get_clean();
    }

    public function checkout() {

        $this->checkout_form();

        ob_start();
        include_once( 'partials/shortcode/checkout.php' );
        return ob_get_clean();
    }

}
