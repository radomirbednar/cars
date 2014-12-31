<?php

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

