<?php


function sc_get_countries(){    
          
          $arr = array (
            "AF" => 'Afghanistan',
            "AL" => 'Albania',
            "DZ" => 'Algeria',
            "AS" => 'American Samoa',
            "AD" =>  'Andorra',
            "AO" => 'Angola',
            "AI" => 'Anguilla',
            "AQ" => 'Antarctica',
            "AG" => 'Antigua and Barbuda',
            "AR" => 'Argentina',
            "AM" => 'Armenia',
            "AW" => 'Aruba',
            "AU" => 'Australia',
            "AT" => 'Austria',
            "AZ" => 'Azerbaijan',
            "BS" => 'Bahamas',
            "BH" => 'Bahrain',
            "BD" => 'Bangladesh',
            "BB" => 'Barbados',
            "BY" => 'Belarus',
            "BE" => 'Belgium',
            "BZ" => 'Belize',
            "BJ" => 'Benin',
            "BM" => 'Bermuda',
            "BT" => 'Bhutan',
            "BO" => 'Bolivia',
            "BA" => 'Bosnia and Herzegowina',
            "BW" => 'Botswana',
            "BV" => 'Bouvet Island',
            "BR" => 'Brazil',
            "IO" => 'British Indian Ocean Territory',
            "BN" => 'Brunei Darussalam',
            "BG" => 'Bulgaria',
            "BF" => 'Burkina Faso',
            "BI" => 'Burundi',
            "KH" => 'Cambodia',
            "CM" => 'Cameroon',
            "CA" => 'Canada',
            "CV" => 'Cape Verde',
            "KY" => 'Cayman Islands',
            "CF" => 'Central African Republic',
            "TD" => 'Chad',
            "CL" => 'Chile',
            "CN" => 'China',
            "CX" => 'Christmas Island',
            "CC" => 'Cocos (Keeling) Islands',
            "CO" => 'Colombia',
            "KM" => 'Comoros',
            "CG" => 'Congo',
            "CD" => 'Congo, the Democratic Republic of the',
            "CK" => 'Cook Islands',
            "CR" => 'Costa Rica',
            "CI" => "Cote d'Ivoire",
            "HR" => 'Croatia (Hrvatska)',
            "CU" => 'Cuba',
            "CY" => 'Cyprus',
            "CZ" => 'Czech Republic',
            "DK" => 'Denmark',
            "DJ" => 'Djibouti',
            "DM" => 'Dominica',
            "DO" => 'Dominican Republic',
            "TP" => 'East Timor',
            "EC" => 'Ecuador',
            "EG" => 'Egypt',
            "SV" => 'El Salvador',
            "GQ" => 'Equatorial Guinea',
            "ER" => 'Eritrea',
            "EE" => 'Estonia',
            "ET" => 'Ethiopia',
            "FK" => 'Falkland Islands (Malvinas)',
            "FO" => 'Faroe Islands',
            "FJ" => 'Fiji',
            "FI" => 'Finland',
            "FR" => 'France',
            "FX" => 'France, Metropolitan',
            "GF" => 'French Guiana',
            "PF" => 'French Polynesia',
            "TF" => 'French Southern Territories',
            "GA" => 'Gabon',
            "GM" => 'Gambia',
            "GE" => 'Georgia',
            "DE" => 'Germany',
            "GH" => 'Ghana',
            "GI" => 'Gibraltar',
            "GR" => 'Greece',
            "GL" => 'Greenland',
            "GD" => 'Grenada',
            "GP" => 'Guadeloupe',
            "GU" => 'Guam',
            "GT" => 'Guatemala',
            "GN" => 'Guinea',
            "GW" => 'Guinea-Bissau',
            "GY" => 'Guyana',
            "HT" => 'Haiti',
            "HM" => 'Heard and Mc Donald Islands',
            "VA" => 'Holy See (Vatican City State)',
            "HN" => 'Honduras',
            "HK" => 'Hong Kong',
            "HU" => 'Hungary',
            "IS" => 'Iceland',
            "IN" => 'India',
            "ID" => 'Indonesia',
            "IR" => 'Iran (Islamic Republic of)',
            "IQ" => 'Iraq',
            "IE" => 'Ireland',
            "IL" => 'Israel',
            "IT" => 'Italy',
            "JM" => 'Jamaica',
            "JP" => 'Japan',
            "JO" => 'Jordan',
            "KZ" => 'Kazakhstan',
            "KE" => 'Kenya',
            "KI" => 'Kiribati',
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => 'Korea, Republic of',
            "KW" => 'Kuwait',
            "KG" => 'Kyrgyzstan',
            "LA" => "Lao People's Democratic Republic",
            "LV" => 'Latvia',
            "LB" => 'Lebanon',
            "LS" => 'Lesotho',
            "LR" => 'Liberia',
            "LY" => 'Libyan Arab Jamahiriya',
            "LI" => 'Liechtenstein',
            "LT" => 'Lithuania',
            "LU" => 'Luxembourg',
            "MO" => 'Macau',
            "MK" => 'Macedonia, The Former Yugoslav Republic of',
            "MG" => 'Madagascar',
            "MW" => 'Malawi',
            "MY" => 'Malaysia',
            "MV" => 'Maldives',
            "ML" => 'Mali',
            "MT" => 'Malta',
            "MH" => 'Marshall Islands',
            "MQ" => 'Martinique',
            "MR" => 'Mauritania',
            "MU" => 'Mauritius',
            "YT" => 'Mayotte',
            "MX" => 'Mexico',
            "FM" => 'Micronesia, Federated States of',
            "MD" => 'Moldova, Republic of',
            "MC" => 'Monaco',
            "MN" => 'Mongolia',
            "MS" => 'Montserrat',
            "MA" => 'Morocco',
            "MZ" => 'Mozambique',
            "MM" => 'Myanmar',
            "NA" => 'Namibia',
            "NR" => 'Nauru',
            "NP" => 'Nepal',
            "NL" => 'Netherlands',
            "AN" => 'Netherlands Antilles',
            "NC" => 'New Caledonia',
            "NZ" => 'New Zealand',
            "NI" => 'Nicaragua',
            "NE" => 'Niger',
            "NG" => 'Nigeria',
            "NU" => 'Niue',
            "NF" => 'Norfolk Island',
            "MP" => 'Northern Mariana Islands',
            "NO" => 'Norway',
            "OM" => 'Oman',
            "PK" => 'Pakistan',
            "PW" => 'Palau',
            "PA" => 'Panama',
            "PG" => 'Papua New Guinea',
            "PY" => 'Paraguay',
            "PE" => 'Peru',
            "PH" => 'Philippines',
            "PN" => 'Pitcairn',
            "PL" => 'Poland',
            "PT" => 'Portugal',
            "PR" => 'Puerto Rico',
            "QA" => 'Qatar',
            "RE" => 'Reunion',
            "RO" => 'Romania',
            "RU" => 'Russian Federation',
            "RW" => 'Rwanda',
            "KN" => 'Saint Kitts and Nevis',
            "LC" => 'Saint LUCIA',
            "VC" => 'Saint Vincent and the Grenadines',
            "WS" => 'Samoa',
            "SM" => 'San Marino',
            "ST" => 'Sao Tome and Principe',
            "SA" => 'Saudi Arabia',
            "SN" => 'Senegal',
            "SC" => 'Seychelles',
            "SL" => 'Sierra Leone',
            "SG" => 'Singapore',
            "SK" => 'Slovakia (Slovak Republic)',
            "SI" => 'Slovenia',
            "SB" => 'Solomon Islands',
            "SO" => 'Somalia',
            "ZA" => 'South Africa',
            "GS" => 'South Georgia and the South Sandwich Islands',
            "ES" => 'Spain',
            "LK" => 'Sri Lanka',
            "SH" => 'St. Helena',
            "PM" => 'St. Pierre and Miquelon',
            "SD" => 'Sudan',
            "SR" => 'Suriname',
            "SJ" => 'Svalbard and Jan Mayen Islands',
            "SZ" => 'Swaziland',
            "SE" => 'Sweden',
            "CH" => 'Switzerland',
            "SY" => 'Syrian Arab Republic',
            "TW" => 'Taiwan, Province of China',
            "TJ" => 'Tajikistan',
            "TZ" => 'Tanzania, United Republic of',
            "TH" => 'Thailand',
            "TG" => 'Togo',
            "TK" => 'Tokelau',
            "TO" => 'Tonga',
            "TT" => 'Trinidad and Tobago',
            "TN" => 'Tunisia',
            "TR" => 'Turkey',
            "TM" => 'Turkmenistan',
            "TC" => 'Turks and Caicos Islands',
            "TV" => 'Tuvalu',
            "UG" => 'Uganda',
            "UA" => 'Ukraine',
            "AE" => 'United Arab Emirates',
            "GB" => 'United Kingdom',
            "US" => 'United States',
            "UM" => 'United States Minor Outlying Islands',
            "UY" => 'Uruguay',
            "UZ" => 'Uzbekistan',
            "VU" => 'Vanuatu',
            "VE" => 'Venezuela',
            "VN" => 'Viet Nam',
            "VG" => 'Virgin Islands (British)',
            "VI" => 'Virgin Islands (U.S.)',
            "WF" => 'Wallis and Futuna Islands',
            "EH" => 'Western Sahara',
            "YE" => 'Yemen',
            "YU" => 'Yugoslavia',
            "ZM" => 'Zambia',
            "ZW" => 'Zimbabwe',    
    );
          
          return $arr;
}

function get_booking_fields(){

    $arr = array(
        'cart_pick_up' => array(            
            'label' => 'Pick up location',
            'type' => 'title',
        ),
        'cart_drop_off' => array(
            'label' => 'Drop off location',
            'type' => 'title',    
        ),
        'cart_car_category' => array(
            'label' => 'Car category',
            'type' => 'title'
        ),
        'cart_car_name' => array(
            'label' => 'Car name',
            'type' => 'text'
        ),
        'cart_car_ID' => array(
            'label' => 'Car ID',
            'type' => 'text'
        ),
        'cart_car_price' => array(
            'label' => 'Car Price',
            'type' => 'price',
        ),
        'cart_extra_price' => array(
            'label' => 'Extra Price',
            'type' => 'price',
        ),        
        '_checkout_location_price' => array(
            'label' => 'Different location price',
            'type' => 'price'
        ),
        '_young_surcharge_fee' => array(
            'label' => 'Young driver surcharge fee',
            'type' => 'price',
        ),

        //'separator' => '<div>',

        '_voucher_id' => array(
            'label' => 'Voucher ID',
            'type' => 'text'
        ),
        
        '_voucher_name' => array(
            'label' => 'Voucher name',
            'type' => 'text'
        ),
        '_voucher_code' => array(
            'label' => 'Voucher code',
            'type' => 'text'
        ),
        '_voucher_discount_percentage' => array(
            'label' => 'Voucher discount percentage',
            'type' => 'percentage'
        ),
        '_voucher_discount_amount'  => array(
            'label' => 'Voucher discount amount',
            'type' => 'price'
        ),

        //'separator' => '',

        'cart_total_price' => array (
            'label' => 'Total Price',
            'type' => 'price'
        ),
        '_checkout_payable_price' => array(
            'label' => 'Payable price',
            'type' => 'price'
        ),
        'cart_order_status' => array(
            'label' => 'Order status',
            'type' => 'text'    
        ),
    ); 
    return $arr; 
}


function get_payment_fields(){ 
    
    $arr = array(  
        'car_r_order_status' => array (
            'label' => 'Order statur', 
            'type' => 'status'
        ),
        'car_r_order_info' => array(
            'label' => 'Order info from paypal',
            'type' => 'text'
        ),
        'payerid' => array(
            'label' => 'Payer ID',
            'type' => 'text'    
        ),
        'responseamt' => array(
            'label' => 'Amt from Paypal',
            'type' => 'price'    
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
            'label' => 'Fullname',
            'placeholder' => 'full name',
            'enabled' => 1,
            'required' => 1,
            'type' => 'text'
        ),
        '_email' => array(
            'label' => 'Email address',
            'placeholder' => 'Email address',
            'enabled' => 1,
            'required' => 1,
            'type' => 'email'
        ),
        '_phone' => array(
            'label' => 'Phone',
            'placeholder' => 'Telephone number',
            'enabled' => 1,
            'required' => 1,
            'type' => 'text'
        ),
        '_address_1' => array(
            'label' => 'Address 1',
            'placeholder' => 'address line 1',
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
        ),
        '_address_2' => array(
            'label' => 'Address 2',
            'placeholder' => 'address line 2',
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
        ),
        '_city' => array(
            'label' => 'City',
            'placeholder' => 'city',
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
        ),
        '_country' => array(
            'label' => 'Country',
            'placeholder' => 'Select country',
            'enabled' => 1,
            'required' => 0,
            'type' => 'country'
        ),
        '_zip' => array(
            'label' => 'Zip',
            'placeholder' => 'zip code',
            'enabled' => 1,
            'required' => 0,
            'type' => 'text'
        ),
        '_flight_number' => array(
            'label' => 'Flight number',
            'placeholder' => 'Flight number',
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
