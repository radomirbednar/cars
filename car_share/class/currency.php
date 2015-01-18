<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class sc_Currency {

    protected static $instance = null;
    
    protected $symbol;
    
    protected $iso;

    protected function __construct() {
        
    }

    protected function __clone(){

    }

    public static function get_instance(){

        if(!isset(sc_Currency::$instance)){
            
            sc_Currency::$instance = new sc_Currency();
            
            $sc_options_paypal = get_option('second_set_arraykey');
            sc_Currency::$instance->iso = $sc_options_paypal['sc-currency'];
            
            $currencyforpeople = return_currencies();
            sc_Currency::$instance->symbol = $currencyforpeople[sc_Currency::$instance->iso]["symbol"];
        }
        return sc_Currency::$instance;
    }

    public function format($price){        
        $price_formated = $price . ' ' . $this->symbol;        
        return $price_formated;
    }

    public function symbol(){
        return $this->symbol;
    }
    
    public function iso(){
        return $this->iso;
    }
}
