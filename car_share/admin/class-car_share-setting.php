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
 
        // Add an action link pointing to the options page.
        $plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->car_share . '.php');
        add_filter('plugin_action_links_' . $plugin_basename, array($this, 'add_action_links'));
       
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
