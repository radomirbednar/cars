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
    
    protected $currencies;

    protected function __construct() {
        
    }

    protected function __clone(){

    }

    public static function get_instance(){

        if(!isset(sc_Currency::$instance)){
            
            sc_Currency::$instance = new sc_Currency();
            
            $sc_options_paypal = get_option('second_set_arraykey');
            sc_Currency::$instance->iso = $sc_options_paypal['sc-currency'];
            
            sc_Currency::$instance->currencies = return_currencies();
            sc_Currency::$instance->symbol = sc_Currency::$instance->currencies[sc_Currency::$instance->iso]["symbol"];
        }
        return sc_Currency::$instance;
    }

    public function format($price, $currency = ''){         
        
        if(empty($currency)){
            $symbol = $this->symbol;
        } else {
            $symbol = isset($this->currencies[$currency]["symbol"]) ? $this->currencies[$currency]["symbol"] : '';
        }   
       
        $price = number_format($price, 2, ',', ' ');   
        $price_formated = $price . ' ' . $symbol;          
        return $price_formated; 
        }

    public function symbol(){
        return $this->symbol;
    }
    
    public function iso(){
        return $this->iso;
    }
}
