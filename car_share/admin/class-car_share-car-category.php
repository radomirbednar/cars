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

        add_action('in_admin_footer', array($this, 'new_season_to_category'));

        add_action('in_admin_footer', array($this, 'new_season_to_category'));

        add_action('wp_ajax_add_season_to_category', array($this, 'add_season_to_category_callback'));
    }

    public function add_season_to_category_callback(){

        global $wpdb;        

        // category day prices
        if(!empty($_POST['_season_to_category_prices'])){
            foreach ($_POST['_season_to_category_prices'] as $dayname => $price){
                $sql = "
                    REPLACE INTO day_prices (car_category_id, season_id, dayname, price) VALUES (
                        '" . (int) $_POST['_car_category_id'] . "',
                        '" . (int) $_POST['_season_to_category'] . "',
                        '" . esc_sql($dayname) . "',
                        '" . floatval($price) . "'
                    )
                    ";
                    $wpdb->query($sql);
                }
        }
        exit();
    }

    public function add_custom_boxes() {

        add_meta_box(
                'car_category_miminum_age', __('Minimum driver age', $this->car_share), array($this, 'minimum_age_box'), 'sc-car-category'
        );

        add_meta_box(
                'car_category_day_prices', __('Price', $this->car_share), array($this, 'day_prices_box'), 'sc-car-category'
        );

        add_meta_box(
                'car_category_discount_upon_duration', __('Discount upon duration', $this->car_share), array($this, 'discount_upon_duration_box'), 'sc-car-category'
        );

        add_meta_box(
                'car_category_assign_season', __('Assigned seasons', $this->car_share), array($this, 'assigned_season_box'), 'sc-car-category'
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
        $category_day_prices = $category->day_prices_indexed_with_dayname();

        include 'partials/car-category/day_prices.php';
    }

    public function assigned_season_box(){
        global $post;
        $category = new sc_Category($post);        
        $season2category_prices = $category->season_to_category_prices();

        include 'partials/car-category/season2category.php';
    }

    public function new_season_to_category(){
        global $post;
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-season' AND post_status IN ('publish')";
        $seasons = $wpdb->get_results($sql);

        include 'partials/car-category/new_season_to_category.php';
    }

    public function discount_upon_duration_box(){
        global $post;
        $discount_upon_duration = get_post_meta($post->ID, '_discount_upon_duration', true);

        if(is_array($discount_upon_duration)){
            ksort($discount_upon_duration);
        }

        include 'partials/car-category/discount_upon_duration.php';
        wp_nonce_field(__FILE__, 'car_category_nonce');
    }



    public function save() {
        //$date = DateTime::createFromFormat('m.d.Y', $_POST['Select-date']);
        if (isset($_POST['car_category_nonce']) && wp_verify_nonce($_POST['car_category_nonce'], __FILE__)) {

            global $wpdb;
            global $post;

            // category day prices
            if(!empty($_POST['_category_day_prices'])){
                foreach ($_POST['_category_day_prices'] as $dayname => $price){
                    $sql = "
                        REPLACE INTO day_prices (car_category_id, season_id, dayname, price) VALUES (
                            '" . (int) $post->ID . "',
                            0,
                            '" . esc_sql($dayname) . "',
                            '" . floatval($price) . "'
                        )
                    ";
                    $wpdb->query($sql);
                }
            }


            delete_post_meta($post->ID, '_discount_upon_duration');

            if(!empty($_POST['_discount_upon_duration'])){
                $arr_to_save = array();
                foreach($_POST['_discount_upon_duration'] as $discount){
                    $days = (int) $discount['days'];
                    $percentage = floatval($discount['percentage']);
                    $arr_to_save[$days] = $percentage;
                }
                update_post_meta($post->ID, '_discount_upon_duration', $arr_to_save);
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

