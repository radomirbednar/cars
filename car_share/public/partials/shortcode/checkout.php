<?php
$Cars_cart = new Car_Cart('shopping_cart');
$Cars_cart_items = $Cars_cart->getItemSearch();

if (!empty($_SESSION['TOKEN'])) {

    $token_value = ($_SESSION['TOKEN']);
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

            $cart_car_ID = get_post_meta($post_ID, 'cart_car_ID');
            $paypal_payed_amt = get_post_meta($post_ID, 'amt');
            $pick_up_location = get_post_meta($post_ID, 'cart_pick_up');
         
            $drop_off_location = get_post_meta($post_ID, 'cart_drop_off');     
            $extras = get_post_meta($post_ID, 'cart_extras');
            
                
            } // end while
    } // end if
    wp_reset_postdata();

    global $wpdb;
    $dateinfo = $wpdb->get_row($wpdb->prepare("SELECT * FROM sc_single_car_status WHERE booking_id=%d", $post_ID));
    $car_dfrom_string = $dateinfo->date_from;
    $car_dto_string = $dateinfo->date_to;


    if ($car_order == '1') {
        _e('Thank your for your booking we are send you all information to your email:', $this->car_share);
    } elseif ($car_order == '2') {
        _e('Thank you. Your booking is pending now we are send you all information to your email:', $this->car_share);
    } elseif ($car_order == '3') {
        _e('There are something wrong. Payment failed', $this->car_share);
    }
    ?>

    <table> 
        <th><td><strong><?php _e('Booking details:', $this->car_share); ?></strong></td></th>      
    <tr>
        <td><?php _e('FROM', $this->car_share); ?></td>
        <td><?php echo get_the_title($pick_up_location[0]); ?></td>
        <td><?php echo $car_dfrom_string; ?></td>
    </tr>

    <tr>
        <td><?php _e('TO', $this->car_share); ?></td>
        <td><?php echo get_the_title($drop_off_location[0]); ?></td>

        <td><?php echo $car_dto_string; ?></td>
    </tr>

    <?php $post_thumbnail = get_the_post_thumbnail($cart_car_ID, 'thumbnail'); ?>
    <tr>
        <td>
            <?php echo $post_thumbnail; ?>
        </td>
        <td><?php echo get_the_title($cart_car_ID); ?></td>
    </tr>

    <tr> 
        <td><?php _e('EXTRAS INFO: ', $this->car_share); ?></td>
        <td> 
            <?php //var_dump($extras);
            
            
                
            
            
            
            ?> 
        </td> 
    </tr>
    <tr>
        <td>
 
        </td>
    </tr>
    <tr>
        <td>
 
        </td>
    </tr>
    </table>
    <th><td><?php _e('CUSTOMER DETAILS', $this->car_share); ?></td></th>

    <?php
    global $post;

    $fields_to_show = array();
    $default_fields = get_default_checkout_fields();
    $custom_fields = get_post_custom($post_ID);

    foreach ($default_fields as $field_key => $field) {
        if (isset($custom_fields[$field_key])) {
            $field['value'] = $custom_fields[$field_key][0];
            $fields_to_show[] = $field;
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
    //  $car_result = $Cars_cart->get_ItembyID($car_ID);
    //we have the information about the token
    //Unset all of the session variables.
    $_SESSION = array();
    // Finally, destroy the session.
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
            $car_dfrom_string = $car_dfrom->format('Y-m-d H:i');
            $car_dto = $Cars_cart_items['car_dateto'];
            $car_dto_string = $car_dto->format('Y-m-d H:i');
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
                    <td><?php echo get_the_title($pick_up_location); ?></td>
                    <td><?php echo $car_dfrom_string; ?></td>
                </tr>
                <tr>
                    <td><?php _e('TO', $this->car_share); ?></td>
                    <td><?php echo get_the_title($drop_off_location); ?></td>
                    <td><?php echo $car_dto_string; ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
            <?php echo $post_thumbnail; ?>
                    </td>
                    <td><?php echo get_the_title($car->ID); ?></td>
                </tr>
            </table>
        <?php endforeach; ?>

        <table>
            <tbody>
        <?php if (!empty($Cars_cart_items['service'])) { ?>
                    <tr>
                        <td><?php _e('EXTRAS INFO: ', $this->car_share); ?></td>
                        <td>
            <?php
            foreach ($extras as $key => $extras_id) {
                $service_fee = get_post_meta($key, '_service_fee', true);
                $_per_service = get_post_meta($key, '_per_service', true);
                $service_name = get_the_title($key);
                echo $service_name . ', ';
                ?>
                            </td>
                        </tr>
                <?php
            }
        }
        ?>
                <tr>
                    <td><?php _e('CAR : ', $this->car_share); ?></td>
                    <td><?php echo $car_price; ?></td>
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
             *
             * do paticky
             *
             */
            ?>



                <script>
                    jQuery(document).ready(function ($) {

                        function refrest_checkout_prices() {

                            var apply_surcharge = $('#apply-surcharge').is(':checked') ? 1 : 0;

                            //console.log(apply_surcharge);

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
                    </td>
                </tr>
        <?php endif; ?>

            <?php if (!empty($extras_price)) { ?>
                <tr>
                    <td><?php _e('EXTRAS : ', $this->car_share); ?></td>
                    <td><?php echo $extras_price; ?></td>
                </tr>
        <?php } 
        
        
        /**
         * Total price and payable now price
         */
        $total_price = $Cars_cart->getTotalPrice();        
        $paypable_now = round($Cars_cart->getPaypablePrice(), 1);
        ?>
            <tr>
                <td><?php _e('TOTAL : ', $this->car_share); ?></td>
                <td>
                    <span id="price-total" class="price">
                        <?php echo $total_price ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td><?php _e('PAYABLE NOW : ', $this->car_share); ?></td>
                <td>
                    <span id="price-payable-now" class="price">
                        <?php echo $paypable_now ?>
                    </span>
                </td>
            </tr>
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
                        <input id="postal-code" name="<?php echo esc_attr($input_key) ?>" type="text" placeholder="<?php _e($field['placeholder'], $this->car_share); ?>"
            <?php
            if ($field['required']) {
                echo "required";
            }
            ?>  class="input-xlarge">
                        <p class="help-block"></p>
                    </div>
                </div>
        <?php endforeach; ?>
            <?php /*

              <!-- full-name input-->
              <div class="control-group">
              <label class="control-label"><?php _e('Full Name', $this->car_share); ?></label>
              <div class="controls">
              <input id="full-name" name="full-name" type="text" placeholder="full name"
              class="input-xlarge">
              <p class="help-block"></p>
              </div>
              </div>

              <!-- full-email input-->
              <div class="control-group">
              <label class="control-label"><?php _e('Email address', $this->car_share); ?></label>
              <div class="controls">
              <input id="full-name" name="full-email" type="text" placeholder="<?php _e('Email address', $this->car_share); ?>"
              class="input-xlarge">
              <p class="help-block"></p>
              </div>
              </div>

              <!-- full-email input-->
              <div class="control-group">
              <label class="control-label"><?php _e('Telephone number', $this->car_share); ?></label>
              <div class="controls">
              <input id="full-name" name="full-email" type="text" placeholder="<?php _e('Telephone number', $this->car_share); ?>"
              class="input-xlarge">
              <p class="help-block"></p>
              </div>
              </div>


              <!-- address-line1 input-->
              <div class="control-group">
              <label class="control-label"><?php _e('Address Line 1', $this->car_share); ?></label>
              <div class="controls">
              <input id="address-line1" name="address-line1" type="text" placeholder="<?php _e('address line 1', $this->car_share); ?>"
              class="input-xlarge">
              <p class="help-block">Street address, P.O. box, company name, c/o</p>
              </div>
              </div>

              <!-- address-line2 input-->
              <div class="control-group">
              <label class="control-label"><?php _e('Address Line 2', $this->car_share); ?></label>
              <div class="controls">
              <input id="address-line2" name="address-line2" type="text" placeholder="<?php _e('address line 2', $this->car_share); ?>"
              class="input-xlarge">
              <p class="help-block">Apartment, suite , unit, building, floor, etc.</p>
              </div>
              </div>

              <!-- city input-->
              <div class="control-group">
              <label class="control-label"><?php _e('City / Town', $this->car_share); ?></label>
              <div class="controls">
              <input id="city" name="city" type="text" placeholder="<?php _e('city', $this->car_share); ?>" class="input-xlarge">
              <p class="help-block"></p>
              </div>
              </div>

              <!-- region input-->
              <div class="control-group">
              <label class="control-label"><?php _e('State / Province / Region', $this->car_share); ?></label>
              <div class="controls">
              <input id="region" name="region" type="text" placeholder="<?php _e('state / province / region', $this->car_share); ?>"
              class="input-xlarge">
              <p class="help-block"></p>
              </div>
              </div>

              <!-- postal-code input-->
              <div class="control-group">
              <label class="control-label"><?php _e('Zip / Postal Code', $this->car_share); ?></label>
              <div class="controls">
              <input id="postal-code" name="postal-code" type="text" placeholder="<?php _e('zip or postal code', $this->car_share); ?>"
              class="input-xlarge">
              <p class="help-block"></p>
              </div>
              </div>

              <!-- country select -->
              <div class="control-group">
              <label class="control-label"><?php _e('Country', $this->car_share); ?></label>
              <div class="controls">
              <select id="country" name="country" class="input-xlarge">
              <option value="" selected="selected"><?php _e('(please select a country)', $this->car_share); ?></option>
              <option value="AF"><?php _e('Afghanistan', $this->car_share); ?></option>
              <option value="AL"><?php _e('Albania', $this->car_share); ?></option>
              <option value="DZ"><?php _e('Algeria', $this->car_share); ?></option>
              <option value="AS"><?php _e('American Samoa', $this->car_share); ?></option>
              <option value="AD"><?php _e('Andorra', $this->car_share); ?></option>
              <option value="AO"><?php _e('Angola', $this->car_share); ?></option>
              <option value="AI"><?php _e('Anguilla', $this->car_share); ?></option>
              <option value="AQ"><?php _e('Antarctica', $this->car_share); ?></option>
              <option value="AG"><?php _e('Antigua and Barbuda', $this->car_share); ?></option>
              <option value="AR"><?php _e('Argentina', $this->car_share); ?></option>
              <option value="AM"><?php _e('Armenia', $this->car_share); ?></option>
              <option value="AW"><?php _e('Aruba', $this->car_share); ?></option>
              <option value="AU"><?php _e('Australia', $this->car_share); ?></option>
              <option value="AT"><?php _e('Austria', $this->car_share); ?></option>
              <option value="AZ"><?php _e('Azerbaijan', $this->car_share); ?></option>
              <option value="BS"><?php _e('Bahamas', $this->car_share); ?></option>
              <option value="BH"><?php _e('Bahrain', $this->car_share); ?></option>
              <option value="BD"><?php _e('Bangladesh', $this->car_share); ?></option>
              <option value="BB"><?php _e('Barbados', $this->car_share); ?></option>
              <option value="BY"><?php _e('Belarus', $this->car_share); ?></option>
              <option value="BE"><?php _e('Belgium', $this->car_share); ?></option>
              <option value="BZ"><?php _e('Belize', $this->car_share); ?></option>
              <option value="BJ"><?php _e('Benin', $this->car_share); ?></option>
              <option value="BM"><?php _e('Bermuda', $this->car_share); ?></option>
              <option value="BT"><?php _e('Bhutan', $this->car_share); ?></option>
              <option value="BO"><?php _e('Bolivia', $this->car_share); ?></option>
              <option value="BA"><?php _e('Bosnia and Herzegowina', $this->car_share); ?></option>
              <option value="BW"><?php _e('Botswana', $this->car_share); ?></option>
              <option value="BV"><?php _e('Bouvet Island', $this->car_share); ?></option>
              <option value="BR"><?php _e('Brazil', $this->car_share); ?></option>
              <option value="IO"><?php _e('British Indian Ocean Territory', $this->car_share); ?></option>
              <option value="BN"><?php _e('Brunei Darussalam', $this->car_share); ?></option>
              <option value="BG"><?php _e('Bulgaria', $this->car_share); ?></option>
              <option value="BF">Burkina Faso</option>
              <option value="BI">Burundi</option>
              <option value="KH">Cambodia</option>
              <option value="CM">Cameroon</option>
              <option value="CA">Canada</option>
              <option value="CV">Cape Verde</option>
              <option value="KY">Cayman Islands</option>
              <option value="CF">Central African Republic</option>
              <option value="TD">Chad</option>
              <option value="CL">Chile</option>
              <option value="CN">China</option>
              <option value="CX">Christmas Island</option>
              <option value="CC">Cocos (Keeling) Islands</option>
              <option value="CO">Colombia</option>
              <option value="KM">Comoros</option>
              <option value="CG">Congo</option>
              <option value="CD">Congo, the Democratic Republic of the</option>
              <option value="CK">Cook Islands</option>
              <option value="CR">Costa Rica</option>
              <option value="CI">Cote d'Ivoire</option>
              <option value="HR">Croatia (Hrvatska)</option>
              <option value="CU">Cuba</option>
              <option value="CY">Cyprus</option>
              <option value="CZ">Czech Republic</option>
              <option value="DK">Denmark</option>
              <option value="DJ">Djibouti</option>
              <option value="DM">Dominica</option>
              <option value="DO">Dominican Republic</option>
              <option value="TP">East Timor</option>
              <option value="EC">Ecuador</option>
              <option value="EG">Egypt</option>
              <option value="SV">El Salvador</option>
              <option value="GQ">Equatorial Guinea</option>
              <option value="ER">Eritrea</option>
              <option value="EE">Estonia</option>
              <option value="ET">Ethiopia</option>
              <option value="FK">Falkland Islands (Malvinas)</option>
              <option value="FO">Faroe Islands</option>
              <option value="FJ">Fiji</option>
              <option value="FI">Finland</option>
              <option value="FR">France</option>
              <option value="FX">France, Metropolitan</option>
              <option value="GF">French Guiana</option>
              <option value="PF">French Polynesia</option>
              <option value="TF">French Southern Territories</option>
              <option value="GA">Gabon</option>
              <option value="GM">Gambia</option>
              <option value="GE">Georgia</option>
              <option value="DE">Germany</option>
              <option value="GH">Ghana</option>
              <option value="GI">Gibraltar</option>
              <option value="GR">Greece</option>
              <option value="GL">Greenland</option>
              <option value="GD">Grenada</option>
              <option value="GP">Guadeloupe</option>
              <option value="GU">Guam</option>
              <option value="GT">Guatemala</option>
              <option value="GN">Guinea</option>
              <option value="GW">Guinea-Bissau</option>
              <option value="GY">Guyana</option>
              <option value="HT">Haiti</option>
              <option value="HM">Heard and Mc Donald Islands</option>
              <option value="VA">Holy See (Vatican City State)</option>
              <option value="HN">Honduras</option>
              <option value="HK">Hong Kong</option>
              <option value="HU">Hungary</option>
              <option value="IS">Iceland</option>
              <option value="IN">India</option>
              <option value="ID">Indonesia</option>
              <option value="IR">Iran (Islamic Republic of)</option>
              <option value="IQ">Iraq</option>
              <option value="IE">Ireland</option>
              <option value="IL">Israel</option>
              <option value="IT">Italy</option>
              <option value="JM">Jamaica</option>
              <option value="JP">Japan</option>
              <option value="JO">Jordan</option>
              <option value="KZ">Kazakhstan</option>
              <option value="KE">Kenya</option>
              <option value="KI">Kiribati</option>
              <option value="KP">Korea, Democratic People's Republic of</option>
              <option value="KR">Korea, Republic of</option>
              <option value="KW">Kuwait</option>
              <option value="KG">Kyrgyzstan</option>
              <option value="LA">Lao People's Democratic Republic</option>
              <option value="LV">Latvia</option>
              <option value="LB">Lebanon</option>
              <option value="LS">Lesotho</option>
              <option value="LR">Liberia</option>
              <option value="LY">Libyan Arab Jamahiriya</option>
              <option value="LI">Liechtenstein</option>
              <option value="LT">Lithuania</option>
              <option value="LU">Luxembourg</option>
              <option value="MO">Macau</option>
              <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
              <option value="MG">Madagascar</option>
              <option value="MW">Malawi</option>
              <option value="MY">Malaysia</option>
              <option value="MV">Maldives</option>
              <option value="ML">Mali</option>
              <option value="MT">Malta</option>
              <option value="MH">Marshall Islands</option>
              <option value="MQ">Martinique</option>
              <option value="MR">Mauritania</option>
              <option value="MU">Mauritius</option>
              <option value="YT">Mayotte</option>
              <option value="MX">Mexico</option>
              <option value="FM">Micronesia, Federated States of</option>
              <option value="MD">Moldova, Republic of</option>
              <option value="MC">Monaco</option>
              <option value="MN">Mongolia</option>
              <option value="MS">Montserrat</option>
              <option value="MA">Morocco</option>
              <option value="MZ">Mozambique</option>
              <option value="MM">Myanmar</option>
              <option value="NA">Namibia</option>
              <option value="NR">Nauru</option>
              <option value="NP">Nepal</option>
              <option value="NL">Netherlands</option>
              <option value="AN">Netherlands Antilles</option>
              <option value="NC">New Caledonia</option>
              <option value="NZ">New Zealand</option>
              <option value="NI">Nicaragua</option>
              <option value="NE">Niger</option>
              <option value="NG">Nigeria</option>
              <option value="NU">Niue</option>
              <option value="NF">Norfolk Island</option>
              <option value="MP">Northern Mariana Islands</option>
              <option value="NO">Norway</option>
              <option value="OM">Oman</option>
              <option value="PK">Pakistan</option>
              <option value="PW">Palau</option>
              <option value="PA">Panama</option>
              <option value="PG">Papua New Guinea</option>
              <option value="PY">Paraguay</option>
              <option value="PE">Peru</option>
              <option value="PH">Philippines</option>
              <option value="PN">Pitcairn</option>
              <option value="PL">Poland</option>
              <option value="PT">Portugal</option>
              <option value="PR">Puerto Rico</option>
              <option value="QA">Qatar</option>
              <option value="RE">Reunion</option>
              <option value="RO">Romania</option>
              <option value="RU">Russian Federation</option>
              <option value="RW">Rwanda</option>
              <option value="KN">Saint Kitts and Nevis</option>
              <option value="LC">Saint LUCIA</option>
              <option value="VC">Saint Vincent and the Grenadines</option>
              <option value="WS">Samoa</option>
              <option value="SM">San Marino</option>
              <option value="ST">Sao Tome and Principe</option>
              <option value="SA">Saudi Arabia</option>
              <option value="SN">Senegal</option>
              <option value="SC">Seychelles</option>
              <option value="SL">Sierra Leone</option>
              <option value="SG">Singapore</option>
              <option value="SK">Slovakia (Slovak Republic)</option>
              <option value="SI">Slovenia</option>
              <option value="SB">Solomon Islands</option>
              <option value="SO">Somalia</option>
              <option value="ZA">South Africa</option>
              <option value="GS">South Georgia and the South Sandwich Islands</option>
              <option value="ES">Spain</option>
              <option value="LK">Sri Lanka</option>
              <option value="SH">St. Helena</option>
              <option value="PM">St. Pierre and Miquelon</option>
              <option value="SD">Sudan</option>
              <option value="SR">Suriname</option>
              <option value="SJ">Svalbard and Jan Mayen Islands</option>
              <option value="SZ">Swaziland</option>
              <option value="SE">Sweden</option>
              <option value="CH">Switzerland</option>
              <option value="SY">Syrian Arab Republic</option>
              <option value="TW">Taiwan, Province of China</option>
              <option value="TJ">Tajikistan</option>
              <option value="TZ">Tanzania, United Republic of</option>
              <option value="TH">Thailand</option>
              <option value="TG">Togo</option>
              <option value="TK">Tokelau</option>
              <option value="TO">Tonga</option>
              <option value="TT">Trinidad and Tobago</option>
              <option value="TN">Tunisia</option>
              <option value="TR">Turkey</option>
              <option value="TM">Turkmenistan</option>
              <option value="TC">Turks and Caicos Islands</option>
              <option value="TV">Tuvalu</option>
              <option value="UG">Uganda</option>
              <option value="UA">Ukraine</option>
              <option value="AE">United Arab Emirates</option>
              <option value="GB">United Kingdom</option>
              <option value="US">United States</option>
              <option value="UM">United States Minor Outlying Islands</option>
              <option value="UY">Uruguay</option>
              <option value="UZ">Uzbekistan</option>
              <option value="VU">Vanuatu</option>
              <option value="VE">Venezuela</option>
              <option value="VN">Viet Nam</option>
              <option value="VG">Virgin Islands (British)</option>
              <option value="VI">Virgin Islands (U.S.)</option>
              <option value="WF">Wallis and Futuna Islands</option>
              <option value="EH">Western Sahara</option>
              <option value="YE">Yemen</option>
              <option value="YU">Yugoslavia</option>
              <option value="ZM">Zambia</option>
              <option value="ZW">Zimbabwe</option>
              </select>
              </div>
              </div>
             */ ?>

            <?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>

            <button type="submit" class="btn btn-default" name="sc-checkout"><?php _e('Book car', $this->car_share); ?></button>
        </form>
        <?php
    } else {

        _e('Please go back and chose a car.', $this->car_share);
    }
} else {

    _e('Please go back and chose a car.', $this->car_share);
}
?>
