<?php

class sc_Booking {

    protected $id;
    protected $data = null;
    //protected $from = null;
    //protected $to = null;

    public function __construct($post = null) {
        if ($post instanceof WP_Post) {
            $this->id = $post->ID;
            $this->post = $post;
        } else {
            $this->id = $post;
            $this->post = get_post($post);
        }
        
        if(!empty($this->id)){
            $this->load();
        }
    }

    public function load() {
        global $wpdb;
        $sql = "SELECT * FROM sc_single_car_status WHERE booking_id = '" . $this->id . "'";
        $this->data = $wpdb->get_row($sql);
    }

    public function from() {        
        if(!empty($this->data['date_from'])){
            return DateTime::createFromFormat('d.m.Y H:i', $this->data['date_from']);
        }
        return false;
    }

    public function to() {        
        if($this->data['date_to']){
            return DateTime::createFromFormat('d.m.Y H:i', $this->data['date_to']);
        }
        return false;
    }

}
