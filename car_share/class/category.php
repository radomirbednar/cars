<?php

class sc_Category {

    protected $id;
    protected $post;

    public function __construct($post = null) {
        if($post instanceof WP_Post){
            $this->id = $post->ID;
            $this->post = $post;
        } else {
            $this->id = $post;
            $this->post = get_post($post);            
        }        
    }

    public function day_prices() {
        global $wpdb;
        $sql = "SELECT * FROM day_prices WHERE car_category_id = '" . (int) $this->id . "'";
        return $wpdb->get_results($sql);
    }

    public function day_prices_indexed_with_dayname() {

        $return = array();
        $day_prices = $this->day_prices();

        foreach ($day_prices as $day_price) {
            $return[$day_price->dayname] = $day_price;
        }

        return $return;
    }
    
    
    public function season_to_category_prices(){
        
        global $wpdb;
        $return = array();
        
        $sql = "SELECT * FROM day_prices WHERE car_category_id = '" . (int) $this->id . "' AND season_id != 0";
        $results = $wpdb->get_results($sql);        
        
        foreach($results as $r){
            
            if(!array_key_exists($r->season_id, $return)){
                $return[$r->season_id]['days'] = array(); 
                $return[$r->season_id]['car_category_id'] = $r->car_category_id; 
            } 
            
            $return[$r->season_id]['days'][$r->dayname] = $r->price;             
        }        
        return $return;        
    }
}