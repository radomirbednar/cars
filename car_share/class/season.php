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

}
