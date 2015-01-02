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
                'main-settings-section', 'Main Settings', array($this, 'print_main_settings_section_info'), 'test-plugin-main-settings-section'
        );

// add_settings_field( $id, $title, $callback, $page, $section, $args )
        add_settings_field(
                'some-setting', 'Some Setting', array($this, 'create_input_some_setting'), 'test-plugin-main-settings-section', 'main-settings-section'
        );

// register_setting( $option_group, $option_name, $sanitize_callback )
        register_setting('main-settings-group', 'test_plugin_main_settings_arraykey', array($this, 'plugin_main_settings_validate'));

// add_settings_section( $id, $title, $callback, $page )
        add_settings_section(
                'additional-settings-section', 'Additional Settings', array($this, 'print_additional_settings_section_info'), 'test-plugin-additional-settings-section'
        );

// add_settings_field( $id, $title, $callback, $page, $section, $args )
        add_settings_field(
                'another-setting', 'Another Setting', array($this, 'create_input_another_setting'), 'test-plugin-additional-settings-section', 'additional-settings-section'
        );

// register_setting( $option_group, $option_name, $sanitize_callback )
        register_setting('additional-settings-group', 'test_plugin_additonal_settings_arraykey', array($this, 'plugin_additional_settings_validate'));
    }

    function print_main_settings_section_info() {
        echo '<p>Main Settings Description.</p>';
    }

    function create_input_some_setting() {
        $options = get_option('test_plugin_main_settings_arraykey');
        ?><input type="text" name="test_plugin_main_settings_arraykey[some-setting]" value="<?php echo $options['some-setting']; ?>" /><?php
    }

    function plugin_main_settings_validate($arr_input) {
        $options = get_option('test_plugin_main_settings_arraykey');
        $options['some-setting'] = trim($arr_input['some-setting']);
        return $options;
    }

    function print_additional_settings_section_info() {
        echo '<p>Additional Settings Description.</p>';
    }

    function create_input_another_setting() {
        $options = get_option('test_plugin_additonal_settings_arraykey');
        ?><input type="text" name="test_plugin_additonal_settings_arraykey[another-setting]" value="<?php echo $options['another-setting']; ?>" /><?php
    }

    function plugin_additional_settings_validate($arr_input) {
        $options = get_option('test_plugin_additonal_settings_arraykey');
        $options['another-setting'] = trim($arr_input['another-setting']);
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

}
