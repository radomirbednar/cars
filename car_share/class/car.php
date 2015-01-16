<?php

class sc_Car {

    
    
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
    
    public static function getFuelOptions(){
         
        $arr = array( 
          1=> 'Petrol',
          2=> 'Mixed',
          3=> 'Diesel',   
        );  
        return $arr; 
    }
    
    public static function getAirOptions(){ 
        $arr = array( 
          1=> 'yes',
          2=> 'no',  
        );  
        return $arr; 
    }
     
    public static function insertStatus($single_car_id, DateTime $from, $to, $status, $booking_id = 0){

        global $wpdb;
        
        $sql = "
        INSERT INTO
            sc_single_car_status (single_car_id, date_from, date_to, status, booking_id)
        VALUES (
            '" . (int) $single_car_id . "',
            '" . (empty($from) ? "" : $from->format('Y-m-d H:i:s')) . "',
            '" . (empty($to) ? "" : $to->format('Y-m-d H:i:s')) . "',
            '" . (int) $status . "',
            '" . (int) $booking_id . "'
        )";

        $wpdb->query($sql);        
        
    }
    
    public static function get_parent_by_single_id($single_car_id){
        
        global $wpdb;
        
        $sql = "
            SELECT 
                parent 
            FROM 
                sc_single_car 
            WHERE 
                single_car_id = '" . (int) $single_car_id . "'";
        
        return $wpdb->get_var($sql);
        
    }
    
}

