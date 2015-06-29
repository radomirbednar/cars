<?php
$Cars_cart = new Car_Cart('shopping_cart');
$Cars_cart_items = $Cars_cart->getItemSearch();
$currency = sc_Currency::get_instance();

//reservation via email only we dont stock any information only send the form and reset the session

if (isset($_POST['sc-reservation-checkout']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

    $sc_options = get_option('sc-pages');
    $checkout_car_url = isset($sc_options['checkout']) ? get_page_link($sc_options['checkout']) : '';
    $customer_email = sanitize_text_field($_POST['_email']);
    $Cars_cart = new Car_Cart('shopping_cart');
    $Cars_cart_items = $Cars_cart->getItems();
    $car_ID = $Cars_cart_items['car_ID'];
    $pick_up_location = $Cars_cart_items['pick_up_location'];
    $drop_off_location = $Cars_cart_items['drop_off_location'];
    $car_dfrom = $Cars_cart_items['car_datefrom'];
    $car_dto = $Cars_cart_items['car_dateto'];
    $car_category = $Cars_cart_items['car_category'];    
    
    //$car_dfrom_string = $car_dfrom->format('Y-m-d H:i');
    $car_dfrom_string = date_i18n( SC_DATETIME_FORMAT,  $car_dfrom->getTimestamp());
    
    //$car_dto_string = $car_dto->format('Y-m-d H:i');
    $car_dto_string = date_i18n( SC_DATETIME_FORMAT,  $car_dto->getTimestamp());
    
    $car_result = $Cars_cart->get_ItembyID($car_ID);

    //get the item title
    if (!empty($car_result)) {
        foreach ($car_result as $car) {
            $carID = $car->ID;

            $ItemName = get_the_title($carID);
            $post_thumbnail = get_the_post_thumbnail($carID, 'thumbnail');
        }
    }


    //get the extras infos
    if (isset($Cars_cart_items['service'])) {
        $extras = $Cars_cart_items['service'];
        foreach ($extras as $key => $extras_id) {
            $service_fee = get_post_meta($key, '_service_fee', true);
            $_per_service = get_post_meta($key, '_per_service', true);
            $service_name = get_the_title($key);
            $service_name.= $service_name . ', ';
        }
    }


    $car_price = $Cars_cart->get_car_price($car_ID, $car_dfrom, $car_dto);
    $yound_surcharge_fee = $Cars_cart->get_driver_surchage_price($car_price);
    $extras_price = $Cars_cart->sc_get_extras_price($car_dfrom, $car_dto);
    $location_price = $Cars_cart->getDifferentLocationPrice();
    $total_price = $Cars_cart->getTotalPrice();
    $total_price = money_format('%.2n', $total_price);
    $payable_price = $Cars_cart->getPaypablePrice();
    $payable_price = money_format('%.2n', $payable_price);
    ?>


    <?php
    /*
     *  booking detail
     */
    ?>

    <strong><?php _e('Booking details:', $this->car_share); ?></strong>
    <table>
        <tr>
            <td><?php _e('FROM', $this->car_share); ?></td>
            <td><?php echo $car_dfrom_string; ?></td>
            <td><?php echo get_the_title($pick_up_location); ?></td>
        </tr>
        <tr>
            <td><?php _e('TO', $this->car_share); ?></td>
            <td><?php echo $car_dto_string; ?></td>
            <td><?php echo get_the_title($drop_off_location); ?></td>
        </tr>
    </table>
    <table>
        <tr>
            <td><?php echo $post_thumbnail; ?></td>
            <td><?php echo $ItemName; ?></td>
        </tr>
        <?php if (!empty($extras)): ?>
            <tr>
                <td><?php _e('EXTRAS INFO: ', $this->car_share); ?></td>
                <td>
                    <?php
                    foreach ($extras as $key => $extras_id) {
                        $service_fee = get_post_meta($key, '_service_fee', true);
                        $_per_service = get_post_meta($key, '_per_service', true);
                        $service_name = get_the_title($key);
                        echo $extras_id . ' x ' . $service_name . ' ';
                    }
                    ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
    <?php
    /*
     *  billing information
     */
    ?>
    <strong><?php _e('Billing Information', $this->car_share); ?></strong>
    <?php
    global $post;
    $fields_to_show = array();
    $default_fields = get_default_checkout_fields();
    ?>
    <table>
        <tr>
            <td><?php _e('CAR PRICE : ', $this->car_share); ?></td>
            <td><?php echo $currency->format($car_price); ?></td>
        </tr>
        <?php if ($yound_surcharge_fee > 0) { ?>
            <tr>
                <td><?php _e('YOUNG DRIVER SURCHARGE : ', $this->car_share); ?></td>
                <td><?php echo $currency->format($yound_surcharge_fee); ?></td>
            </tr>
        <?php } ?>
        <?php if ($extras_price > 0) { ?>
            <tr>
                <td><?php _e('EXTRAS PRICE: ', $this->car_share); ?></td>
                <td><?php echo $currency->format($extras_price) ?></td>
            </tr>
        <?php } ?>
        <?php if ($location_price > 0) { ?>
            <tr>
                <td><?php _e('Different location price:', $this->car_share) ?></td>
                <td><?php echo $currency->format($location_price) ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td><?php _e('TOTAL : ', $this->car_share); ?></td>
            <td><?php echo $currency->format($total_price) ?></td>
        </tr>
        <tr>
            <td><?php _e('PAYABLE NOW : ', $this->car_share); ?></td>
            <td><?php echo $currency->format($payable_price) ?></td>
        </tr>
    </table>
    <?php
    global $post;
    $fields_to_show = array();
    $default_fields = get_default_checkout_fields();
    /*
     *
     * Informace z postu
     *
     */
    foreach ($default_fields as $field_key => $field) {
        if (isset($_POST[$field_key])) {
            $field['value'] = $_POST[$field_key];
            $fields_to_show[$field_key] = $field;
        }
    }


    /**
     * 
     * pridano 29.6.2015
     * 
     * 
     * Vytvorim zaznam do objednavek..??
     * 
     */
    
    $booking_title = $ItemName . '(' . $car_ID . ')' . ' - ' . $car->spz;
    $post_information = array(
        'post_title' => $booking_title,
        'post_type' => 'sc-booking',
        'post_status' => 'publish'
    );
    $post_insert_id = wp_insert_post($post_information);
    
    // pending status  na booking
    update_post_meta($post_insert_id, 'car_r_order_status', 2);
    
    $checkout_fields = get_enabled_checkout_fields();
    if ($post_insert_id) {
        // Update Custom Meta
        foreach ($checkout_fields as $input_key => $field) {
            //$field['required'];
            update_post_meta($post_insert_id, $input_key, esc_attr(strip_tags($_POST[$input_key])));
        }
        //post meta information about booking
        //nezapomenout smazat na konci veskerou session !!!!!!!
        //$_SESSION['post_insert_id'] = $post_insert_id;
        sc_Car::insertStatus($car_ID, $car_dfrom, $car_dto, Car_share::STATUS_BOOKED, $post_insert_id);
    }
    
    
    
    
    
    ?>
    <?php if (!empty($fields_to_show)): ?>
        <table>
        <?php foreach ($fields_to_show as $key => $field): ?>
                <tr>
                    <td>
                        <strong><?php _e($field['label'], $this->car_share) ?>: </strong>
                    </td>
                    <td>
            <?php
            switch ($key):
                case 'cart_pick_up':
                case 'cart_drop_off':
                case 'cart_car_category':
                    echo get_the_title($field['value']);
                    break;
                default:
                    echo empty($field['value']) ? '-' : esc_attr($field['value']);
            endswitch;
            ?>
                    </td>
                </tr>
        <?php endforeach; ?>
        </table>
        <?php endif; ?>
    <?php
    /*
     *
     * Odešleme potřebný email
     *
     */

    $currencyforpeople = sc_Currency::get_instance()->symbol();
    $plugin_patch = plugin_dir_path(dirname(__FILE__));
    $plugin_option = get_option('car_plugin_options_arraykey');

    if (!empty($plugin_option['notemail'])) {

        $email_subject = empty($plugin_option['name_of_company']) ? '' : $plugin_option['name_of_company'] . ' - ';
        $email_subject .= __('Booking email information', 'car_share');

        ob_start();
        //$email_customer_content = include_once($plugin_patch . 'catalog_information_client_email.php');
        $email_customer_content = include_once($plugin_patch . 'catalog_information_email.php');
        $option_notification_email = $plugin_option['notemail'];
        $email_customer_content = ob_get_contents();
        ob_end_clean();

        $headers = 'From: ' . $option_notification_email . ' <' . $option_notification_email . '>';
        $to = $customer_email;
        $subject = $email_subject;
        $message = $email_customer_content;
        $sendmailcheck = wp_mail($to, $subject, $message, $headers);

        ob_start();
        //$email_store_content = include_once($plugin_patch . 'catalog_information_email.php');
        $email_store_content = include_once($plugin_patch . 'catalog_information_client_email.php');
        $email_store_content = ob_get_contents();
        ob_end_clean();

        $headers = 'From: ' . $option_notification_email . ' <' . $option_notification_email . '>';
        $to = $option_notification_email;
        $subject = $email_subject;
        $message = $email_store_content;
        $sendmailcheckstore = wp_mail($to, $subject, $message, $headers);
    }
    ?>
    <?php
    exit();
}
/*
 * Navrat z paypal
 */
if (!empty($_SESSION['TOKENE'])) {

    $token_value = ($_SESSION['TOKENE']);
    $args = array(
        'post_type' => 'sc-booking',
        'meta_query' => array(
            array(
                'key' => 'car_succes_token',
                'value' => $token_value
            )
        )
    );

    $my_query = new WP_Query($args);
    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            $meta_values = get_post_custom(get_the_ID());
            $car_order = $meta_values["car_r_order_status"][0];
            $post_ID = get_the_ID();
            $cart_car_ID = get_post_meta($post_ID, 'cart_car_ID', true);
            $paypal_payed_amt = get_post_meta($post_ID, 'amt');
            $pick_up_location = get_post_meta($post_ID, 'cart_pick_up');
            $drop_off_location = get_post_meta($post_ID, 'cart_drop_off');
            $extras = get_post_meta($post_ID, 'cart_extras', true);
            $car_ID = sc_Car::get_parent_by_single_id($cart_car_ID);
            $checkout_cart_car_price = $meta_values["cart_car_price"][0];
            $checkout_cart_extra_price = $meta_values["cart_extra_price"][0];
            $checkout_cart_total_price = $meta_values["cart_total_price"][0];
            $checkout_cart_currency = $meta_values["cart_currency"][0];
            $checkout_checkout_payable_price = $meta_values["_checkout_payable_price"][0];
            $checkout_checkout_location_price = $meta_values["_checkout_location_price"][0];
            $checkout_young_surcharge_fee = $meta_values["_young_surcharge_fee"][0];
        } // end while
    } // end if

    wp_reset_postdata();

    global $wpdb;
    $dateinfo = $wpdb->get_row($wpdb->prepare("SELECT * FROM sc_single_car_status WHERE booking_id=%d", $post_ID));

    $car_dfrom_string = $dateinfo->date_from;
    $car_dto_string = $dateinfo->date_to;
    /*
     * Format date - must be from admin
     */
    $car_dto_string = DateTime::createFromFormat('Y-m-d H:i:s', $car_dto_string);
    //$car_dto_string = $car_dto_string->format('d-m-Y H:i');
    $car_dto_string = date_i18n( SC_DATETIME_FORMAT,  $car_dto_string->getTimestamp());

    $car_dfrom_string = DateTime::createFromFormat('Y-m-d H:i:s', $car_dfrom_string);
    
    //$car_dfrom_string = $car_dfrom_string->format('d-m-Y H:i');
    //$car_dfrom_string = $car_dfrom_string->format(SC_DATETIME_FORMAT);
    
    $car_dfrom_string = date_i18n( SC_DATETIME_FORMAT,  $car_dfrom_string->getTimestamp());
    


    if ($car_order == '1') {
        _e('<p>Thank your for your booking we will send our email booking confirmation to you</p>', $this->car_share);
    } elseif ($car_order == '2') {
        _e('<p>Thank you. Your booking is pending we will send our email booking information to you</p>', $this->car_share);
    } elseif ($car_order == '3') {
        _e('<p>Payment failed. Please try your payment again</p>', $this->car_share);
    }
    ?>

    <strong><?php _e('Booking details:', $this->car_share); ?></strong>
    <table>
        <tr>
            <td><?php _e('FROM', $this->car_share); ?></td>
            <td><?php echo $car_dfrom_string; ?></td>
            <td><?php echo get_the_title($pick_up_location[0]); ?></td>
        </tr>
        <tr>
            <td><?php _e('TO', $this->car_share); ?></td>
            <td><?php echo $car_dto_string; ?></td>
            <td><?php echo get_the_title($drop_off_location[0]); ?></td>
        </tr>
    </table>
    <table>
    <?php $post_thumbnail = get_the_post_thumbnail($car_ID, 'thumbnail'); ?>
        <tr>
            <td>
    <?php echo $post_thumbnail; ?>
            </td>
            <td><?php echo get_the_title($car_ID); ?></td>
        </tr>
    <?php if (!empty($extras)): ?>
            <tr>
                <td><?php _e('EXTRAS INFO: ', $this->car_share); ?></td>
                <td>
        <?php
        foreach ($extras as $key => $extras_id) {
            $service_fee = get_post_meta($key, '_service_fee', true);
            $_per_service = get_post_meta($key, '_per_service', true);
            $service_name = get_the_title($key);
            echo $extras_id . ' x ' . $service_name . ' ';
        }
        ?>
                </td>
            </tr>
    <?php endif; ?>
    </table>
    <strong><?php _e('Billing Information', $this->car_share); ?></strong>
    <?php
    global $post;
    $fields_to_show = array();
    $default_fields = get_default_checkout_fields();
    ?>
    <table>
        <tr>
            <td><?php _e('CAR PRICE : ', $this->car_share); ?></td>
            <td><?php echo $currency->format($checkout_cart_car_price); ?></td>
        </tr>
    <?php if ($checkout_young_surcharge_fee > 0) { ?>
            <tr>
                <td><?php _e('YOUNG DRIVER SURCHARGE : ', $this->car_share); ?></td>
                <td><?php echo $currency->format($checkout_young_surcharge_fee); ?></td>
            </tr>
    <?php } ?>
        <?php if ($checkout_cart_extra_price > 0) { ?>
            <tr>
                <td><?php _e('EXTRAS PRICE: ', $this->car_share); ?></td>
                <td><?php echo $currency->format($checkout_cart_extra_price) ?></td>
            </tr>
    <?php } ?>
        <?php if ($checkout_checkout_location_price > 0) { ?>
            <tr>
                <td><?php _e('Different location price:', $this->car_share) ?></td>
                <td><?php echo $currency->format($checkout_checkout_location_price) ?></td>
            </tr>
    <?php } ?>
        <tr>
            <td><?php _e('TOTAL : ', $this->car_share); ?></td>
            <td><?php echo $currency->format($checkout_cart_total_price) ?></td>
        </tr>
        <tr>
            <td><?php _e('PAYABLE NOW : ', $this->car_share); ?></td>
            <td><?php echo $currency->format($checkout_checkout_payable_price) ?></td>
        </tr>
    </table>

    <?php
    foreach ($default_fields as $field_key => $field) {
        if (isset($meta_values[$field_key])) {
            $field['value'] = $meta_values[$field_key][0];
            $fields_to_show[$field_key] = $field;
        }
    }
    ?>

    <?php if (!empty($fields_to_show)): ?>
        <table>
        <?php foreach ($fields_to_show as $key => $field): ?>
                <tr>
                    <td>
                        <strong><?php _e($field['label'], $this->car_share) ?>: </strong>
                    </td>
                    <td>
            <?php
            switch ($key):
                case 'cart_pick_up':
                case 'cart_drop_off':
                case 'cart_car_category':
                    echo get_the_title($field['value']);
                    break;
                default:
                    echo empty($field['value']) ? '-' : esc_attr($field['value']);
            endswitch;
            ?>
                    </td>
                </tr>
        <?php endforeach; ?>
        </table>
        <?php endif; ?>
    <?php
    // $car_result = $Cars_cart->get_ItembyID($car_ID);
    //we have the information about the token
    //Unset all of the session variables.
    // Finally, destroy the session.

    $_SESSION = array();
    session_destroy();
} elseif (!empty($Cars_cart_items)) {

    if (!empty($Cars_cart_items['service'])) {
        $extras = $Cars_cart_items['service'];
    }

    if (!empty($Cars_cart_items['car_ID'])) {

        $car_ID = $Cars_cart_items['car_ID'];
        $car_result = $Cars_cart->get_ItembyID($car_ID);

        if (!empty($Cars_cart_items['car_datefrom']) && !empty($Cars_cart_items['car_dateto'])) {


            $car_dfrom = $Cars_cart_items['car_datefrom'];
            //$car_dfrom_string = $car_dfrom->format('d-m-Y H:i');
            $car_dfrom_string = date_i18n( SC_DATETIME_FORMAT, $car_dfrom->getTimestamp());

            $car_dto = $Cars_cart_items['car_dateto'];
            
            //$car_dto_string = $car_dto->format('d-m-Y H:i');            
            $car_dto_string = date_i18n( SC_DATETIME_FORMAT, $car_dto->getTimestamp());
            
            
            
            
            $car_price = $Cars_cart->get_car_price($car_ID, $car_dfrom, $car_dto);
            $extras_price = $Cars_cart->sc_get_extras_price($car_dfrom, $car_dto);
            $total_price = $car_price + $extras_price;
        }
    }
    if (!empty($Cars_cart_items['pick_up_location'])) {
        $pick_up_location = $Cars_cart_items['pick_up_location'];
    }
    if (!empty($Cars_cart_items['drop_off_location'])) {
        $drop_off_location = $Cars_cart_items['drop_off_location'];
    }
    //cart category
    if (!empty($Cars_cart_items['car_category'])) {
        $car_category = $Cars_cart_items['car_category'];
    }
    ?>
    <?php if (!empty($car_result)) { ?>
        <?php foreach ($car_result as $car): ?>
            <?php $post_thumbnail = get_the_post_thumbnail($car->ID, 'thumbnail'); ?>
            <strong><?php _e('Review your booking', $this->car_share); ?></strong>
            <table>
                <tr>
                    <td><?php _e('FROM', $this->car_share); ?></td>
                    <td><?php echo $car_dfrom_string; ?></td>
                    <td><?php echo get_the_title($pick_up_location); ?></td>

                </tr>
                <tr>
                    <td><?php _e('TO', $this->car_share); ?></td>
                    <td><?php echo $car_dto_string; ?></td>
                    <td><?php echo get_the_title($drop_off_location); ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
            <?php echo $post_thumbnail; ?>
                    </td>
                    <td><?php echo get_the_title($car->ID); ?></td>
                </tr>

            <?php if (!empty($Cars_cart_items['service'])) { ?>
                    <tr>
                        <td><?php _e('EXTRAS INFO: ', $this->car_share); ?></td>
                        <td>
                <?php
                foreach ($extras as $key => $extras_id) {
                    $service_fee = get_post_meta($key, '_service_fee', true);
                    $_per_service = get_post_meta($key, '_per_service', true);
                    $service_name = get_the_title($key);
                    echo $extras_id . ' x ' . $service_name . ' ';
                }
                ?>
                        </td>
                    </tr>
            <?php } ?>

            </table>
        <?php endforeach; ?>

        <table>
            <tbody>
                <tr>
                    <td><?php _e('CAR PRICE : ', $this->car_share); ?></td>
                    <td><?php echo $currency->format($car_price) ?></td>
                </tr>
        <?php
        if (empty($car_category)) {
            // get car category from the car-ID because we need this here
            $car_category = get_post_meta($car->ID, '_car_category', true);
        }
        $surcharge_active = get_post_meta($car_category, '_surcharge_active', true);

        /**
         * young driver surcharge
         */
        if (1 == $surcharge_active):
            $surcharge_age = get_post_meta($car_category, '_surcharge_age', true);

            /*
             * do paticky
             */
            ?>
                <script>
                    jQuery(document).ready(function ($) {

                        function refrest_checkout_prices() {

                            var apply_surcharge = $('#apply-surcharge').is(':checked') ? 1 : 0;

                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    'action': 'refresh_checkout_price',
                                    'apply_surcharge': apply_surcharge
                                },
                                beforeSend: function () {
                                    //self.prop("disabled", true);
                                }
                            }).done(function (ret) {
                                $('#price-total').html(ret.total_price);
                                $('#price-payable-now').html(ret.paypable_now);

                                if (0 != ret.driver_surcharge) {
                                    $('#surcharge-price').html('+' + ret.driver_surcharge);
                                } else {
                                    $('#surcharge-price').html('');
                                }
                            }).fail(function (ret) {

                            }).always(function () {
                                //self.prop("disabled", false);
                            });
                        }

                        $("#apply-surcharge").click(function () {
                            refrest_checkout_prices();
                        });

                        // if somebody refresh page, we need refresh prices just in case somebody has checked 'yound driver surcharge'
                        refrest_checkout_prices();
                    });
                </script>

                <tr>
                    <td><?php _e('YOUNG DRIVER SURCHARGE : ', $this->car_share); ?></td>
                    <td>
                        <form id="surcharge-form" method="" action="">
                            <label>
                                <input id="apply-surcharge" type="checkbox" name="apply_surcharge" value="1">
            <?php printf(__('I am under %d.', $this->car_share), $surcharge_age); ?>
                            </label>
                        </form>
                        <span id="surcharge-price"></span>
                    </td>
                </tr>
        <?php endif; ?>

            <?php if (!empty($extras_price)) { ?>
                <tr>
                    <td><?php _e('EXTRAS PRICE: ', $this->car_share); ?></td>
                    <td><?php echo $currency->format($extras_price) ?></td>
                </tr>
            <?php
        }
        /**
         * different location price
         */
        $different_location_price = $Cars_cart->getDifferentLocationPrice();
        if (!empty($different_location_price)):
            ?>
                <tr>
                    <td>
            <?php _e('Different location price:', $this->car_share) ?>
                    </td>
                    <td>
            <?php echo $currency->format($different_location_price) ?>
                    </td>
                </tr>
            <?php
        endif;
        /**
         * Total price and payable now price
         */
        $total_price = $Cars_cart->getTotalPrice();
        $paypable_now = round($Cars_cart->getPaypablePrice(), 2);
        ?>
            <tr>
                <td><?php _e('TOTAL : ', $this->car_share); ?></td>
                <td>
                    <span id="price-total_total" class="price">
        <?php echo $currency->format($total_price) ?>
                    </span>
                </td>
            </tr>
            <tr class="hidden">
                <td><?php _e('TOTAL WITH VOUCHER: ', $this->car_share); ?></td>
                <td>
                    <span id="price-total" class="price">
        <?php echo $currency->format($total_price) ?>
                    </span>
                </td>
            </tr>
        <?php
        $sc_setting = get_option('sc_setting');
        if (isset($sc_setting['deposit_active']) && 1 == $sc_setting['deposit_active']) {
            $deposit_percentage = floatval($sc_setting['deposit_amount']);
        }
        ?>
            <tr>
                <td><?php _e('PAYABLE NOW : ', $this->car_share); ?></td>
                <td>
                    <span id="price-payable-now" class="price">
        <?php echo $currency->format($paypable_now) ?>

                    </span> <?php
        if (isset($deposit_percentage)) {
            echo '(' . $deposit_percentage . ' %)';
        }
        ?>
                </td>
            </tr>
            <?php
            // does exist any voucher ??
            global $wpdb;
            $sql = "SELECT ID FROM $wpdb->posts WHERE post_status='publish' AND post_type='sc-voucher'";
            $exists = $wpdb->get_var($sql);

            if (!empty($exists)):
                ?>
                <!-- voucher -->
                <script>
                    jQuery(document).ready(function ($) {
                        jQuery('#voucher-form').submit(function (e) {
                            e.preventDefault();
                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    'action': 'apply_voucher',
                                    'voucher': $('#voucher-code').val()
                                },
                                beforeSend: function () {
                                    //self.prop("disabled", true);
                                }
                            }).done(function (ret) {
                                $('.hidden').removeClass("hidden").addClass("show");
                                $('#price-total').html(ret.total_price);
                                $('#price-payable-now').html(ret.paypable_now);
                                $('#voucher-message').html(ret.message);
                            }).fail(function (ret) {
                            }).always(function () {
                                //self.prop("disabled", false);
                            });
                        });
                    })
                </script>
                <tr>
                    <td><?php _e('Voucher : ', $this->car_share); ?></td>
                    <td>
                        <form id="voucher-form" method="post" action="">
                            <input id="voucher-code" type="text" name="voucher" value="<?php echo isset($Cars_cart_items['voucher_code']) ? esc_attr($Cars_cart_items['voucher_code']) : ''; ?>">
                            <button type="submit" class="btn btn-default" name="voucher"><?php _e('Apply voucher', $this->car_share); ?></button>
                        </form>
                        <div id="voucher-message"></div>
                    </td>
                </tr>
                <!-- /voucher -->
            <?php endif; ?>
        </tbody>
        </table>
        <form action="" method="post" class="form-horizontal">
            <!-- Address form -->
            <strong><?php _e('Billing Information', $this->car_share); ?></strong>
            <?php
            $checkout_fields = get_enabled_checkout_fields();
            foreach ($checkout_fields as $input_key => $field):
                ?>
                <div class="control-group">
                    <label class="control-label"><?php _e($field['label'], $this->car_share); ?></label>
                    <div class="controls">

                        <?php
                        switch ($field['type']):
                            case 'country':
                                ?>
                                <select name="<?php echo esc_attr($input_key) ?>" <?php echo $field['required'] ? "required" : '' ?>>
                                    <option value=""><?php _e($field['placeholder'], $this->car_share); ?></option>
                                    <?php
                                    $countries = sc_get_countries();
                                    foreach ($countries as $iso => $country):
                                        ?>
                                        <option value="<?php echo $iso ?>"><?php _e($country, $this->car_share) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php
                                break;
                            case 'email':
                                ?>
                                <input name="<?php echo esc_attr($input_key) ?>" type="email" placeholder="<?php _e($field['placeholder'], $this->car_share); ?>" <?php echo $field['required'] ? "required" : '' ?> class="input-xlarge">
                                <?php
                                break;
                            default:
                                ?>
                                <input name="<?php echo esc_attr($input_key) ?>" type="text" placeholder="<?php _e($field['placeholder'], $this->car_share); ?>" <?php echo $field['required'] ? "required" : '' ?> class="input-xlarge">
                                <p class="help-block"></p>
                            <?php
                        endswitch;
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>

            <?php
            $payment_option = get_option('car_plugin_options_arraykey');
            $payment_option = isset($payment_option['catalogoption']) ? $payment_option['catalogoption'] : 0;

            if ($payment_option == 1):
                ?>
                <button type="submit" class="btn btn-default" name="sc-reservation-checkout"><?php _e('Reservation', $this->car_share); ?></button>
                <?php
            else:
                ?>
                <button type="submit" class="btn btn-default" name="sc-checkout"><?php _e('Book car', $this->car_share); ?></button>
            <?php
            endif;
            ?>
        </form>
        <?php
    } else {
        _e('Please go back and chose a car.', $this->car_share);
    }
} else {
    _e('Please go back and chose a car.', $this->car_share);
}
?>