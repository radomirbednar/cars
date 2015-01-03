<?php

class Car_share_Season {

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
                'season_date_box', __('Date interval', $this->car_share), array($this, 'date_box'), 'sc-season'
        );

        add_meta_box(
                'season_prices_box', __('Prices', $this->car_share), array($this, 'day_prices_box'), 'sc-season'
        );

    }

    public function date_box(){
        global $post;
        $session = new sc_Season($post);
        $date_from = $session->from();
        $date_to = $session->to();

        include 'partials/season/date_interval.php';
        wp_nonce_field(__FILE__, 'season_nonce');
    }

    public function day_prices_box(){
        global $post;
        $session = new sc_Season($post);
        $season_day_prices = $session->day_prices_indexed_with_dayname();

        include 'partials/season/day_prices.php';
        wp_nonce_field(__FILE__, 'season_nonce');
    }

    public function save() {

        //$date = DateTime::createFromFormat('m.d.Y', $_POST['Select-date']);
        if (isset($_POST['season_nonce']) && wp_verify_nonce($_POST['season_nonce'], __FILE__)) {
            global $post;
            global $wpdb;

            $date_from = DateTime::createFromFormat('d.m.Y', $_POST['_from']);
            $date_to = DateTime::createFromFormat('d.m.Y', $_POST['_to']);

            if(!empty($date_from)){
                update_date_meta($post->ID, '_from', $date_from);
            } else {
                delete_date_meta($post->ID, '_from');
            }

            if(!empty($date_to)){
                update_date_meta($post->ID, '_to', $date_to);
            } else {
                delete_date_meta($post->ID, '_to');
            }

            // seassion day prices
            if(!empty($_POST['_season_day_prices'])){
                foreach ($_POST['_season_day_prices'] as $dayname => $price){
                    $sql = "
                        REPLACE INTO day_prices (post_id, dayname, price) VALUES (
                            '" . (int) $post->ID . "',
                            '" . esc_sql($dayname) . "',
                            '" . floatval($price) . "'
                        )
                    ";
                    $wpdb->query($sql);
                }
            }

            /*
            if("" != trim($_POST['_season_day_prices'])){
                array_walk($_POST['_season_day_prices'], 'floatval');
                update_post_meta($post->ID, '_season_day_prices', $_POST['_season_day_prices']);
            } else {
                delete_post_meta($post->ID, '_season_day_prices');
            }*/
        }
    }

}
