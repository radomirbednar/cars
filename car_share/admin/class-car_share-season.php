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

        add_filter('manage_sc-season_posts_columns', array($this, 'column_head'));
        add_action('manage_sc-season_posts_custom_column', array($this, 'column_content'), 10, 2);
        
        add_action('wp_ajax_date_interval_row', array($this, 'date_interval_row'));
        add_action('wp_ajax_date_interval_row', array($this, 'date_interval_row'));                
    }

    public function column_head($defaults) {
        $defaults['date_from'] = __('From', $this->car_share);
        $defaults['date_to'] = __('To', $this->car_share);
        return $defaults;
    }

    public function column_content($column_name, $post_id) {

        switch ($column_name) {
            case 'date_from':
                $from = get_date_meta($post_id, '_from');
                if (!empty($from)) {
                    echo $from->format(get_option('date_format'));
                }
                break;
            case 'date_to':
                $to = get_date_meta($post_id, '_to');
                if (!empty($to)) {
                    echo $to->format(get_option('date_format'));
                }
                break;
        }
    }

    public function add_custom_boxes() {
        add_meta_box(
                'season_date_box', __('Date interval', $this->car_share), array($this, 'date_box'), 'sc-season'
        );
    }

    public function date_box() {
        global $post;
        $session = new sc_Season($post);
        include 'partials/season/date_interval.php';
        wp_nonce_field(__FILE__, 'season_nonce');
    }

    public function save() {
        //$date = DateTime::createFromFormat('m.d.Y', $_POST['Select-date']);
        if (isset($_POST['season_nonce']) && wp_verify_nonce($_POST['season_nonce'], __FILE__)) {

            global $post;
            global $wpdb;

            $sql = "DELETE FROM sc_season_date WHERE post_id = '" . $post->ID . "'";
            $wpdb->query($sql);

            foreach ($_POST['_from'] as $key => $from) {

                $to = $_POST['_to'][$key];

                $date_from = DateTime::createFromFormat('d.m.Y H:i:s', $from . ' 00:00:00');
                $date_to = DateTime::createFromFormat('d.m.Y H:i:s', $to . ' 23:59:59');

                if (!empty($date_from) && !empty($date_to)) {

                    $sql = "
                        INSERT INTO
                            sc_season_date (post_id, date_from, date_to)
                        VALUES (
                           '" . $post->ID . "',
                           '" . $date_from->format('Y-m-d H:i:s') . "',
                           '" . $date_to->format('Y-m-d H:i:s') . "'
                        )
                    ";

                    $wpdb->query($sql);
                }
            }
        }
    }
    
    public function date_interval_row(){
        echo date_row_static('', '', true);
        exit();
    }

    public static function date_row_static($date_from, $date_to, $delete_button = false){
        ob_start();
        include 'partials/season/date_row.php';
        $content = ob_get_clean();
        return $content;
    }
    
}