<?php

class sc_Car {

    
    
    public function __construct($id) {
        
    }
    
    public function priceFromTo(DateTime $from, DateTime $to){
        
    }
    
    public function isAvailableFromTo(DateTime $from, DateTime $to){
        
    }
    
    public static function transmission($id){
        $options = sc_Car::getTransmissionOptions();
        return isset($options[$id]) ? $options[$id] : '';
    }
    
    public static function airCondition($id){
        $options = sc_Car::getAirOptions();
        return isset($options[$id]) ? $options[$id] : '';
    }
    
    public static function fuel($id){
        $options = sc_Car::getFuelOptions();
        return isset($options[$id]) ? $options[$id] : '';
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
          1 => __('Petrol', 'car_share'),
          2 => __('Mixed', 'car_share'),
          3 => __('Diesel', 'car_share'),   
        );  
        return $arr; 
    }
    
    public static function getAirOptions(){ 
        $arr = array( 
          1 => __('yes', 'car_share'),
          2 => __('no', 'car_share'),  
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

       $r = $wpdb->query($sql);        
       return $r;
        
    }
    
    
    public static function updateStatus($single_car_id, DateTime $from, $to, $status, $booking_id){ 
        
        global $wpdb;
        
        $sql = "
        UPDATE 
        sc_single_car_status SET single_car_id = " . (int) $single_car_id . ", date_from = '" . (empty($from) ? "" : $from->format('Y-m-d H:i:s')) . "', date_to = '" . (empty($to) ? "" : $to->format('Y-m-d H:i:s')) . "', status = " . (int) $status . ", booking_id= " . (int) $booking_id . " WHERE booking_id = " .(int) $booking_id. ";"; 
 
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

