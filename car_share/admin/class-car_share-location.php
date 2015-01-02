<?php

class Car_share_Location {

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
                'location_opening_hours', __('Opening hours', $this->car_share), array($this, 'opening_hours_box'), 'location'
        );

    }

    public function opening_hours_box(){
        global $post;

        include 'partials/location/opening_hours.php';
        wp_nonce_field(__FILE__, 'location_nonce');
    }

    public function save() {
        //$date = DateTime::createFromFormat('m.d.Y', $_POST['Select-date']);
        if (isset($_POST['location_nonce']) && wp_verify_nonce($_POST['location_nonce'], __FILE__)) {
            global $post;
            global $wpdb;
            
            // ukladani oteviracich hodin
            if(!empty($_POST['open'])){
                foreach($_POST['open'] as $day_name => $value){
                    
                    $open = isset($value['open']) && 1 == $value['open'] ? 1 : 0;
                    
                    $sql = "
                        REPLACE INTO opening_hours (location_id, dayname, open_from, open_to, open) VALUES (
                            '" . (int) $post->ID . "',
                            '" . esc_attr($day_name) . "',
                            '" . (int) $value['from']['hour'] . ":" . (int) $value['from']['min'] . ":00',
                            '" . (int) $value['to']['hour'] . ":" . (int) $value['to']['min'] . ":00',
                            '" . $open . "'    
                        )
                    ";
                    
                    $wpdb->query($sql);
                    
                }
            }
        }
    }

}
