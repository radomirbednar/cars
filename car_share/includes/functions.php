<?php

function sc_get_price($car_id, DateTime $from, DateTime $to, $args) {

    global $wpdb;

    $day_interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($from, $day_interval, $to);
    $diff = $to->diff($from);
    $days = $diff->d;

    $category_id = (int) get_post_meta($car_id, '_car_category', true);

    /**
     *
     */
    if (empty($category_id)) {
        // auto nema kategorii, nemam ceny
    }

    $car_category = new sc_Category($category_id);
    $category_prices = $car_category->day_prices_indexed_with_dayname();

    // find all assigned season
    $sql = "SELECT
                ID,
                start.meta_value as date_from,
                end.meta_value as date_to
            FROM
                $wpdb->posts s
            JOIN
                postmeta_date start ON s.ID = start.post_id AND start.meta_key = '_from'
            JOIN
                postmeta_date end ON s.ID = end.post_id AND end.meta_key = '_to'
            JOIN
                day_prices dp ON dp.season_id = s.ID AND car_category_id = '" . (int) $category_id . "'
            WHERE
                s.post_status = 'publish' AND s.post_type='sc-season'
            AND
            (
                (start.meta_value BETWEEN '" . $from->format('Y-m-d  H:i:s') . "' AND '" . $to->format('Y-m-d  H:i:s') . "')
                    OR
                ('" . $from->format('Y-m-d  H:i:s') . "' BETWEEN start.meta_value AND end.meta_value)
            )
            GROUP BY s.ID
            ";

    $seasons = $wpdb->get_results($sql);

    $applied_sessions = array();
    foreach ((array) $seasons as $session) {
        $begin = DateTime::createFromFormat('Y-m-d H:i:s', $session->date_from . ' 00:00:00');
        $end = DateTime::createFromFormat('Y-m-d H:i:s', $session->date_to . ' 23:59:59');        

        $season_prices = $car_category->day_prices_indexed_with_dayname($session->ID);

        $applied_sessions[] = array(
            'start' => $begin,
            'end' => $end,
            'prices' => $season_prices
        );
    }

    $total_price = 0;

    foreach ($period as $day) {

        // find out if day belongs to some season
        $day_name = $day->format("l");

        $day_price = 0;
        $mam = false;

        foreach ($applied_sessions as $applied_season) {
            if (($applied_season['start'] < $day) && ($day < $applied_season['end'])) {
                $mam = true;
                $day_price = isset($applied_season['prices'][$day_name]) ? $applied_season['prices'][$day_name] : 0;
            }
        }

        if ($mam == false) {
            if (isset($category_prices[$day_name])) {
                $day_price = isset($category_prices[$day_name]) ? $category_prices[$day_name] : 0;
            }
        }

        $total_price += floatval($day_price);
    }

    // apply time discount
    $time_discount = get_post_meta($category_id, '_discount_upon_duration', true);

    $discount = 0;
    if (!empty($time_discount)) {
        ksort($time_discount);
        foreach ($time_discount as $key => $val) {
            if ($key < $days) {
                $discount = $val;
            } else {
                break;
            }
        }
    }

    //
    if ($discount > 0) {
        $total_price = $total_price - $total_price * $discount / 100;
    }

    //
    return $total_price;
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
