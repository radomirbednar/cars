<?php


function sc_get_countries(){    
          
          $arr = array (
            "AF" => __('Afghanistan', 'car_share'),
            "AL" => __('Albania', 'car_share'),
            "DZ" => __('Algeria', 'car_share'),
            "AS" => __('American Samoa', 'car_share'),
            "AD" => __('Andorra', 'car_share'),
            "AO" => __('Angola', 'car_share'),
            "AI" => __('Anguilla', 'car_share'),
            "AQ" => __('Antarctica', 'car_share'),
            "AG" => __('Antigua and Barbuda', 'car_share'),
            "AR" => __('Argentina', 'car_share'),
            "AM" => __('Armenia', 'car_share'),
            "AW" => __('Aruba', 'car_share'),
            "AU" => __('Australia', 'car_share'),
            "AT" => __('Austria', 'car_share'),
            "AZ" => __('Azerbaijan', 'car_share'),
            "BS" => __('Bahamas', 'car_share'),
            "BH" => __('Bahrain', 'car_share'),
            "BD" => __('Bangladesh', 'car_share'),
            "BB" => __('Barbados', 'car_share'),
            "BY" => __('Belarus', 'car_share'),
            "BE" => __('Belgium', 'car_share'),
            "BZ" => __('Belize', 'car_share'),
            "BJ" => __('Benin', 'car_share'),
            "BM" => __('Bermuda', 'car_share'),
            "BT" => __('Bhutan', 'car_share'),
            "BO" => __('Bolivia', 'car_share'),
            "BA" => __('Bosnia and Herzegowina', 'car_share'),
            "BW" => __('Botswana', 'car_share'),
            "BV" => __('Bouvet Island', 'car_share'),
            "BR" => __('Brazil', 'car_share'),
            "IO" => __('British Indian Ocean Territory', 'car_share'),
            "BN" => __('Brunei Darussalam', 'car_share'),
            "BG" => __('Bulgaria', 'car_share'),
            "BF" => __('Burkina Faso', 'car_share'),
            "BI" => __('Burundi', 'car_share'),
            "KH" => __('Cambodia', 'car_share'),
            "CM" => __('Cameroon', 'car_share'),
            "CA" => __('Canada', 'car_share'),
            "CV" => __('Cape Verde', 'car_share'),
            "KY" => __('Cayman Islands', 'car_share'),
            "CF" => __('Central African Republic', 'car_share'),
            "TD" => __('Chad', 'car_share'),
            "CL" => __('Chile', 'car_share'),
            "CN" => __('China', 'car_share'),
            "CX" => __('Christmas Island', 'car_share'),
            "CC" => __('Cocos (Keeling) Islands', 'car_share'),
            "CO" => __('Colombia', 'car_share'),
            "KM" => __('Comoros', 'car_share'),
            "CG" => __('Congo', 'car_share'),
            "CD" => __('Congo, the Democratic Republic of the', 'car_share'),
            "CK" => __('Cook Islands', 'car_share'),
            "CR" => __('Costa Rica', 'car_share'),
            "CI" => __("Cote d'Ivoire", 'car_share'),
            "HR" => __('Croatia (Hrvatska)', 'car_share'),
            "CU" => __('Cuba', 'car_share'),
            "CY" => __('Cyprus', 'car_share'),
            "CZ" => __('Czech Republic', 'car_share'),
            "DK" => __('Denmark', 'car_share'),
            "DJ" => __('Djibouti', 'car_share'),
            "DM" => __('Dominica', 'car_share'),
            "DO" => __('Dominican Republic', 'car_share'),
            "TP" => __('East Timor', 'car_share'),
            "EC" => __('Ecuador', 'car_share'),
            "EG" => __('Egypt', 'car_share'),
            "SV" => __('El Salvador', 'car_share'),
            "GQ" => __('Equatorial Guinea', 'car_share'),
            "ER" => __('Eritrea', 'car_share'),
            "EE" => __('Estonia', 'car_share'),
            "ET" => __('Ethiopia', 'car_share'),
            "FK" => __('Falkland Islands (Malvinas)', 'car_share'),
            "FO" => __('Faroe Islands', 'car_share'),
            "FJ" => __('Fiji', 'car_share'),
            "FI" => __('Finland', 'car_share'),
            "FR" => __('France', 'car_share'),
            "FX" => __('France, Metropolitan', 'car_share'),
            "GF" => __('French Guiana', 'car_share'),
            "PF" => __('French Polynesia', 'car_share'),
            "TF" => __('French Southern Territories', 'car_share'),
            "GA" => __('Gabon', 'car_share'),
            "GM" => __('Gambia', 'car_share'),
            "GE" => __('Georgia', 'car_share'),
            "DE" => __('Germany', 'car_share'),
            "GH" => __('Ghana', 'car_share'),
            "GI" => __('Gibraltar', 'car_share'),
            "GR" => __('Greece', 'car_share'),
            "GL" => __('Greenland', 'car_share'),
            "GD" => __('Grenada', 'car_share'),
            "GP" => __('Guadeloupe', 'car_share'),
            "GU" => __('Guam', 'car_share'),
            "GT" => __('Guatemala', 'car_share'),
            "GN" => __('Guinea', 'car_share'),
            "GW" => __('Guinea-Bissau', 'car_share'),
            "GY" => __('Guyana', 'car_share'),
            "HT" => __('Haiti', 'car_share'),
            "HM" => __('Heard and Mc Donald Islands', 'car_share'),
            "VA" => __('Holy See (Vatican City State)', 'car_share'),
            "HN" => __('Honduras', 'car_share'),
            "HK" => __('Hong Kong', 'car_share'),
            "HU" => __('Hungary', 'car_share'),
            "IS" => __('Iceland', 'car_share'),
            "IN" => __('India', 'car_share'),
            "ID" => __('Indonesia', 'car_share'),
            "IR" => __('Iran (Islamic Republic of)', 'car_share'),
            "IQ" => __('Iraq', 'car_share'),
            "IE" => __('Ireland', 'car_share'),
            "IL" => __('Israel', 'car_share'),
            "IT" => __('Italy', 'car_share'),
            "JM" => __('Jamaica', 'car_share'),
            "JP" => __('Japan', 'car_share'),
            "JO" => __('Jordan', 'car_share'),
            "KZ" => __('Kazakhstan', 'car_share'),
            "KE" => __('Kenya', 'car_share'),
            "KI" => __('Kiribati', 'car_share'),
            "KP" => __("Korea, Democratic People's Republic of", 'car_share'),
            "KR" => __('Korea, Republic of', 'car_share'),
            "KW" => __('Kuwait', 'car_share'),
            "KG" => __('Kyrgyzstan', 'car_share'),
            "LA" => __("Lao People's Democratic Republic", 'car_share'),
            "LV" => __('Latvia', 'car_share'),
            "LB" => __('Lebanon', 'car_share'),
            "LS" => __('Lesotho', 'car_share'),
            "LR" => __('Liberia', 'car_share'),
            "LY" => __('Libyan Arab Jamahiriya', 'car_share'),
            "LI" => __('Liechtenstein', 'car_share'),
            "LT" => __('Lithuania', 'car_share'),
            "LU" => __('Luxembourg', 'car_share'),
            "MO" => __('Macau', 'car_share'),
            "MK" => __('Macedonia, The Former Yugoslav Republic of', 'car_share'),
            "MG" => __('Madagascar', 'car_share'),
            "MW" => __('Malawi', 'car_share'),
            "MY" => __('Malaysia', 'car_share'),
            "MV" => __('Maldives', 'car_share'),
            "ML" => __('Mali', 'car_share'),
            "MT" => __('Malta', 'car_share'),
            "MH" => __('Marshall Islands', 'car_share'),
            "MQ" => __('Martinique', 'car_share'),
            "MR" => __('Mauritania', 'car_share'),
            "MU" => __('Mauritius', 'car_share'),
            "YT" => __('Mayotte', 'car_share'),
            "MX" => __('Mexico', 'car_share'),
            "FM" => __('Micronesia, Federated States of', 'car_share'),
            "MD" => __('Moldova, Republic of', 'car_share'),
            "MC" => __('Monaco', 'car_share'),
            "MN" => __('Mongolia', 'car_share'),
            "MS" => __('Montserrat', 'car_share'),
            "MA" => __('Morocco', 'car_share'),
            "MZ" => __('Mozambique', 'car_share'),
            "MM" => __('Myanmar', 'car_share'),
            "NA" => __('Namibia', 'car_share'),
            "NR" => __('Nauru', 'car_share'),
            "NP" => __('Nepal', 'car_share'),
            "NL" => __('Netherlands', 'car_share'),
            "AN" => __('Netherlands Antilles', 'car_share'),
            "NC" => __('New Caledonia', 'car_share'),
            "NZ" => __('New Zealand', 'car_share'),
            "NI" => __('Nicaragua', 'car_share'),
            "NE" => __('Niger', 'car_share'),
            "NG" => __('Nigeria', 'car_share'),
            "NU" => __('Niue', 'car_share'),
            "NF" => __('Norfolk Island', 'car_share'),
            "MP" => __('Northern Mariana Islands', 'car_share'),
            "NO" => __('Norway', 'car_share'),
            "OM" => __('Oman', 'car_share'),
            "PK" => __('Pakistan', 'car_share'),
            "PW" => __('Palau', 'car_share'),
            "PA" => __('Panama', 'car_share'),
            "PG" => __('Papua New Guinea', 'car_share'),
            "PY" => __('Paraguay', 'car_share'),
            "PE" => __('Peru', 'car_share'),
            "PH" => __('Philippines', 'car_share'),
            "PN" => __('Pitcairn', 'car_share'),
            "PL" => __('Poland', 'car_share'),
            "PT" => __('Portugal', 'car_share'),
            "PR" => __('Puerto Rico', 'car_share'),
            "QA" => __('Qatar', 'car_share'),
            "RE" => __('Reunion', 'car_share'),
            "RO" => __('Romania', 'car_share'),
            "RU" => __('Russian Federation', 'car_share'),
            "RW" => __('Rwanda', 'car_share'),
            "KN" => __('Saint Kitts and Nevis', 'car_share'),
            "LC" => __('Saint LUCIA', 'car_share'),
            "VC" => __('Saint Vincent and the Grenadines', 'car_share'),
            "WS" => __('Samoa', 'car_share'),
            "SM" => __('San Marino', 'car_share'),
            "ST" => __('Sao Tome and Principe', 'car_share'),
            "SA" => __('Saudi Arabia', 'car_share'),
            "SN" => __('Senegal', 'car_share'),
            "SC" => __('Seychelles', 'car_share'),
            "SL" => __('Sierra Leone', 'car_share'),
            "SG" => __('Singapore', 'car_share'),
            "SK" => __('Slovakia (Slovak Republic)', 'car_share'),
            "SI" => __('Slovenia', 'car_share'),
            "SB" => __('Solomon Islands', 'car_share'),
            "SO" => __('Somalia', 'car_share'),
            "ZA" => __('South Africa', 'car_share'),
            "GS" => __('South Georgia and the South Sandwich Islands', 'car_share'),
            "ES" => __('Spain', 'car_share'),
            "LK" => __('Sri Lanka', 'car_share'),
            "SH" => __('St. Helena', 'car_share'),
            "PM" => __('St. Pierre and Miquelon', 'car_share'),
            "SD" => __('Sudan', 'car_share'),
            "SR" => __('Suriname', 'car_share'),
            "SJ" => __('Svalbard and Jan Mayen Islands', 'car_share'),
            "SZ" => __('Swaziland', 'car_share'),
            "SE" => __('Sweden', 'car_share'),
            "CH" => __('Switzerland', 'car_share'),
            "SY" => __('Syrian Arab Republic', 'car_share'),
            "TW" => __('Taiwan, Province of China', 'car_share'),
            "TJ" => __('Tajikistan', 'car_share'),
            "TZ" => __('Tanzania, United Republic of', 'car_share'),
            "TH" => __('Thailand', 'car_share'),
            "TG" => __('Togo', 'car_share'),
            "TK" => __('Tokelau', 'car_share'),
            "TO" => __('Tonga', 'car_share'),
            "TT" => __('Trinidad and Tobago', 'car_share'),
            "TN" => __('Tunisia', 'car_share'),
            "TR" => __('Turkey', 'car_share'),
            "TM" => __('Turkmenistan', 'car_share'),
            "TC" => __('Turks and Caicos Islands', 'car_share'),
            "TV" => __('Tuvalu', 'car_share'),
            "UG" => __('Uganda', 'car_share'),
            "UA" => __('Ukraine', 'car_share'),
            "AE" => __('United Arab Emirates', 'car_share'),
            "GB" => __('United Kingdom', 'car_share'),
            "US" => __('United States', 'car_share'),
            "UM" => __('United States Minor Outlying Islands', 'car_share'),
            "UY" => __('Uruguay', 'car_share'),
            "UZ" => __('Uzbekistan', 'car_share'),
            "VU" => __('Vanuatu', 'car_share'),
            "VE" => __('Venezuela', 'car_share'),
            "VN" => __('Viet Nam', 'car_share'),
            "VG" => __('Virgin Islands (British)', 'car_share'),
            "VI" => __('Virgin Islands (U.S.)', 'car_share'),
            "WF" => __('Wallis and Futuna Islands', 'car_share'),
            "EH" => __('Western Sahara', 'car_share'),
            "YE" => __('Yemen', 'car_share'),
            "YU" => __('Yugoslavia', 'car_share'),
            "ZM" => __('Zambia', 'car_share'),
            "ZW" => __('Zimbabwe', 'car_share')
    );
          
          return $arr;
}

function get_booking_fields(){

    $arr = array(
        'cart_pick_up' => array(            
            'label' => __('Pick up location', 'car_share'),
            'type' => 'title',
        ),
        'cart_drop_off' => array(
            'label' => __('Drop off location', 'car_share'),
            'type' => 'title',    
        ),
        'cart_car_category' => array(
            'label' => __('Car category', 'car_share'),
            'type' => 'title'
        ),
        'cart_car_name' => array(
            'label' => __('Car name', 'car_share'),
            'type' => 'text'
        ),
        'cart_car_ID' => array(
            'label' => __('Car ID', 'car_share'),
            'type' => 'text'
        ),
        'cart_car_price' => array(
            'label' => __('Car Price', 'car_share'),
            'type' => 'price',
        ),
        'cart_extra_price' => array(
            'label' => __('Extra Price', 'car_share'),
            'type' => 'price',
        ),        
        '_checkout_location_price' => array(
            'label' => __('Different location price', 'car_share'),
            'type' => 'price'
        ),
        '_young_surcharge_fee' => array(
            'label' => __('Young driver surcharge fee', 'car_share'),
            'type' => 'price',
        ),

        //'separator' => '<div>',

        '_voucher_id' => array(
            'label' => __('Voucher ID', 'car_share'),
            'type' => 'text'
        ),
        
        '_voucher_name' => array(
            'label' => __('Voucher name', 'car_share'),
            'type' => 'text'
        ),
        '_voucher_code' => array(
            'label' => __('Voucher code', 'car_share'),
            'type' => 'text'
        ),
        '_voucher_discount_percentage' => array(
            'label' => __('Voucher discount percentage', 'car_share'),
            'type' => 'percentage'
        ),
        '_voucher_discount_amount'  => array(
            'label' => __('Voucher discount amount', 'car_share'),
            'type' => 'price'
        ),

        //'separator' => '',

        'cart_total_price' => array (
            'label' => __('Total Price', 'car_share'),
            'type' => 'price'
        ),
        '_checkout_payable_price' => array(
            'label' => __('Payable price', 'car_share'),
            'type' => 'price'
        ),
        'cart_order_status' => array(
            'label' => __('Order status', 'car_share'),
            'type' => 'text'    
        ),
    ); 
    return $arr; 
}


function get_payment_fields(){ 
    
    $arr = array(  
        'car_r_order_status' => array (
            'label' => __('Order status', 'car_share'), 
            'type' => 'status'
        ),
        'car_r_order_info' => array(
            'label' => __('Order info from paypal', 'car_share'),
            'type' => 'text'
        ),
        'payerid' => array(
            'label' => __('Payer ID', 'car_share'),
            'type' => 'text'    
        ),
        'responseamt' => array(
            'label' => __('Amt from Paypal', 'car_share'),
            'type' => 'price'    
        ),
         'paypal_c_email' => array(
            'label' => __('Paypal Email', 'car_share'),
            'type' => 'text'    
        ),  
    ); 
    
    return $arr; 
}


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
            'label' => __('Fullname', 'car_share'),
            'placeholder' => __('Fullname', 'car_share'),
            'enabled' => 1,
            'required' => 1,
            'type' => 'text'
        ),
        '_email' => array(
            'label' => __('Email address', 'car_share'),
            'placeholder' => __('Email address', 'car_share'),
            'enabled' => 1,
            'required' => 1,
            'type' => 'email'
        ),
        '_phone' => array(
            'label' => __('Phone', 'car_share'),
            'placeholder' => __('Phone', 'car_share'),
            'enabled' => 1,
            'required' => 1,
            'type' => 'text'
        ),
        '_address_1' => array(
            'label' => __('Address 1', 'car_share'),
            'placeholder' => __('Address 1', 'car_share'),
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
        ),
        '_address_2' => array(
            'label' => __('Address 2', 'car_share'),
            'placeholder' => __('Address 2', 'car_share'),
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
        ),
        '_city' => array(
            'label' => __('City', 'car_share'),
            'placeholder' => __('City', 'car_share'),
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
        ),
        '_country' => array(
            'label' => __('Country', 'car_share'),
            'placeholder' => __('Country', 'car_share'),
            'enabled' => 1,
            'required' => 0,
            'type' => 'country'
        ),
        '_zip' => array(
            'label' => __('Zip', 'car_share'),
            'placeholder' => __('Zip', 'car_share'),
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
        ),
        '_flight_number' => array(
            'label' => __('Flight number', 'car_share'),
            'placeholder' => __('Flight number', 'car_share'),
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
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
    return DateTime::createFromFormat('Y-m-d H:i:s', $date_string);
}

function update_date_meta($post_id, $meta_key, DateTime $date) {

    global $wpdb;
    $sql = "
        REPLACE INTO postmeta_date (post_id, meta_key, meta_value) VALUES (
            '" . (int) $post_id . "',
            '" . esc_sql($meta_key) . "',
            '" . $date->format('Y-m-d H:i:s') . "'
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

function return_currencies(){

$currencies = array(
		'AUD' => array( 'name' => 'Australian Dollar', 'symbol' => '$' ),
		'BRL' => array( 'name' => 'Brazilian Real', 'symbol' => 'R$' ),
		'CAD' => array( 'name' => 'Canadian Dollar', 'symbol' => '$' ),
		'CZK' => array( 'name' => 'Czech Koruna', 'symbol' => 'Kc' ),
		'DKK' => array( 'name' => 'Danish Krone', 'symbol' => 'kr' ),
		'EUR' => array( 'name' => 'Euro', 'symbol' => '&euro;' ),
		'HKD' => array( 'name' => 'Hong Kong Dollar', 'symbol' => '$' ),
		'HUF' => array( 'name' => 'Hungarian Forint', 'symbol' => 'Ft' ),
		'ILS' => array( 'name' => 'Israeli New Sheqel', 'symbol' => '&#8362;' ),
		'JPY' => array( 'name' => 'Japanese Yen', 'symbol' => '&yen;' ),
		'MYR' => array( 'name' => 'Malaysian Ringgit', 'symbol' => 'RM' ),
		'MXN' => array( 'name' => 'Mexican Peso', 'symbol' => '$' ),
		'NOK' => array( 'name' => 'Norwegian Krone', 'symbol' => 'kr' ),
		'NZD' => array( 'name' => 'New Zealand Dollar', 'symbol' => '$' ),
		'PHP' => array( 'name' => 'Philippine Peso', 'symbol' => '&#8369;' ),
		'PLN' => array( 'name' => 'Polish Zloty', 'symbol' => '&#122;&#322;' ),
		'GBP' => array( 'name' => 'Pound Sterling', 'symbol' => '&pound;' ),
		'RUB' => array( 'name' => 'Russian Ruble', 'symbol' => '&#8381;' ),
		'SGD' => array( 'name' => 'Singapore Dollar', 'symbol' => '$' ),
		'SEK' => array( 'name' => 'Swedish Krona', 'symbol' => 'kr' ),
		'CHF' => array( 'name' => 'Swiss Franc', 'symbol' => 'CHF' ),
		'TWD' => array( 'name' => 'Taiwan New Dollar', 'symbol' => '$' ),
		'THB' => array( 'name' => 'Thai Baht', 'symbol' => '&#3647;' ),
		'TRY' => array( 'name' => 'Turkish Lira', 'symbol' => '&#8378;' ),
		'USD' => array( 'name' => 'U.S. Dollar', 'symbol' => '$' )
                );
return $currencies;
} 
