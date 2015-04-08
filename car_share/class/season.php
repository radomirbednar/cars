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

    public function from(){
        return get_date_meta($this->id, '_from');
    }

    public function to(){
        return get_date_meta($this->id, '_to');
    }

    
    public static function get_dates($season_id){
        
        global $wpdb;
        
        $sql = "
            SELECT 
                *
            FROM
                sc_season_date
            WHERE            
                post_id = '" . $season_id . "'
        ";
        
        $dates = $wpdb->get_results($sql);
        return $dates;        
    }
    
}
