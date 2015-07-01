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

    public function column_head($defaults) {
        $defaults['from'] = __('From', $this->car_share);
        $defaults['to'] = __('To', $this->car_share);
        $defaults['status'] = __('Status', $this->car_share);

        return $defaults;
    }

    public function column_content($column_name, $post_id) {


        $booking = new sc_Booking($post_id);

        $booking_from = $booking->from();
        $booking_to = $booking->to();

        switch ($column_name) {
            case 'from':
                if (!empty($booking_from)) {
                    /*
                      echo $booking_from->format(get_option('date_format'));
                      echo ' - ';
                      echo $booking_from->format(get_option('time_format'));
                     */
                    echo date_i18n(SC_DATETIME_FORMAT, $booking_from->getTimestamp());
                }
                break;
            case 'to':
                if (!empty($booking_to)) {
                    /*
                      echo $booking_to->format(get_option('date_format'));
                      echo ' - ';
                      echo $booking_to->format(get_option('time_format'));
                     */
                    echo date_i18n(SC_DATETIME_FORMAT, $booking_to->getTimestamp());
                }
                break;
            case 'status':
                $status = get_post_meta($post_id, 'car_r_order_status', true);
                if ($status == 1) {
                    echo 'Completed';
                } elseif ($status == 2) {
                    echo 'Pending';
                } elseif ($status == 3) {
                    echo 'Failed';
                }
                break;
        }
    }

    public function add_custom_boxes() {

        /*
          add_meta_box(
          'booking_date_interval', __('Date Interval', $this->car_share), array($this, 'booking_date_interval'), 'sc-booking'
          ); */

        add_meta_box(
                'booking_customer_box', __('Customer info', $this->car_share), array($this, 'customer_info_box'), 'sc-booking'
        );
        add_meta_box(
                'booking_info_box', __('Booking info', $this->car_share), array($this, 'booking_info_box'), 'sc-booking'
        );
        add_meta_box(
                'payment_detail_box', __('Payment details', $this->car_share), array($this, 'payment_detail_box'), 'sc-booking'
        );

        add_meta_box(
                'booking_status_box', __('Payment Status', $this->car_share), array($this, 'booking_status_box'), 'sc-booking'
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
      } */


    /*
      public function payment_detail_box(

      /*   Payment Details

      Phone: not provided
      Email: radovanmail@gmail.com
      Payment Method: Pay Adapter


      global $post;



      $booking = new sc_Booking($post);

      include 'partials/booking/payment_info.php';

      ); */

    public function booking_status_box() {

        global $post;
        $status = get_post_meta($post->ID, 'car_r_order_status', true);
        ?>    
        <select name="car_r_order_status">
            <option value="">----</option>
        <?php
        $status_string = array(1 => 'Completed', 2 => 'Pending', 3 => 'Failed');


        for ($i = 1; $i < 4; $i++) {
            ?> 
                <option value="<?php echo $i; ?>" <?php echo $status == $i ? "selected" : ""; ?>><?php echo $status_string[$i]; ?></option>  
            <?php
        }
        ?>
        </select>   

        <?php
        wp_nonce_field(__FILE__, 'booking_status_nonce');
    }

    public function booking_info_box() {

        global $post;

        $booking_fields = get_booking_fields();
        $fields_to_show = array();
        $custom_fields = get_post_custom($post->ID);

        foreach ($booking_fields as $key => $field) {

            if (isset($custom_fields[$key])) {
                $field['value'] = $custom_fields[$key][0];
                $fields_to_show[$key] = $field;
            }
        }
        
        //$fields_to_show = array_merge( (array) $booking_fields, (array) $fields_to_show); // fill filds in case creating new booking

        $booking = new sc_Booking($post);
        $currency = sc_Currency::get_instance();
        $currency_iso = get_post_meta($post->ID, 'cart_currency', true);

        include 'partials/booking/interval.php';
        include 'partials/booking/field_list.php';
    }

    public function customer_info_box() {

        global $post;

        /* get_customer_checkout_fields($post)
          $fields_to_show     = array();
          $default_fields     = get_default_checkout_fields();
          $custom_fields      = get_post_custom($post->ID);

          foreach($default_fields as $field_key => $field){
          if(isset($custom_fields[$field_key])){
          //$field['value'] = $custom_fields[$field_key][0];
          //$fields_to_show[$field_key] = $field;

          $field['value'] = $custom_fields[$field_key][0];
          $fields_to_show[$field_key] = $field;
          }
          } */

        $fields_to_show = $this->get_customer_checkout_fields($post);

        $checkout_fields = get_enabled_checkout_fields();

        $fields_to_show = array_merge((array) $checkout_fields, (array) $fields_to_show);

        include 'partials/booking/field_list.php';
    }

    public function get_customer_checkout_fields($post) {

        $fields_to_show = array();
        $default_fields = get_default_checkout_fields();
        $custom_fields = get_post_custom($post->ID);

        foreach ($default_fields as $field_key => $field) {
            if (isset($custom_fields[$field_key])) {
                //$field['value'] = $custom_fields[$field_key][0];
                //$fields_to_show[$field_key] = $field;

                $field['value'] = $custom_fields[$field_key][0];
                $fields_to_show[$field_key] = $field;
            }
        }

        return $fields_to_show;
    }

    public function payment_detail_box() {


        global $post;

        $payment_fields = get_payment_fields();
        $fields_to_show = array();
        $custom_fields = get_post_custom($post->ID);

        foreach ($payment_fields as $key => $field) {

            if (isset($custom_fields[$key])) {
                $field['value'] = $custom_fields[$key][0];
                $fields_to_show[$key] = $field;
            }
        }

        $booking = new sc_Booking($post);
        $currency = sc_Currency::get_instance();
        $currency_iso = get_post_meta($post->ID, 'cart_currency', true);

        include 'partials/booking/payment_info.php';
    }

    public function save() {
        //$date = DateTime::createFromFormat('m.d.Y', $_POST['Select-date']);
        if (isset($_POST['booking_status_nonce']) && wp_verify_nonce($_POST['booking_status_nonce'], __FILE__)) {
            global $post;

            if (!empty($_POST['car_r_order_status'])) {
                update_post_meta($post->ID, 'car_r_order_status', sanitize_text_field($_POST['car_r_order_status']));
            }


            $fields_to_show = $this->get_customer_checkout_fields($post);
            $checkout_fields = get_enabled_checkout_fields();
            $fields_to_show = array_merge((array) $checkout_fields, (array) $fields_to_show);

            foreach ($fields_to_show as $key => $val) {
                update_post_meta($post->ID, $key, sanitize_text_field($_POST[$key]));
            }
        }
    }

}
