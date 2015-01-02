<?php

class Car {

    
    
    public function __construct($id) {
        
    }
    
    public function priceFromTo(DateTime $from, DateTime $to){
        
    }
    
    public function isAvailableFromTo(DateTime $from, DateTime $to){
        
    }
    
    public static function getTransmissionOptions(){
        
        $arr = array(
            1 => 'Manual',
            2 => 'Automatic',
        );
        
        return $arr;        
    }

    
}

