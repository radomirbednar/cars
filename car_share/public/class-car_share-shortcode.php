<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Car_share_Shortcode {

    public $warning;
    public $cars;
    public $extras_car_url;
    private $token_result;
    private $customer_id;

    public function __construct($car_share, $version) {

        $this->car_share = $car_share;
        $this->version = $version;

        add_shortcode('sc-search_for_car', array($this, 'search_for_car'));
        add_shortcode('sc-pick_car', array($this, 'pick_car'));
        add_shortcode('sc-extras', array($this, 'extras'));
        add_shortcode('sc-checkout', array($this, 'checkout'));

        add_action('plugins_loaded', array($this, 'search_for_car_form'));
        add_action('plugins_loaded', array($this, 'paypal'));
        
        add_filter( 'wp_mail_content_type', array($this, 'set_content_type'));

        

        if (!isset($_SESSION)) {
            session_start();
        }
    }
    
    function set_content_type( $content_type ){
	return 'text/html';
    }

    public function paypal() {

        $sc_options_paypal = get_option('second_set_arraykey');

        if (!empty($sc_options_paypal['apiusername-setting'])) {
            $PayPalApiUsername = $sc_options_paypal['apiusername-setting'];
        }
        if (!empty($sc_options_paypal['apipassword-setting'])) {
            $PayPalApiPassword = $sc_options_paypal['apipassword-setting'];
        }
        if (!empty($sc_options_paypal['apisignature-setting'])) {
            $PayPalApiSignature = $sc_options_paypal['apisignature-setting'];
        }
        //paypal options
        $PayPalMode = 'sandbox'; // sandbox or live
        if (!empty($sc_options_paypal['paypalsandbox-setting'])) {

            if ($sc_options_paypal['paypalsandbox-setting'] == '0') {
                $PayPalMode = 'live';
            }
        }

        //page options
        $sc_options = get_option('sc-pages');
        $checkout_car_url = isset($sc_options['checkout']) ? get_page_link($sc_options['checkout']) : '';

        //currency form the setting
        $currency = $sc_options_paypal['sc-currency'];
        $PayPalCurrencyCode = $currency; //Paypal Currency Code
        //paypal return point from setting
        $PayPalReturnURL = $checkout_car_url; //Point to process.php page
        $PayPalCancelURL = $checkout_car_url; //Cancel URL if user clicks cancel

        include_once("paypalsdk/expresscheckout.php");


        if (isset($_POST['sc-checkout']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
            // information for the payment

            $Cars_cart = new Car_Cart('shopping_cart');
            $Cars_cart_items = $Cars_cart->getItems();

            $extras = $Cars_cart_items['service'];
            $car_ID = $Cars_cart_items['car_ID'];

            $pick_up_location = $Cars_cart_items['pick_up_location'];
            $drop_off_location = $Cars_cart_items['drop_off_location'];

            $car_dfrom = $Cars_cart_items['car_datefrom'];
            $car_dto = $Cars_cart_items['car_dateto'];
            $car_category = $Cars_cart_items['car_category'];

            $car_dfrom_string = $car_dfrom->format('Y-m-d H:i');
            $car_dto_string = $car_dto->format('Y-m-d H:i');

            $car_result = $Cars_cart->get_ItembyID($car_ID);

            //get the item title
            foreach ($car_result as $car) {
                $item_title = get_the_title($car->ID);
            }
            //get the extras infos
            foreach ($extras as $key => $extras_id) {
                $service_fee = get_post_meta($key, '_service_fee', true);
                $_per_service = get_post_meta($key, '_per_service', true);
                $service_name = get_the_title($key);
                $service_name.= $service_name . ', ';
            }

            $car_price = $Cars_cart->get_car_price($car_ID, $car_dfrom, $car_dto);
            $extras_price = $Cars_cart->sc_get_extras_price($car_dfrom, $car_dto);

            $total_price = $Cars_cart->getTotalPrice();
            $total_price = money_format('%.2n', $total_price);

            $payable_price = $Cars_cart->getPaypablePrice();

            // $payment_options;
            //insert post before we call paypal

            if (session_id() == '') {
                session_start();
            } //uncomment this line if PHP < 5.4.0 and comment out line above

            $PayPalMode = 'sandbox'; // sandbox or live

            $PayPalReturnURL = $checkout_car_url; //Point to process.php page
            $PayPalCancelURL = $checkout_car_url; //Cancel URL if user clicks cancel

            $paypalmode = ($PayPalMode == 'sandbox') ? '.sandbox' : '';

            //Mainly we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.

            $ItemName = $item_title; //Item Name
            $ItemPrice = $payable_price; //Item Price
            $ItemNumber = $car_ID; //Item Number

            $ItemDesc = "description"; //Item Description - extras etc
            $ItemQty = 1; // Item Quantity

            $ItemTotalPrice = ($ItemPrice * $ItemQty); //(Item Price x Quantity = Total) Get total amount of product;
            //Other important variables like tax, shipping cost
            //Grand total including all tax, insurance, shipping cost and discount
            $GrandTotal = ($ItemTotalPrice);

            //Parameters for SetExpressCheckout, which will be sent to PayPal
            $padata = '&METHOD=SetExpressCheckout' .
                    '&RETURNURL=' . urlencode($PayPalReturnURL) .
                    '&CANCELURL=' . urlencode($PayPalCancelURL) .
                    '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("Sale") .
                    '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                    '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($ItemNumber) .
                    '&L_PAYMENTREQUEST_0_DESC0=' . urlencode($ItemDesc) .
                    '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                    '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
                    '&NOSHIPPING=1' . //set 1 to hide buyer's shipping address, in-case products that does not require shipping
                    '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
                    '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
                    '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
                    '&LOCALECODE=GB' . //PayPal pages to match the language on your website.
                    '&ALLOWNOTE=0';

            /*
             * set session variable we need later for "DoExpressCheckoutPayment"
             */


            $_SESSION['ItemName'] = $ItemName; //Item Name
            $_SESSION['ItemPrice'] = $ItemPrice; //Item Price
            $_SESSION['ItemNumber'] = $ItemNumber; //Item Number
            $_SESSION['ItemDesc'] = $ItemDesc; //Item Number
            $_SESSION['ItemQty'] = $ItemQty; // Item Quantity
            $_SESSION['ItemTotalPrice'] = $ItemTotalPrice; //(Item Price x Quantity = Total) Get total amount of product;
            $_SESSION['GrandTotal'] = $GrandTotal;


            //We need to execute the "SetExpressCheckOut" method to obtain paypal token
            $paypal = new MyPayPal();
            $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

            //Respond according to message we receive from Paypal
            if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                $token = urldecode($httpParsedResponseAr["TOKEN"]);
                $_SESSION['TOKEN'] = $token;

                if (empty($_SESSION['post_insert_id'])) {
                    $booking_title = $item_title . '-' . $car_ID;
                    $post_information = array(
                        'post_title' => $booking_title,
                        'post_type' => 'sc-booking',
                        'post_status' => 'publish'
                    );
                    $post_insert_id = wp_insert_post($post_information);
                    $checkout_fields = get_enabled_checkout_fields();
                    if ($post_insert_id) {
                        // Update Custom Meta
                        foreach ($checkout_fields as $input_key => $field) {
                            //$field['required'];
                            update_post_meta($post_insert_id, $input_key, esc_attr(strip_tags($_POST[$input_key])));
                        }
                        //post meta information about booking
                        //nezapomenout smazat na konci veskerou session !!!!!!!
                        $_SESSION['post_insert_id'] = $post_insert_id;
                    }
                } else {

                    $post_insert_id = $_SESSION['post_insert_id'];
                    $booking_title = $item_title . '-' . $car_ID;
                    $post_information = array(
                        'ID' => $_SESSION['post_insert_id'],
                        'post_title' => $booking_title,
                        'post_type' => 'sc-booking',
                        'post_status' => 'publish'
                    );
                    wp_update_post($post_information);

                    $checkout_fields = get_enabled_checkout_fields();
                    if ($post_insert_id) {
                        // Update Custom Meta
                        foreach ($checkout_fields as $input_key => $field) {
                            //$field['required'];
                            update_post_meta($post_insert_id, $input_key, esc_attr(strip_tags($_POST[$input_key])));
                        }
                    }
                }

                $post_insert_id = $_SESSION['post_insert_id'];

                sc_Car::insertStatus($car_ID, $car_dfrom, $car_dto, Car_share::STATUS_BOOKED, $post_insert_id);
                update_post_meta($post_insert_id, '_checkout_payable_price', floatval($payable_price));
                update_post_meta($post_insert_id, 'cart_pick_up', esc_attr(strip_tags($pick_up_location)));
                update_post_meta($post_insert_id, 'cart_drop_off', esc_attr(strip_tags($drop_off_location)));
                update_post_meta($post_insert_id, 'cart_car_category', esc_attr(strip_tags($car_category)));
                update_post_meta($post_insert_id, 'cart_car_name', esc_attr(strip_tags($ItemName)));
                update_post_meta($post_insert_id, 'cart_car_ID', esc_attr(strip_tags($car_ID)));
                update_post_meta($post_insert_id, 'cart_car_price', esc_attr(strip_tags($car_price)));
                update_post_meta($post_insert_id, 'cart_extra_price', esc_attr(strip_tags($extras_price)));
                update_post_meta($post_insert_id, 'cart_total_price', esc_attr(strip_tags($total_price)));
                update_post_meta($post_insert_id, 'cart_extras', ($extras));
                //set to order status to pending - 2
                update_post_meta($post_insert_id, 'car_r_order_status', '2');
                //odeslani informace obchodnikovi o objednavce - protoze objednavku ukladame uz v tomto kroku
                // Example using the array form of $headers
                // assumes $to, $subject, $message have already been defined earlier...


                
                
                
                
                
                
                

                $email_client_content = '<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>[REPLACE THIS WITH YOUR TITLE]</title>
        <style media="all" type="text/css">
        [READ THE MINIFIED CSS FILE IN SEPARATELY AND INSERT IT HERE. YOU *CANNOT* JUST USE A CSS REFERENCE.]
    </style>
</head>
<body>
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td class="navbar navbar-inverse" align="center">
                <!-- This setup makes the nav background stretch the whole width of the screen. -->
                <table width="650px" cellspacing="0" cellpadding="3" class="container">
                    <tr class="navbar navbar-inverse">
                        <td colspan="4"><a class="brand" href="[YOUR WEB URL]">Bootstrap For Email</a></td>
                        <td><ul class="nav pull-right"><li><a href="[YOUR LOGIN URL]">Log On</a></li></ul></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF" align="center">
                <table width="650px" cellspacing="0" cellpadding="3" class="container">
                    <tr>
                        <td>[BODY CONTENT GOES HERE]</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF" align="center">
                <table width="650px" cellspacing="0" cellpadding="3" class="container">
                    <tr>
                        <td>
                            <hr>
                            <p>[PUT YOUR COPYRIGHT OR OTHER FOOTERY GOODNESS HERE]</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

                
                
                $option_notification_email = get_option('notemail');
                 
                $headers[] = 'From: Me Myself <radomir@example.net>';
                /* $headers[] = 'Cc: John Q Codex <jqc@wordpress.org>';
                  $headers[] = 'Cc: iluvwp@wordpress.org'; // note you can just use a simple email address */
                 
                $email_store_content = "";

                $to = 'radovanmail@gmail.com';
                $subject = 'test email';
                $message = $email_client_content;

                //$message = include_once('/partial/email_order_client.php');
 
                
                wp_mail($to, $subject, $message, $headers);
                
                 
 
                //Redirect user to PayPal store with Token received.
                $paypalurl = 'https://www' . $paypalmode . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=commit&token=' . $httpParsedResponseAr["TOKEN"] . '';
                header('Location: ' . $paypalurl);
                exit;
            } else {
                //Show error message
                echo '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                echo '<pre>';
                print_r($httpParsedResponseAr);
                echo '</pre>';
            }
        }

        //Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID

        if (isset($_GET["token"]) && isset($_GET["PayerID"])) {
            //we will be using these two variables to execute the "DoExpressCheckoutPayment"
            //Note: we haven't received any payment yet.

            $post_insert_id = $_SESSION['post_insert_id'];
            $token = $_GET["token"];
            $payer_id = $_GET["PayerID"];

            //we store the token like meta for search it after and display the result
            //get session variables
            $ItemName = $_SESSION['ItemName']; //Item Name
            $ItemPrice = $_SESSION['ItemPrice']; //Item Price
            $ItemNumber = $_SESSION['ItemNumber']; //Item Number
            $ItemDesc = $_SESSION['ItemDesc']; //Item Number
            $ItemQty = $_SESSION['ItemQty']; // Item Quantity
            $ItemTotalPrice = $_SESSION['ItemTotalPrice']; //(Item Price x Quantity = Total) Get total amount of product;
            $GrandTotal = $_SESSION['GrandTotal'];

            $padata = '&TOKEN=' . urlencode($token) .
                    '&PAYERID=' . urlencode($payer_id) .
                    '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                    //set item info here, otherwise we won't see product details later
                    '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                    '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($ItemNumber) .
                    '&L_PAYMENTREQUEST_0_DESC0=' . urlencode($ItemDesc) .
                    '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                    '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
                    '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
                    '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
                    '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
                    '&SOLUTIONTYPE=Sole&LANDINGPAGE=Billing';

            //check if the car is disponible
            //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
            $paypal = new MyPayPal();
            $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
            //Check if everything went ok..

            if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                $post_insert_id = $_SESSION['post_insert_id'];

                /*
                  //Sometimes Payment are kept pending even when transaction is complete.
                  //hence we need to notify user about it and ask him manually approve the transiction
                 */

                if ('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {

                    update_post_meta($post_insert_id, 'car_r_order_status', '1');
                    update_post_meta($post_insert_id, 'car_r_order_info', 'Completed DoExpressCheckoutPayment');

                    //send email here
                } elseif ('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {

                    update_post_meta($post_insert_id, 'car_r_order_status', '2');
                    update_post_meta($post_insert_id, 'car_r_order_info', 'Pending DoExpressCheckoutPayment');

                    //send email here
                }

                // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
                // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut

                $padaid = urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
                $padata = '&TOKEN=' . urlencode($token);
                $paypal = new MyPayPal();

                $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

                //$httpParsedResponseAr2 = $paypal->PPHttpPost('GetTransactionDetails',$padaid, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

                if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                    $post_insert_id = $_SESSION['post_insert_id'];

                    $buyerName = $httpParsedResponseAr["FIRSTNAME"] . ' ' . $httpParsedResponseAr["LASTNAME"];
                    $buyerEmail = $httpParsedResponseAr["EMAIL"];

                    $payerid = $httpParsedResponseAr["PAYERID"];
                    $responseamt = $httpParsedResponseAr["AMT"];
                    $checkoutstatur = $httpParsedResponseAr["CHECKOUTSTATUS"];

                    //save the transaction information
                    update_post_meta($post_insert_id, 'car_r_order_info', 'Completed GetExpressCheckoutDetails');

                    update_post_meta($post_insert_id, 'payerid', $payerid);
                    update_post_meta($post_insert_id, 'responseamt', $responseamt);
                    update_post_meta($post_insert_id, 'checkoutstaus', $checkoutstatur);
                    //muzeme ukladat i dalsi hodnoty
                    //save the information in database
                } else {

                    $post_insert_id = $_SESSION['post_insert_id'];
                    update_post_meta($post_insert_id, 'car_r_order_status', '3');
                    update_post_meta($post_insert_id, 'car_r_order_info', 'Failed GetExpressCheckoutDetails');

                    //delete meta !!!
                    /*
                      echo '<div style="color:red"><b>GetTransactionDetails failed:</b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                      echo '<pre>';
                      print_r($httpParsedResponseAr);
                      echo '</pre>';
                     */
                }
            } else {

                $post_insert_id = $_SESSION['post_insert_id'];
                update_post_meta($post_insert_id, 'car_r_order_status', '3');
                update_post_meta($post_insert_id, 'car_r_order_info', '' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '');

                /*
                  echo '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                  echo '<pre>';
                  print_r($httpParsedResponseAr);
                  echo '</pre>';
                 */
            }

            if (!empty($httpParsedResponseAr["TOKEN"])) {

                $token = urldecode($httpParsedResponseAr["TOKEN"]);
                $_SESSION['TOKEN'] = $token;
                update_post_meta($post_insert_id, 'car_succes_token', $token);
                wp_redirect($checkout_car_url);
                exit();
            }
        }
    }

    /*
     *
     * logic for the search shordcode
     *
     */

    public function search_for_car_form() {
        //fix for permalinks
        if (empty($GLOBALS['wp_rewrite']))
            $GLOBALS['wp_rewrite'] = new WP_Rewrite();

        $sc_options = get_option('sc-pages');
        $pick_car_url = isset($sc_options['pick_car']) ? get_permalink($sc_options['pick_car']) : '';


        //check if form is posted

        if (isset($_POST['pick_up_location']) && isset($_POST['car_datefrom']) && isset($_POST['car_dateto'])) {
            //id lokace
            $pick_up_location = sanitize_text_field($_POST['pick_up_location']);

            if (isset($_POST['returnlocation'])) {
                $drop_off_location = sanitize_text_field($_POST['drop_off_location']);
            } else {

                $drop_off_location = $pick_up_location;
            }

            //others infor from the form

            $car_datefrom = $_POST['car_datefrom'];
            $car_dateto = $_POST['car_dateto'];

            $car_hoursfrom = $_POST['car_hoursfrom'];
            $car_hoursto = $_POST['car_hoursto'];

            //get the kategory if any if not empty

            if (isset($_POST['car_category'])) {
                $car_category = sanitize_text_field($_POST['car_category']);
            } else {

                /*
                 * nemam aktivni vyber kategorie?
                 *
                 */

                $car_category = '';
            }

            $format = 'd-m-Y H';

            $car_dfrom = DateTime::createFromFormat($format, $car_datefrom . ' ' . $car_hoursfrom);
            $car_dto = DateTime::createFromFormat($format, $car_dateto . ' ' . $car_hoursto);

            $car_hoursfrom = $car_dfrom->format('H:i:s');
            $car_hoursto = $car_dto->format('H:i:s');

            // name for a day

            $day_car_from = date('l', strtotime($car_datefrom));
            $day_car_dateto = date('l', strtotime($car_dateto));

            // check for opening hours

            global $wpdb;

            $sqlfrom = $wpdb->prepare("SELECT * FROM
                    opening_hours WHERE location_id = %s
                    AND
                    dayname = %s
                    AND open = 1
                    AND open_from <= %s
                    AND open_to >= %s", $pick_up_location, $day_car_from, $car_hoursfrom, $car_hoursfrom
            );
            $resultfrom = $wpdb->get_results($sqlfrom);

            $sqlto = $wpdb->prepare("SELECT * FROM
                    opening_hours WHERE location_id = %s
                    AND
                    dayname = %s
                    AND open = 1
                    AND open_from <= %s
                    AND open_to >= %s", $drop_off_location, $day_car_dateto, $car_hoursto, $car_hoursto
            );

            $resultto = $wpdb->get_results($sqlto);

            if (empty($resultfrom) || empty($resultto)) {
                $this->warning = __('Sorry, we won\'t be here. Please choose another time.', $this->car_share);
            } else {

                $Cars_cart = new Car_Cart('shopping_cart');
                $Cars_cart->setItemSearch($pick_up_location, $drop_off_location, $car_dfrom, $car_dto, $car_category);
                $Cars_cart->save();
                wp_redirect($pick_car_url);
                exit;
            }
        }
    }

    public function pick_car_form() {

        $sc_options = get_option('sc-pages');
        $this->extras_car_url = isset($sc_options['extras']) ? get_page_link($sc_options['extras']) : '';

        $Cars_cart = new Car_Cart('shopping_cart');
        $Cars_cart_items = $Cars_cart->getItems();



        $pick_up_location = $Cars_cart_items['pick_up_location'];
        $drop_off_location = $Cars_cart_items['drop_off_location'];
        $car_dfrom = $Cars_cart_items['car_datefrom'];
        $car_dto = $Cars_cart_items['car_dateto'];
        $car_category = $Cars_cart_items['car_category'];
        $car_dfrom_string = $car_dfrom->format('Y-m-d H:i:s');
        $car_dto_string = $car_dto->format('Y-m-d H:i:s');

        /*
         * get me all cars from one category
         */

        global $wpdb;
        if ($car_category != '') {
            $category_and = "AND wp_postmeta.meta_value = '$car_category'";
        } else {
            $category_and = '';
        }

        $sc_setting = get_option('sc_setting');
        $car_block_time = isset($sc_setting['car_block_interval']) ? floor(floatval($sc_setting['car_block_interval']) * 60) : 0;

        $sql = "
            SELECT
                *
            FROM
                $wpdb->posts posts
            JOIN
                wp_postmeta wp_postmeta
            ON
                wp_postmeta.post_id = posts.ID
            JOIN
                sc_single_car sc_single_car
            ON
                sc_single_car.parent = posts.ID
            JOIN
                sc_single_car_location sc_location
            ON
                sc_location.single_car_id = sc_single_car.single_car_id
            JOIN
                sc_single_car_location sc_locationto
            ON
                sc_locationto.single_car_id = sc_single_car.single_car_id
            WHERE
                sc_single_car.single_car_id NOT IN
                    (
                        SELECT
                            single_car_id
                        FROM
                            sc_single_car_status
                        WHERE
                            (
                                    '$car_dto_string' > date_from
                                AND
                                    date_to > '$car_dfrom_string'
                                AND
                                    status != '" . car_share::STATUS_BOOKED . "'
                            )
                        OR
                            (
                                    '$car_dto_string' > date_from
                                AND
                                    DATE_ADD(date_to, INTERVAL $car_block_time MINUTE) > '$car_dfrom_string'
                                AND
                                    status = '" . car_share::STATUS_BOOKED . "'
                            )
                    )

                $category_and
                AND
                    posts.post_type = 'sc-car'
                AND
                    (sc_location.location_id = '$pick_up_location' AND sc_location.location_type = '1')
                AND
                    (sc_locationto.location_id = '$drop_off_location' AND sc_locationto.location_type = '2')
                AND
                    posts.post_status = 'publish'
                GROUP BY
                    posts.ID";

        $this->cars = $wpdb->get_results($sql);
    }

    public function extras_form() {
        /*
         * Add the id of the chose car
         */
        if (isset($_GET['chcar'])) {
            $id_code = sanitize_text_field($_GET['chcar']);
            $Cars_cart = new Car_Cart('shopping_cart');



            $Cars_cart->setItemId($id_code);
            $Cars_cart->save();
        }
        /*
         *  information form extras
         */
    }

    public function checkout_form() {
        if (isset($_POST['service'])) {
            //remove when zero
            $service = array_filter($_POST['service']);
            $Cars_cart = new Car_Cart('shopping_cart');
            $Cars_cart->setItemService($service);
            $Cars_cart->save();
        }
    }

    public function search_for_car($atts) {
        ob_start();
        include_once( 'partials/shortcode/search_for_car.php' );
        return ob_get_clean();
    }

    public function pick_car($atts) {

        $this->pick_car_form();
        ob_start();
        include_once( 'partials/shortcode/pick_car.php' );
        return ob_get_clean();
    }

    public function extras() {
        $this->extras_form();
        ob_start();
        include_once( 'partials/shortcode/extras.php' );
        return ob_get_clean();
    }

    public function checkout() {
        $this->checkout_form();
        ob_start();
        include_once( 'partials/shortcode/checkout.php' );
        return ob_get_clean();
    }

}
