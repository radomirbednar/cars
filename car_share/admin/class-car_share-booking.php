<?php

class Car_share_Booking {

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

        //add_action('add_meta_boxes', array($this, 'add_custom_boxes'));
        //add_action('save_post', array($this, 'save'));

        //add_filter('manage_sc-season_posts_columns', array($this, 'column_head'));
        //add_action('manage_sc-season_posts_custom_column', array($this, 'column_content'), 10, 2);


        add_filter('manage_sc-booking_posts_columns', array($this, 'column_head'));
        add_action('manage_sc-booking_posts_custom_column', array($this, 'column_content'), 10, 2);

        add_action('add_meta_boxes', array($this, 'add_custom_boxes'));
        add_action('save_post', array($this, 'save'));


    }




    public function column_head($defaults){
        $defaults['from'] = __('From', $this->car_share);
        $defaults['to'] = __('To', $this->car_share);
        return $defaults;
    }

    public function column_content($column_name, $post_id){
        
        $booking = new sc_Booking($post_id);
        
        switch($column_name){
            case 'from':
                if(!empty($booking->from())){
                    echo $booking->from()->format(get_option('date_format'));
                    echo ' - ';
                    echo $booking->from()->format(get_option('time_format'));
                }
                break;
            case 'to':
                if(!empty($booking->to())){
                    echo $booking->to()->format(get_option('date_format'));
                    echo ' - ';
                    echo $booking->to()->format(get_option('time_format'));
                }
                break;
        }
    }


    public function add_custom_boxes() {

        /*
        add_meta_box(
                'booking_date_interval', __('Date Interval', $this->car_share), array($this, 'booking_date_interval'), 'sc-booking'
        );*/

        add_meta_box(
                'booking_customer_box', __('Customer info', $this->car_share), array($this, 'customer_info_box'), 'sc-booking'
        );
        
        add_meta_box(
                'booking_info_box', __('Booking info', $this->car_share), array($this, 'booking_info_box'), 'sc-booking'
        );        
        
        /*
        add_meta_box(
                'voucher_discount_box', __('Discount (percentage)', $this->car_share), array($this, 'voucher_discount_box'), 'sc-voucher'
        );
        */
     }

     /*
     public function booking_date_interval(){
         global $post;

         //$from = get_date_meta($post->ID, '_from');
         //$to = get_date_meta($post->ID, '_to');
         $booking = new sc_Booking($post);

         include 'partials/booking/interval.php';
     }*/

     public function booking_info_box(){
         
        global $post;
        
        $booking_fields     = get_booking_fields();
        $fields_to_show     = array();
        $custom_fields      = get_post_custom($post->ID); 
        
        foreach($booking_fields as $key => $label){
            
            if(isset($custom_fields[$key])){            
                $field = array(
                    'label' => $label,
                    'value' => $custom_fields[$key][0],
                );
                
                $fields_to_show[$key] = $field; 
            }            
        }
        
        $booking = new sc_Booking($post);
        
        include 'partials/booking/interval.php';
        include 'partials/booking/field_list.php';
     }


    public function customer_info_box(){

        global $post;

        $fields_to_show     = array();
        $default_fields     = get_default_checkout_fields();
        $custom_fields      = get_post_custom($post->ID);      
        
        foreach($default_fields as $field_key => $field){            
            if(isset($custom_fields[$field_key])){
                $field['value'] = $custom_fields[$field_key][0];
                $fields_to_show[] = $field;
            }            
        }
        
        include 'partials/booking/field_list.php';
    }







    public function save() {
        //$date = DateTime::createFromFormat('m.d.Y', $_POST['Select-date']);
        if (isset($_POST['voucher_nonce']) && wp_verify_nonce($_POST['voucher_nonce'], __FILE__)) {

            global $post;

            $keys = array();

            if(empty($_POST['_voucher_code'])){
                delete_post_meta($post->ID, '_voucher_code');
            } else {
                update_post_meta($post->ID, '_voucher_code', sanitize_text_field($_POST['_voucher_code']));
            }

            if(empty($_POST['_discount'])){
                delete_post_meta($post->ID, '_discount');
            } else {
                update_post_meta($post->ID, '_discount', floatval($_POST['_discount']));
            }

        }
    }
}




