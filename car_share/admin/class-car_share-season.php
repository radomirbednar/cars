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
                'date_box', __('Date interval', $this->car_share), array($this, 'date_box'), 'sc-season'
        );

    }

    public function date_box(){
        global $post;
        $date_from = get_date_meta($post->ID, '_from');
        $date_to = get_date_meta($post->ID, '_to');
        $season_price = get_post_meta($post->ID, '_season_price', true);

        include 'partials/season/date_interval.php';
        wp_nonce_field(__FILE__, 'season_nonce');
    }

    public function save() {

        //$date = DateTime::createFromFormat('m.d.Y', $_POST['Select-date']);
        if (isset($_POST['season_nonce']) && wp_verify_nonce($_POST['season_nonce'], __FILE__)) {
            global $post;
            //global $wpdb;

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
            
            if("" != trim($_POST['_season_price'])){
                update_post_meta($post->ID, '_season_price', $_POST['_season_price']);
            } else {
                delete_post_meta($post->ID, '_season_price');
            }

        }
    }

}
