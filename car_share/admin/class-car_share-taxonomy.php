<?php

class Car_share_Taxonomy {
    
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
    
    
    
    
    
    
}

