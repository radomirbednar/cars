<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Car_share_Shortcode {
    
    public function __construct($car_share, $version) {

        $this->car_share = $car_share;
        $this->version = $version;

        add_shortcode( 'search_for_car', array($this, 'search_for_car'));
        add_shortcode( 'pick_car', array($this, 'pick_car'));
    }
    
    public function search_for_car($atts) { 
        ob_start();
        include_once( 'partials/shortcode/search_for_car.php' );
        return ob_get_clean(); 
    }
    
    public function pick_car($atts) { 
        ob_start();
        include_once( 'partials/shortcode/pick_car.php' );
        return ob_get_clean(); 
    }    
    
}
