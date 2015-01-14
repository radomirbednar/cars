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
    
}

