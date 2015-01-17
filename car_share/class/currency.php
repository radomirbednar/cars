<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class sc_Currency {

    protected static $instance = null;
    
    protected $currency_symbol;
    
    protected $currency;

    protected function __construct() {
        
    }

    protected function __clone(){

    }

    public static function get_instance(){

        if(!isset(sc_Currency::$instance)){
            
            sc_Currency::$instance = new sc_Currency();
            
            $sc_options_paypal = get_option('second_set_arraykey');
            sc_Currency::$instance->currency = $sc_options_paypal['sc-currency'];
            
            $currencyforpeople = return_currencies();
            sc_Currency::$instance->currency_symbol = $currencyforpeople[sc_Currency::$instance->currency]["symbol"];
        }
        return sc_Currency::$instance;
    }

    public function format($price){        
        $price_formated = $price . ' ' . $this->currency_symbol;        
        return $price_formated;
    }

    public function currency_symbol(){
        return $this->currency_symbol;
    }
}
