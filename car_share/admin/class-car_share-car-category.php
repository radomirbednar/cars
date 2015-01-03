<?php

class Car_share_CarCategory {

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

        add_action('add_meta_boxes', array($this, 'add_custom_boxes'));
        add_action('save_post', array($this, 'save'));
    }

    public function add_custom_boxes() {

        add_meta_box(
                'car_category_miminum_age', __('Minimum driver age', $this->car_share), array($this, 'minimum_age_box'), 'sc-car-category'
        );

        add_meta_box(
                'car_category_day_prices', __('Price', $this->car_share), array($this, 'day_prices_box'), 'sc-car-category'
        );

        add_meta_box(
                'car_category_price', __('Price', $this->car_share), array($this, 'price_box'), 'sc-car-category'
        );

        add_meta_box(
                'car_category_discount_upon_duration', __('Discount upon duration', $this->car_share), array($this, 'discount_upon_duration_box'), 'sc-car-category'
        );

    }

    public function minimum_age_box(){
        global $post;
        $minimum_driver_age = get_post_meta($post->ID, '_minimum_driver_age', true);
        include 'partials/car-category/minimum_driver_age.php';
    }

    public function day_prices_box(){
        global $post;
        $category = new sc_Category($post);
        $season_day_prices = $category->day_prices_indexed_with_dayname();

        include 'partials/car-category/day_prices.php';
    }

    public function discount_upon_duration_box(){
        global $post;
        $car_cateogry = new sc_Category($post);

        include 'partials/car-category/discount_upon_duration.php';
    }

    public function price_box(){
        global $post;
        global $wpdb;

        $sql = "
            SELECT * FROM car_price WHERE post_id = '" . (int) $post->ID . "' AND parent_price_id = 0
        ";

        $start_price = $wpdb->get_row($sql);

        $sql = "
            SELECT *
            FROM car_price
            WHERE post_id = '" . (int) $post->ID . "'
            AND parent_price_id = " . (int) $start_price->car_price_id . "
            ORDER BY time_from ASC";

        $special_prices = $wpdb->get_results($sql);

        include 'partials/car-category/price.php';
        wp_nonce_field(__FILE__, 'car_category_nonce');
    }

    public function save() {
        //$date = DateTime::createFromFormat('m.d.Y', $_POST['Select-date']);
        if (isset($_POST['car_category_nonce']) && wp_verify_nonce($_POST['car_category_nonce'], __FILE__)) {
            global $wpdb;
            global $post;

            // rent prices
            $sql = "DELETE FROM car_price WHERE post_id = " . (int) $post->ID;
            $wpdb->query($sql);
            //$price_by = (int) $_POST['price_by'];

            // start price
            $sql = "
                    INSERT INTO
                        car_price (post_id, price_value, time_from)
                    VALUES (
                        '" . (int) $post->ID . "',
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
                                car_price (post_id, price_value, time_from, parent_price_id)
                            VALUES (
                                '" . (int) $post->ID . "',
                                '" . esc_attr(str_replace(',', '.', $_POST['special_price']['next_price'][$key])) . "',
                                '" . esc_attr(str_replace(',', '.', $_POST['special_price']['next_time'][$key])) . "',
                                '" . $parent_price_id . "'
                            )
                        ";
                    $wpdb->query($sql);
                }
            }

            //
            $keys = array(
                '_minimum_driver_age'
            );

            foreach($keys as $key){
                if(isset($_POST[$key]) && "" != trim($_POST[$key])){
                    update_post_meta((int) $post->ID, $key, esc_attr($_POST[$key]));
                } else {
                    delete_post_meta((int) $post->ID, $key);
                }
            }
        }
    }

}

