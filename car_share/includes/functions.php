<?php

function get_enabled_checkout_fields(){
    $checkout_fields = get_checkout_fields();
    
    $checkout_fields = array_filter($checkout_fields, function($field) {
                            return $field['enabled'] == 1;
                        }); 
    
    return $checkout_fields;
}

function get_checkout_fields(){
    
    $default_checkout_fields = get_default_checkout_fields();
    $checkout_fields_settings = get_option('sc-checkout-inputs');
        
    if(empty($checkout_fields_settings)){
        $checkout_fields_settings = array();
    }
        
    $checkout_fields = array_replace_recursive($default_checkout_fields, $checkout_fields_settings);      
    return $checkout_fields;
}

function get_default_checkout_fields(){
    
    $checkout_fields = array(
        '_name' => array(
            'label' => 'Fullname',
            'placeholder' => 'full name',
            'enabled' => 1,
            'required' => 1
        ),
        '_email' => array(
            'label' => 'Email address',
            'placeholder' => 'Email address',
            'enabled' => 1,
            'required' => 1
        ),
        '_phone' => array(
            'label' => 'Phone',
            'placeholder' => 'Telephone number',
            'enabled' => 1,
            'required' => 1
        ),
        '_address_1' => array(
            'label' => 'Address 1',
            'placeholder' => 'address line 1',
            'enabled' => 1,
            'required' => 0
        ),
        '_address_2' => array(
            'label' => 'Address 2',
            'placeholder' => 'address line 2',
            'enabled' => 1,
            'required' => 0
        ),
        '_city' => array(
            'label' => 'City',
            'placeholder' => 'city',
            'enabled' => 1,
            'required' => 0
        ),
        '_country' => array(
            'label' => 'Country',
            'placeholder' => 'state / province / region',
            'enabled' => 1,
            'required' => 0
        ),
        '_zip' => array(
            'label' => 'Zip',
            'placeholder' => 'zip code',
            'enabled' => 1,
            'required' => 0
        ),
        '_flight_number' => array(
            'label' => 'Flight number',
            'placeholder' => 'Flight number',
            'enabled' => 1,
            'required' => 0
        )
 
    );    
    
    return $checkout_fields;
}

function get_days_of_week() {

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

function get_car_statuses() {
    $arr = array(
        0 => 'Inaccessible',
        1 => 'Reserved'
    );
}

function get_term_meta($term_id, $meta_key) {
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
function update_term_meta($term_id, $meta_key, $meta_value) {
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
function delete_term_meta($term_id, $meta_key) {
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
function deleta_all_term_metas($term_id) {
    global $wpdb;
    $sql = "DELETE FROM term_meta WHERE term_id = '" . (int) $term_id . "'";
    return $wpdb->query($sql);
}

function get_date_meta($post_id, $meta_key) {

    global $wpdb;
    $sql = "SELECT meta_value FROM postmeta_date WHERE post_id = '" . (int) $post_id . "' AND meta_key = '" . esc_sql($meta_key) . "'";
    $date_string = $wpdb->get_var($sql);
    return DateTime::createFromFormat('Y-m-d', $date_string);
}

function update_date_meta($post_id, $meta_key, DateTime $date) {
    
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

function delete_date_meta($post_id, $meta_key) {
    global $wpdb;
    $sql = "DELETE FROM postmeta_date WHERE post_id = '" . (int) $post_id . "' AND meta_key='" . esc_sql($meta_key) . "'";
    return $wpdb->query($sql);
}

function delete_all_date_metas($post_id) {
    global $wpdb;
    $sql = "DELETE FROM postmeta_date WHERE post_id = '" . (int) $post_id . "'";
    return $wpdb->query($sql);
}
