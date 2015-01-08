<?php



function sc_get_price($car_id, DateTime $from, DateTime $to, $args){
    
    global $wpdb;
    
    //$booking_interval = $to->diff($from);
    
    $day_interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($from, $day_interval, $to);
    
    
    
    $category_id = (int) get_post_meta($car_id, '_car_category', true);
    
    if(empty($category_id)){
        // auto nema kategorii, nemam ceny        
    }
    
    // category prices
    $sql = "SELECT * FROM `day_prices` WHERE car_category_id = '" . $category_id . "' AND season_id = 0";
    $prices_from_category = $wpdb->get_results($sql);
    
    // find all assigned season
    $sql = "SELECT ID FROM $wpdb->posts p
            JOIN postmeta_date start ON p.ID = start.post_id AND meta_key = '_from'
            JOIN postmeta_date end ON p.ID = end.post_id AND meta_key = '_to'
            WHERE post_status = 'publish' AND post_type='sc-season' ";
       
    foreach($period as $day){
        echo $day->format( "l" );
        
    }
    
}


function get_days_of_week(){
    
    $days = array(
        'Monday' => 'Mon',
        'Tuesday' => 'Tues',
        'Wednesday' => 'Wed',
        'Thursday' => 'Thurs',
        'Friday' => 'Fri',
        'Saturday' => 'Sat',
        'Sunday' => 'Sun',
    );    
    
    return $days;    
}

function get_car_statuses(){
    $arr = array(
        0 => 'Inaccessible',
        1 => 'Reserved'
    );
}

function get_term_meta($term_id, $meta_key){
    global $wpdb;
    
    $sql = "
        SELECT
            meta_value
        FROM    
            term_meta
        WHERE 
            term_id = '" . (int) $term_id . "'
        AND
            meta_key = '" . esc_sql($meta_key) . "'                
        ";
    
    return $wpdb->get_var($sql);
}

/**
 * 
 * @global type $wpdb
 * @param type $term_id
 * @param type $meta_key
 * @param type $meta_value
 * @return type
 */
function update_term_meta($term_id, $meta_key, $meta_value){
    global $wpdb;
    
    $sql = "
        REPLACE INTO 
            term_meta (term_id, meta_key, meta_value)
        VALUES (
            '" . (int) $term_id . "',
            '" . esc_sql($meta_key) . "',
            '" . esc_sql($meta_value) . "'    
        )    
    ";
    
    return $wpdb->query($sql);
}

/**
 * 
 * @global type $wpdb
 * @param type $term_id
 * @param type $meta_key
 * @return type
 */
function delete_term_meta($term_id, $meta_key){
    global $wpdb;
    $sql = "DELETE FROM term_meta WHERE term_id = '" . (int) $term_id . "' AND meta_key = '" . esc_sql($meta_key) . "'";
    return $wpdb->query($sql);
}

/**
 * 
 * @global type $wpdb
 * @param type $term_id
 * @return type
 */
function deleta_all_term_metas($term_id){
    global $wpdb;
    $sql = "DELETE FROM term_meta WHERE term_id = '" . (int) $term_id . "'";
    return $wpdb->query($sql);
}


function get_date_meta($post_id, $meta_key){
    
    global $wpdb;
    $sql = "SELECT meta_value FROM postmeta_date WHERE post_id = '" . (int) $post_id . "' AND meta_key = '" . esc_sql($meta_key) . "'";
    $date_string = $wpdb->get_var($sql);
    return DateTime::createFromFormat('Y-m-d', $date_string);
}

function update_date_meta($post_id, $meta_key, DateTime $date){
    //$from->format('Y-m-d H:i:s')
    global $wpdb;
    $sql = "
        REPLACE INTO postmeta_date (post_id, meta_key, meta_value) VALUES (
            '" . (int) $post_id . "',
            '" . esc_sql($meta_key) . "',
            '" . $date->format('Y-m-d') . "'    
        )
    ";
    
    return $wpdb->query($sql);
}

function delete_date_meta($post_id, $meta_key){
    global $wpdb;
    $sql = "DELETE FROM postmeta_date WHERE post_id = '" . (int) $post_id . "' AND meta_key='" . esc_sql($meta_key) . "'";
    return $wpdb->query($sql);
}

function delete_all_date_metas($post_id){
    global $wpdb;
    $sql = "DELETE FROM postmeta_date WHERE post_id = '" . (int) $post_id . "'";
    return $wpdb->query($sql);    
}