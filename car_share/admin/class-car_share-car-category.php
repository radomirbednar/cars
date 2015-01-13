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

        //add_action('in_admin_footer', array($this, 'new_season_to_category'));
        //add_action('in_admin_footer', array($this, 'new_season_to_category'));
        //add_action('wp_ajax_add_season_to_category', array($this, 'add_season_to_category_callback'));
        //add_action('wp_ajax_edit_season_to_category', array($this, 'edit_season_to_category_callback'));
        add_action('wp_ajax_reload_season2category', array($this, 'reload_season2category_callback'));
        add_action('wp_ajax_new_season_to_category', array($this, 'ajax_new_season_to_category'));
        add_action('wp_ajax_edit_season_to_category', array($this, 'ajax_edit_season_to_category'));        
        add_action('wp_ajax_season2category_days', array($this, 'ajax_season2category_days'));
        add_action('wp_ajax_delete_season_to_category', array($this, 'ajax_delete_season_to_category'));
        add_action('wp_ajax_save_season2category', array($this, 'ajax_save_season2category'));
    }
    
    /*
    public function ajax_reload_s2c_content(){
        global $post;
        $category = new sc_Category($post);
        $season2category_prices = $category->season_to_category_prices();
        
        include 'partials/car-category/content_assigned_season.php';
        exit();        
    }*/

    public function ajax_save_season2category() {

        global $wpdb;
        $car_category_id = (int) $_POST['id']; //
        
        $params = array();
        parse_str($_POST['form'], $params);                

        // category day prices
        if (!empty($params['_season_to_category_prices'])) {
            foreach ($params['_season_to_category_prices'] as $dayname => $price) {
                $sql = "
                    REPLACE INTO day_prices (car_category_id, season_id, dayname, price) VALUES (
                        '" . $car_category_id . "',
                        '" . (int) $params['_season_to_category'] . "',
                        '" . esc_sql($dayname) . "',
                        '" . floatval($price) . "'
                    )
                    ";
                $wpdb->query($sql);
            }
        }

        $category = new sc_Category($car_category_id);
        $season2category_prices = $category->season_to_category_prices();

        include 'partials/car-category/content_assigned_season.php';
        exit();
    }

    public function add_custom_boxes() {

        add_meta_box(
                'car_category_young_driver_surcharge', __('Young driver surcharge ', $this->car_share), array($this, 'young_driver_surcharge'), 'sc-car-category'
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

    function ajax_delete_season_to_category() {

        $category_id = $_POST['id'];
        $season_id = $_POST['season_id'];

        global $wpdb;

        $sql = "
            DELETE FROM
                day_prices
            WHERE
                car_category_id = '" . (int) $category_id . "'
            AND
                season_id = '" . (int) $season_id . "'
        ";

        return $wpdb->query($sql);
    }

    
    /**
     *
     * @global type $wpdb
     */
    function ajax_season2category_days() {

        $post_id = $_POST['id']; // category id
        $season_id = $_POST['season_id'];
        global $wpdb;

        $season = new sc_Season($season_id);

        $new_season_from = $season->from();
        $new_season_to = $season->to();

        if (empty($new_season_from) || empty($new_season_to)) {
            header("HTTP/1.0 404 Not Found");
            _e('Please first define season start and end date.', $this->car_share);
            exit;
        }

        $sql = "
            SELECT
                season_id
            FROM
                day_prices
            WHERE
                car_category_id = '" . (int) $post_id . "'
            AND
                season_id = '" . (int) $season_id . "'
        ";

        $exists = $wpdb->get_var($sql);

        if (!empty($exists)) {
            header("HTTP/1.0 404 Not Found");
            _e('Please, pick a season which is not applied yet.', $this->car_share);
            exit;
        }

        //
        // find all assigned season
        $sql = "SELECT
                    ID,
                    start.meta_value as date_from,
                    end.meta_value as date_to
                FROM
                    $wpdb->posts s
                JOIN
                    postmeta_date start ON s.ID = start.post_id AND start.meta_key = '_from'
                JOIN
                    postmeta_date end ON s.ID = end.post_id AND end.meta_key = '_to'
                WHERE
                    s.post_status NOT IN ('trash') AND s.post_type='sc-season'
                AND
                    s.ID != '" . (int) $season_id . "'
                AND
                (
                    (start.meta_value BETWEEN '" . $new_season_from->format('Y-m-d  H:i:s') . "' AND '" . $new_season_to->format('Y-m-d  H:i:s') . "')
                        OR
                    ('" . $new_season_from->format('Y-m-d  H:i:s') . "' BETWEEN start.meta_value AND end.meta_value)
                )
                GROUP BY s.ID
                ";

        $applied_seasons = $wpdb->query($sql);

        if (!empty($applied_seasons)) {
            header("HTTP/1.0 404 Not Found");
            _e('You cannot assign two season with overlaping dates.', $this->car_share);
            exit;
        }

        include 'partials/car-category/s2c_days_price_inputs.php';
        die();
    }

    public function ajax_edit_season_to_category() {
        //global $post;
        $post_id = $_POST['id']; // category id
        $season_id = $_POST['season_id'];        
        //$season = new sc_Season($season_id);
        
        $car_category = new sc_Category($post_id);
        $category_day_prices = $car_category->day_prices_indexed_with_dayname($season_id);
        
        include 'partials/car-category/s2c_days_price_inputs.php';
        die();
    }    
    
    public function ajax_new_season_to_category() {
        //global $post;
        global $wpdb;
        $post_id = $_POST['id'];
        
        
        $sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'sc-season' AND post_status IN ('publish')";
        $seasons = $wpdb->get_results($sql);

        include 'partials/car-category/new_season_to_category.php';
        die();
    }

    public function reload_season2category_callback() {
        global $wpdb;

        $car_category_id = $_GET['id'];

        $category = new sc_Category($car_category_id);
        $season2category = $category->day_prices_indexed_with_dayname();

        include 'partials/car-category/content_assigned_season.php';
        die();
    }

    /*
    public function edit_season_to_category_callback() {
        global $wpdb;

        $season_id = $_GET['season_id'];
        $post_id = $_GET['car_category_id'];

        $category = new sc_Category($post_id);
        $season2category = $category->day_prices_indexed_with_dayname($season_id);

        include 'partials/car-category/edit_s2c.php';
        die();
    }*/

    /*
      public function add_season_to_category_callback() {

      global $wpdb;
      $post_id = (int) $_POST['_car_category_id'];

      // category day prices
      if (!empty($_POST['_season_to_category_prices'])) {
      foreach ($_POST['_season_to_category_prices'] as $dayname => $price) {
      $sql = "
      REPLACE INTO day_prices (car_category_id, season_id, dayname, price) VALUES (
      '" . $post_id . "',
      '" . (int) $_POST['_season_to_category'] . "',
      '" . esc_sql($dayname) . "',
      '" . floatval($price) . "'
      )
      ";
      $wpdb->query($sql);
      }
      }

      $category = new sc_Category($post_id);
      $season2category_prices = $category->season_to_category_prices();

      include 'partials/car-category/content_assigned_season.php';
      exit();
      } */

    public function young_driver_surcharge() {
        global $post;
        $surcharge_age = get_post_meta($post->ID, '_surcharge_age', true);
        $surcharge_fee = get_post_meta($post->ID, '_surcharge_fee', true);
        $surcharge_active = get_post_meta($post->ID, '_surcharge_active', true);
        include 'partials/car-category/minimum_driver_age.php';
    }

    public function day_prices_box() {
        global $post;
        $category = new sc_Category($post);
        $category_day_prices = $category->day_prices_indexed_with_dayname();
        include 'partials/car-category/day_prices.php';
    }

    public function assigned_season_box() {
        global $post;
        $category = new sc_Category($post);
        $season2category_prices = $category->season_to_category_prices();
        include 'partials/car-category/season2category.php';
    }

    public function discount_upon_duration_box() {
        global $post;
        $discount_upon_duration = get_post_meta($post->ID, '_discount_upon_duration', true);

        if (is_array($discount_upon_duration)) {
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
            if (!empty($_POST['_category_day_prices'])) {
                foreach ($_POST['_category_day_prices'] as $dayname => $price) {
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

            if (!empty($_POST['_discount_upon_duration'])) {
                $arr_to_save = array();
                foreach ($_POST['_discount_upon_duration'] as $discount) {
                    $days = (int) $discount['days'];
                    $percentage = floatval($discount['percentage']);
                    $arr_to_save[$days] = $percentage;
                }
                update_post_meta($post->ID, '_discount_upon_duration', $arr_to_save);
            }

            //
            $keys = array(
                '_surcharge_age',                
                '_surcharge_fee',
            );

            foreach ($keys as $key) {
                if (isset($_POST[$key]) && "" != trim($_POST[$key])) {
                    update_post_meta((int) $post->ID, $key, esc_attr($_POST[$key]));
                } else {
                    delete_post_meta((int) $post->ID, $key);
                }
            }
            
            if(isset($_POST['_surcharge_active']) && 1 == $_POST['_surcharge_active']){
                update_post_meta((int) $post->ID, '_surcharge_active', 1);
            } else{
                delete_post_meta((int) $post->ID, '_surcharge_active');
            }
        }
    }

}
