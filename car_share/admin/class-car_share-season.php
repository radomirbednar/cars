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
                'date_box', __('Date interval', $this->car_share), array($this, 'date_box'), 'season'
        );
        
    }
    
    public function date_box(){
        include 'partials/car/date_box.php';
        wp_nonce_field(__FILE__, 'season_nonce');        
    }

    public function save() {
        
    }

}
