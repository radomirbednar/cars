<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Car_share
 * @subpackage Car_share/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Car_share
 * @subpackage Car_share/admin
 * @author     My name <mail@example.com>
 */
class Car_share_Admin {

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
     * jednotlive kusy aut, napr 5x fabie,
     *
     * @var type
     */
    public static $single_cars = array();

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

        add_action('in_admin_footer', array($this, 'single_car_js'));

        add_action('wp_ajax_delete_single_car', array($this, 'delete_single_car_ajax'));
        add_action('wp_ajax_create_single_car', array($this, 'create_single_car_ajax'));


        add_action('wp_ajax_calendar_single_car', array($this, 'calendar_single_car_ajax'));

        add_action('admin_init', array($this, 'admin_init'));
    }

    public function admin_init() {
        if (current_user_can('delete_posts')) {
            add_action('delete_post', array($this, 'cleaning'), 10);
        }
    }

    public function calendar_single_car_ajax($car_id) {

        if (isset($_POST['calendar_id'])) {

            $car_id = (int) $_POST['calendar_id'];
            $date_info = $_POST['date_info'];

            $today = DateTime::createFromFormat('m-d-Y H:i:s', $date_info);
            $nextm = clone $today;
            $nextm->modify('first day of next month');
            $stringnextm = $nextm->format("m-d-Y H:i:s");
            $lastm = clone $today;
            $lastm->modify('first day of last month');
            $stringlastm = $lastm->format("m-d-Y H:i:s");
            $today_string = $today->format('F Y');
        
            
        } else {

            //$timestamp = strtotime('now');
            //$date = date("Y-m-d H:i:s");

            $today = new DateTime();
            $nextm = clone $today;
            $nextm->modify('first day of next month');
            $stringnextm = $nextm->format("m-d-Y H:i:s");
            $lastm = clone $today;
            $lastm->modify('first day of last month');
            $stringlastm = $lastm->format("m-d-Y H:i:s");
            $today_string = $today->format('F Y');
        }

        //$timestamp = strtotime('now');
        //$date = date("Y-m-d H:i:s");
        ?>

            <div class="<?php echo $car_id; ?>"> 
            <a href="#" data-car-prew="<?php echo $stringlastm; ?>" class="cal_prew" ><?php _e('<< Prew', $this->car_share) ?></a>
            
            <span id="calendar-date"><?php echo $today_string; ?></span>
            <a href="#" data-car-next="<?php echo $stringnextm; ?>" class="cal_next"><?php _e('Next >>', $this->car_share) ?></a>
            
 
        <?php
        
        require_once('calendar_class.php'); 
        $calendar = new donatj\SimpleCalendar(); 
         if (isset($_POST['calendar_id'])) { 
            $calendar = new donatj\SimpleCalendar($today_string);             
         }
                            
        $calendar->setStartOfWeek('Monday');
//get all date from this car id
//$car_id

        if (false === strpos($car_id, 'new_car')) {
            global $wpdb;
            $sqlcalendar = "SELECT
                *
                FROM
                sc_single_car_status
                WHERE
                single_car_id = $car_id;
                ";

            $calendar_result = $wpdb->get_results($sqlcalendar);
//sc_single_car_status
            $calendar_result = array_filter($calendar_result);

            if (!empty($calendar_result)) {
                foreach ($calendar_result as $calendar_events) {

                    $e_date_from = $calendar_events->date_from;
                    $e_date_to = $calendar_events->date_to;
                    $e_date_status = $calendar_events->status;

                    if ($e_date_status == Car_share::STATUS_UNAVAILABLE) {
                        $cal_status = '<span class="unavailable">Unavailable</span>';
                    }
                    if ($e_date_status == Car_share::STATUS_RENTED) {
                        $cal_status = '<span class="rented">Rented</span>';
                    }
                    if ($e_date_status == Car_share::STATUS_BOOKED) {
                        $cal_status = '<span class="booked">Booked</span>';
                    }
                    $calendar->addDailyHtml($cal_status, $e_date_from, $e_date_to);
                }
            }
        }
        $calendar->show(true);
        ?>
        </div>


        <script> 
            (function($) {
                'use strict';
                $(document).ready(function($) {
                    //get calendar id
                    $(".cal_prew").click(function(event) {
                        event.preventDefault();
                        var id = $(this).parent().attr("class");
                        var date_info = $(this).attr("data-car-prew");
                        var data = {
                            'action': 'calendar_single_car',
                            'calendar_id': id,
                            'date_info': date_info
                                    // We pass php values differently!
                        };
                        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
                        $.post(ajaxurl, data, function(response) {

                            $('.' + id + '').replaceWith(response);

                        });
                    });
                    $(".cal_next").click(function(event) {
                        event.preventDefault();
                        var id = $(this).parent().attr("class");
                        var date_info = $(this).attr("data-car-next");
                        var data = {
                            'action': 'calendar_single_car',
                            'calendar_id': id,
                            'date_info': date_info
                                    // We pass php values differently!
                        };
                        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
                        $.post(ajaxurl, data, function(response) {

                            $('.' + id + '').replaceWith(response);

                        });
                    });

                });
            })(jQuery);
        </script>
 
        <?php
    }

    public function create_single_car_ajax() {

        global $wpdb;

        $id = $_POST['id'];

        $statuses = array();
        $pickup_location = array();
        $dropoff_location = array();

        if (isset($_POST['form'])) {
            $params = array();
            parse_str($_POST['form'], $params);
            if (isset($params['car'][$id]['pickup_location'])) {
                foreach ($params['car'][$id]['pickup_location'] as $val) {
                    $pickup_location[] = $val;
                }
            }

            if (isset($params['car'][$id]['dropoff_location'])) {
                foreach ($params['car'][$id]['dropoff_location'] as $val) {
                    $dropoff_location[] = $val;
                }
            }

            if (isset($params['car'][$id]['status'])) {
                foreach ($params['car'][$id]['status'] as $val) {

                    $from_string = $val['from'] . ' ' . sprintf("%02s", $val['from_hour']) . ':' . sprintf("%02s", $val['from_min']);
                    $date_from = DateTime::createFromFormat('d.m.Y H:i', $from_string);

                    $to_string = $val['to'] . ' ' . sprintf("%02s", $val['to_hour']) . ':' . sprintf("%02s", $val['to_min']);
                    ;
                    $date_to = DateTime::createFromFormat('d.m.Y H:i', $to_string);

                    if (!empty($date_from)) {
                        $val['date_from'] = $date_from->format('Y-m-d H:i:s');
                    }

                    if (!empty($date_to)) {
                        $val['date_to'] = $date_to->format('Y-m-d H:i:s');
                    }

                    $statuses[] = $val;
                }
            }
        }

        $car_id = 'new_car_' . rand(0, 50000);
        $label = __('New car', $this->car_share);

        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-location' AND post_status = 'publish' ORDER BY post_title ASC ";
        $locations = $wpdb->get_results($sql);

        //ob_start();
        include 'partials/car/single_car_box.php';



        //$html = ob_get_contents();
        //ob_end_clean();
        //array_walk ( $statuses , '(array)');
        /*
          $return = array(
          'html' => $html,
          'car_status' => $statuses,
          'car_id' => $car_id
          );

          echo json_encode($return);
         */
        die();
    }

    public function delete_single_car_ajax() {

        global $wpdb;
        $id = $_POST['id'];

        if (false !== strpos($id, 'new_car')) {
            die();
        }

        $sql = "DELETE FROM sc_single_car WHERE single_car_id = '" . (int) $id . "'";
        $wpdb->query($sql);

        $sql = "DELETE FROM sc_single_car_location WHERE single_car_id = '" . (int) $id . "'";
        $wpdb->query($sql);

        $sql = "DELETE FROM sc_single_car_status WHERE single_car_id = '" . (int) $id . "' AND status != '" . Car_share::STATUS_BOOKED . "'";
        $wpdb->query($sql);

        die();
    }

    public function single_car_js() {
        include 'partials/car/js-statuses.php';
    }

    /**
     * Register the stylesheets for the Dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Car_share_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Car_share_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->car_share, plugin_dir_url(__FILE__) . 'css/car_share-admin.css', array(), $this->version, 'all');
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    }

    /**
     * Register the JavaScript for the dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Car_share_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Car_share_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->car_share, plugin_dir_url(__FILE__) . 'js/car_share-admin.js', array('jquery'), $this->version, true);
        wp_enqueue_script('jquery-ui-datepicker', false, array('jquery'));
    }

    public function add_custom_boxes() {

        global $post;
        $this->load_single_cars($post->ID);

        foreach (Car_share_Admin::$single_cars as $key => $value) {

            if ('new_car' == (string) $key) {
                $label = 1;
                $value = 'new_car';
            } else {
                $label = $value;
            }

            add_meta_box(
                    'single_car_box_' . $value, sprintf(__('Single car #%s', $this->car_share), $label), array($this, 'single_car_box'), 'sc-car'
            );
            //$i++;
        }

        reset(Car_share_Admin::$single_cars);

        add_meta_box(
                'car_category_box', __('Category', $this->car_share), array($this, 'car_category_box'), 'sc-car'
        );

        add_meta_box(
                'car_details_box', __('Details', $this->car_share), array($this, 'details_box'), 'sc-car'
        );

        /*
          add_meta_box(
          'add_new_single_car_box', __('Add new single car', $this->car_share), array($this, 'add_new_single_car_box'), 'sc-car', 'side'
          ); */

        add_meta_box(
                'service_price_box', __('Price', $this->car_share), array($this, 'service_price_box'), 'sc-service'
        );

        add_meta_box(
                'service_quantity_box', __('Quantity', $this->car_share), array($this, 'service_quantity_box'), 'sc-service'
        );
    }

    function add_new_single_car_box() {
        include 'partials/car/add_new_single_car.php';
    }

    public function single_car_box() {

        global $post;
        global $wpdb;

        $car_id = current(Car_share_Admin::$single_cars);
        $key = key(Car_share_Admin::$single_cars);

        //$label = $car_id;

        if ('new_car' == (string) $key) {
            $car_id = 'new_car';
            //$label = 1;
        }

        next(Car_share_Admin::$single_cars);

        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-location' AND post_status = 'publish' ORDER BY post_title ASC ";
        $locations = $wpdb->get_results($sql);

        $sql = "SELECT location_id FROM sc_single_car_location WHERE single_car_id = '" . (int) $car_id . "' AND location_type = '" . Car_share::PICK_UP_LOCATION . "'";
        $pickup_location = $wpdb->get_col($sql);

        $sql = "SELECT location_id FROM sc_single_car_location WHERE single_car_id = '" . (int) $car_id . "' AND location_type = '" . Car_share::DROP_OFF_LOCATION . "'";
        $dropoff_location = $wpdb->get_col($sql);

        $sql = "SELECT * FROM sc_single_car_status WHERE single_car_id = '" . (int) $car_id . "' AND status != '" . Car_share::STATUS_BOOKED . "' ORDER BY single_car_status_id ASC";
        $statuses = $wpdb->get_results($sql);

        $sql = "SELECT spz FROM sc_single_car WHERE single_car_id = '" . (int) $car_id . "'";
        $spz = $wpdb->get_var($sql);

        include 'partials/car/single_car.php';
    }

    public function car_category_box() {
        global $post;
        global $wpdb;

        $current_car_category = get_post_meta($post->ID, '_car_category', true);

        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-car-category' AND post_status IN ('publish', 'pending', 'draft', 'private') ORDER BY post_title DESC";
        $car_categories = $wpdb->get_results($sql);
        include 'partials/car/category.php';

        wp_nonce_field(__FILE__, 'car_nonce');
    }

    public function unavailability_box() {
        include 'partials/car/unavailability_box.php';
    }

    public function details_box() {
        global $post;

        $number_of_seats = get_post_meta($post->ID, '_number_of_seats', true);
        $number_of_doors = get_post_meta($post->ID, '_number_of_doors', true);
        $number_of_suitcases = get_post_meta($post->ID, '_number_of_suitcases', true);
        $transmission = get_post_meta($post->ID, '_transmission', true);

        include 'partials/car/details.php';
    }

    /**
     * @global type $post
     */
    public function service_price_box() {
        global $post;

        $service_fee = get_post_meta($post->ID, '_service_fee', true);
        $per_service = get_post_meta($post->ID, '_per_service', true);

        include 'partials/service/price_box.php';
        wp_nonce_field(__FILE__, 'service_fee_nonce');
    }

    public function service_quantity_box() {
        global $post;

        $service_quantity_box = get_post_meta($post->ID, '_service_quantity_box', true);

        include 'partials/service/quantity_box.php';
        wp_nonce_field(__FILE__, 'service_qt_nonce');
    }

    public function save() {

        global $post;
        global $wpdb;

        /*
         *
         * save car atributs
         *
         */
        if (isset($_POST['car_nonce']) && wp_verify_nonce($_POST['car_nonce'], __FILE__)) {
            //
            $keys = array(
                '_number_of_seats',
                '_number_of_doors',
                '_number_of_suitcases',
                '_transmission',
                '_car_category'
            );

            $this->save_post_keys($post->ID, $keys);

            // clean pick up / drop off locations
            $sql = "DELETE FROM sc_single_car_location WHERE single_car_id IN (SELECT single_car_id FROM sc_single_car WHERE parent = '" . $post->ID . "')";
            $wpdb->query($sql);

            // clean
            $sql = "DELETE FROM sc_single_car_status WHERE status != '" . Car_share::STATUS_BOOKED . "' AND single_car_id IN (SELECT single_car_id FROM sc_single_car WHERE parent = '" . $post->ID . "')";
            $wpdb->query($sql);

            if (!empty($_POST['car'])) {

                foreach ($_POST['car'] as $single_car_id => $car) {

                    if (false !== strpos($single_car_id, 'new_car')) {

                        $sql = "INSERT INTO sc_single_car (parent) VALUES (
                                        '" . $post->ID . "'
                            )";

                        $wpdb->query($sql);
                        $single_car_id = $wpdb->insert_id;
                    }

                    $sql = "
                        INSERT INTO sc_single_car (single_car_id, spz) VALUES (
                            '" . (int) $single_car_id . "',
                            '" . esc_sql($car['spz']) . "'
                        ) ON DUPLICATE KEY UPDATE spz = '" . esc_sql($car['spz']) . "'";

                    $wpdb->query($sql);

                    foreach ($car as $key => $attribute) {
                        switch ($key) {
                            case 'status':
                                foreach ($attribute as $car_status) {
                                    $date_from_string = $car_status['from'] . ' ' . sprintf("%02s", $car_status['from_hour']) . ' ' . sprintf("%02s", $car_status['from_min']);
                                    $date_from = DateTime::createFromFormat('d.m.Y H i', $date_from_string);

                                    $date_to_string = $car_status['to'] . ' ' . sprintf("%02s", $car_status['to_hour']) . ' ' . sprintf("%02s", $car_status['to_min']);
                                    $date_to = DateTime::createFromFormat('d.m.Y H i', $date_to_string);

                                    if (!empty($date_from) && !empty($date_to)) {

                                        sc_Car::insertStatus($single_car_id, $date_from, $date_to, $car_status['status']);
                                    }
                                }
                                break;
                            case 'pickup_location':

                                foreach ($attribute as $location_id) {
                                    $sql = "
                                        INSERT INTO
                                            sc_single_car_location (single_car_id, location_id, location_type)
                                        VALUES (
                                            '" . (int) $single_car_id . "',
                                            '" . (int) $location_id . "',
                                            '" . Car_share::PICK_UP_LOCATION . "'
                                        )
                                    ";

                                    $wpdb->query($sql);
                                }

                                break;
                            case 'dropoff_location':

                                foreach ($attribute as $location_id) {
                                    $sql = "
                                        INSERT INTO
                                            sc_single_car_location (single_car_id, location_id, location_type)
                                        VALUES (
                                            '" . (int) $single_car_id . "',
                                            '" . (int) $location_id . "',
                                            '" . Car_share::DROP_OFF_LOCATION . "'
                                        )
                                    ";

                                    $wpdb->query($sql);
                                }
                                break;
                        }
                    }
                }
            }
        }

        /*
         * saving services attributes
         */
        if (isset($_POST['service_fee_nonce']) && wp_verify_nonce($_POST['service_fee_nonce'], __FILE__)) {

            update_post_meta($post->ID, '_service_fee', sanitize_text_field(str_replace(',', '.', $_POST['_service_fee'])));
            //0 - per day 1 - per rental
            update_post_meta($post->ID, '_per_service', $_POST['_per_service']);
        }

        if (isset($_POST['service_qt_nonce']) && wp_verify_nonce($_POST['service_qt_nonce'], __FILE__)) {


            if (ctype_digit($_POST['_service_quantity_box'])) {
                update_post_meta($post->ID, '_service_quantity_box', $_POST['_service_quantity_box']);
            }
        }
    }

    public function save_post_keys($post_id, $keys) {
        foreach ($keys as $key) {
            if (!empty($_POST[$key])) {
                update_post_meta($post_id, $key, $_POST[$key]);
            } else {
                delete_post_meta($post_id, $key);
            }
        }
    }

    public function load_single_cars($post_id) {

        if (!empty(Car_share_Admin::$single_cars)) {
            return Car_share_Admin::$single_cars;
        }

        global $wpdb;

        $sql = "
            SELECT
                single_car_id
            FROM
                sc_single_car
            WHERE
                parent = '" . $post_id . "'
            ORDER BY
                single_car_id
            ASC
        ";

        $result = $wpdb->get_col($sql);

        if (!empty($result)) {
            self::$single_cars = $result;
        } else {
            Car_share_Admin::$single_cars = array(
                'new_car' => '1'
            );
        }

        return Car_share_Admin::$single_cars;
    }

    /**
     *
     */
    public function cleaning($post_id) {

        //global $post;
        //if(in_array($post->post_type, array('sc-booking', 'sc-season')) ){
        delete_all_date_metas($post_id);
        //}
    }

}
