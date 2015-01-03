<?php

class sc_Season {

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
        $sql = "SELECT * FROM day_prices WHERE post_id = '" . (int) $this->id . "'";
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

    public function from(){
        return get_date_meta($this->id, '_from');
    }

    public function to(){
        return get_date_meta($this->id, '_to');
    }

}
