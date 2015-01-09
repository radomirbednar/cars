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
class Car_share_Setting {

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


    private $inputs = array(
        '_name' => 'Fullname',
        '_email' => 'Email address',
        '_phone' => 'Phone',
        '_address_1' => 'Address 1',
        '_address_2' => 'Address 2',
        '_city' => 'City',
        '_country' => 'Country',
        '_zip' => 'Zip',
    );

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

        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));


        // Add an action link pointing to the options page.
        $plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->car_share . '.php');
        add_filter('plugin_action_links_' . $plugin_basename, array($this, 'add_action_links'));

        // Setting
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     */
    public function add_plugin_admin_menu() {
        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         */
        $this->plugin_screen_hook_suffix = add_menu_page(
                __('Car plugin settings', $this->car_share), __('Car plugin setting', $this->car_share), 'manage_options', $this->car_share, array($this, 'display_plugin_admin_page')
        );

        add_submenu_page($this->car_share, __('Checkout form setup', $this->car_share), __('Checkout form setup', $this->car_share), 'manage_options', 'checkout-form-setup', array($this, 'checkout_form_setup'));
    }


    public function checkout_form_setup(){
        if(isset($_POST['save_checkout_form_setup'])){
            $arr_to_save = array();
            foreach($this->inputs as $input_key => $input_value){

                $enabled = isset($_POST['billing_inputs'][$input_key]['enabled']) && 1 == $_POST['billing_inputs'][$input_key]['enabled'] ? 1 : 0;
                $required = isset($_POST['billing_inputs'][$input_key]['required']) && 1 == $_POST['billing_inputs'][$input_key]['required'] ? 1 : 0;                
                
                $arr_to_save[] = array(
                    'visible' => $enabled,
                    'required' => $required,
                );
            }
        }

        $input_options = array();

        include_once( 'partials/checkout_form_setup.php' );
        wp_nonce_field(__FILE__, 'checkout_form_nonce' );
    }

    /**
     * Render the settings page for this plugin.
     *
     * removed from the plugin added by me
     */
    public function display_plugin_admin_page() {
        include_once( 'partials/car_share-admin-display.php' );
    }

    function register_settings() {

// add_settings_section( $id, $title, $callback, $page )
        add_settings_section(
                'main-settings-section', 'General Settings', array($this, 'print_main_settings_section_info'), 'test-plugin-main-settings-section'
        );
// add_settings_field( $id, $title, $callback, $page, $section, $args )
        add_settings_field(
                'notemail', 'Notification Email:', array($this, 'create_input_some_setting'), 'test-plugin-main-settings-section', 'main-settings-section'
        );
        add_settings_field(
                'showcategory', 'Show category:', array($this, 'create_input_some_show_cat'), 'test-plugin-main-settings-section', 'main-settings-section'
        );

// register_setting( $option_group, $option_name, $sanitize_callback )

        register_setting('main-settings-group', 'car_plugin_options_arraykey', array($this, 'plugin_main_settings_validate'));

// add_settings_section( $id, $title, $callback, $page )
        add_settings_section(
                'additional-settings-section', 'Additional Settings', array($this, 'print_additional_settings_section_info'), 'test-plugin-additional-settings-section'
        );

// add_settings_field( $id, $title, $callback, $page, $section, $args )
        add_settings_field(
                'another-setting', 'Measurement Unit: ', array($this, 'create_input_another_setting'), 'test-plugin-additional-settings-section', 'additional-settings-section'
        );

        add_settings_field(
                'currency-setting', 'Currency Setting', array($this, 'create_currency_another_setting'), 'test-plugin-additional-settings-section', 'additional-settings-section'
        );

// register_setting( $option_group, $option_name, $sanitize_callback )
        register_setting('additional-settings-group', 'second_set_arraykey', array($this, 'plugin_additional_settings_validate'));
    }

    function print_main_settings_section_info() {
        echo '<p>General Setting.</p>';
    }

    function create_input_some_setting() {
        $options = get_option('car_plugin_options_arraykey');
        ?><input type="text" name="car_plugin_options_arraykey[notemail]" value="<?php echo $options['notemail']; ?>" />
        <?php
    }

    function create_input_some_show_cat() {

        $options = get_option('car_plugin_options_arraykey');
        ?>
        <input type="checkbox" name="car_plugin_options_arraykey[showcategory]" value="1" <?php
        if (isset($options['showcategory']) && ($options['showcategory'] == 1)) {
            echo 'checked';
        }
        ?> />
        <?php
           }
           function plugin_main_settings_validate($arr_input) {
               $options = get_option('car_plugin_options_arraykey');
               $options['notemail'] = trim($arr_input['notemail']);
               $options['showcategory'] = trim($arr_input['showcategory']);
               return $options;
           }
           function print_additional_settings_section_info() {
               echo '<p>Additional Settings Description.</p>';
           }
           function create_input_another_setting() {
               $options = get_option('second_set_arraykey');
               ?><input type="text" name="second_set_arraykey[sc-unit]" value="<?php echo $options['sc-unit']; ?>" /><?php
           }
           function create_currency_another_setting() {
               $options = get_option('second_set_arraykey');
               include_once( 'partials/currencies.php' );
               echo "<select name='second_set_arraykey[sc-currency]'>";
               foreach ($currencies as $currency_code => $currency_details) {
                   $selected = "";
                   if ($options['sc-currency'] == $currency_code) {
                       $selected = " selected ";
                   }
                   echo "<option value='" . esc_attr($currency_code) . "'" . esc_attr($selected) . ">" . esc_html($currency_details['name']) . "</option>";
               }
               echo "</select>";
            }

        function plugin_additional_settings_validate($arr_input) {

            $options = get_option('second_set_arraykey');
            $options['sc-unit'] = trim($arr_input['sc-unit']);
            $options['sc-currency'] = trim($arr_input['sc-currency']);

            return $options;
        }

    /**
     * Add settings action link to the plugins page.
     *
     * removed from the plugin added by me
     */
    public function add_action_links($links) {
        return array_merge(
                array(
            'settings' => '<a href="' . admin_url('options-general.php?page=' . $this->car_share) . '">' . __('Settings', $this->car_share) . '</a>'
                ), $links
        );
    }

    /*
     *
     * create the page for the plugin
     *
     */

    public function my_plugin_install_function() {

    }

}
