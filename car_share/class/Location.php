<?php

class Location {
    
    protected $id;
    
    public function __construct($id = null){
        $this->id = $id;
    }
    
    public function get_opening_hours(){
        global $wpdb;
        
        $sql = "
            SELECT
                *,
                MINUTE(open_from) as from_min,
                MINUTE(open_to) as to_min,
                HOUR(open_from) as from_hour,
                HOUR(open_to) as to_hour
            FROM
                opening_hours 
            WHERE
                location_id = '" . (int) $this->id . "' 
            ORDER BY FIELD(dayname, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')        
        ";
        
        return $wpdb->get_results($sql);
    }
    
    public function get_opening_hours_with_day_key(){
        $opening_hours = $this->get_opening_hours();
        
        $return = array();        
        
        foreach((array) $opening_hours as $val){
            $return[$val->dayname] = $val;
        }
        
        return $return;
    }
    
    
}

