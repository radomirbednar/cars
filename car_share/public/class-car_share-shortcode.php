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

    public function __construct($car_share, $version) {

        $this->car_share = $car_share;
        $this->version = $version;

        add_shortcode('sc-search_for_car', array($this, 'search_for_car'));
        add_shortcode('sc-pick_car', array($this, 'pick_car'));
        add_shortcode('sc-extras', array($this, 'extras'));
        add_shortcode('sc-checkout', array($this, 'checkout'));
        add_action('plugins_loaded', array($this, 'search_for_car_form'));
        
        
        add_action('plugins_loaded', array($this, 'paypal'));

        if (!isset($_SESSION)) {
            session_start();
        }
    }

    
     
    public function paypal()
    {
   
    if (isset($_POST['sc-checkout'])) {
   
 
    $sc_options = get_option('sc-pages');
    $extras_car_url = isset($sc_options['checkout']) ? get_page_link($sc_options['checkout']) : '';
 
//if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above

    $PayPalMode = 'sandbox'; // sandbox or live
    $PayPalApiUsername = 'cartest3_api1.gmail.com'; //PayPal API Username
    $PayPalApiPassword = '4969WLQ8PATCJT42'; //Paypal API password
    $PayPalApiSignature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AJigSRP9es1tjbtC61K0du213F1O'; //Paypal API Signature
    $PayPalCurrencyCode = 'USD'; //Paypal Currency Code
     
    $PayPalReturnURL = $extras_car_url; //Point to process.php page
    $PayPalCancelURL = $extras_car_url; //Cancel URL if user clicks cancel

    include_once("paypalsdk/expresscheckout.php");

    $paypalmode = ($PayPalMode == 'sandbox') ? '.sandbox' : '';


    //Mainly we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.


    $ItemName = "item"; //Item Name
    $ItemPrice = 300.00; //Item Price
    $ItemNumber = 1; //Item Number
    $ItemDesc = "description"; //Item Number
    $ItemQty = 1; // Item Quantity
    $ItemTotalPrice = ($ItemPrice * $ItemQty); //(Item Price x Quantity = Total) Get total amount of product;
    //Other important variables like tax, shipping cost
    $TotalTaxAmount = 2.58;  //Sum of tax for all items in this order.
  
    //Grand total including all tax, insurance, shipping cost and discount
    $GrandTotal = ($ItemTotalPrice + $TotalTaxAmount );

    //Parameters for SetExpressCheckout, which will be sent to PayPal
    $padata = '&METHOD=SetExpressCheckout' .
            '&RETURNURL=' . urlencode($PayPalReturnURL) .
            '&CANCELURL=' . urlencode($PayPalCancelURL) .
            '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
            '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
            '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($ItemNumber) .
            '&L_PAYMENTREQUEST_0_DESC0=' . urlencode($ItemDesc) .
            '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
            '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
           
            /*
              //Additional products (L_PAYMENTREQUEST_0_NAME0 becomes L_PAYMENTREQUEST_0_NAME1 and so on)
              '&L_PAYMENTREQUEST_0_NAME1='.urlencode($ItemName2).
              '&L_PAYMENTREQUEST_0_NUMBER1='.urlencode($ItemNumber2).
              '&L_PAYMENTREQUEST_0_DESC1='.urlencode($ItemDesc2).
              '&L_PAYMENTREQUEST_0_AMT1='.urlencode($ItemPrice2).
              '&L_PAYMENTREQUEST_0_QTY1='. urlencode($ItemQty2).
             */

            /*
              //Override the buyer's shipping address stored on PayPal, The buyer cannot edit the overridden address.
              '&ADDROVERRIDE=1'.
              '&PAYMENTREQUEST_0_SHIPTONAME=J Smith'.
              '&PAYMENTREQUEST_0_SHIPTOSTREET=1 Main St'.
              '&PAYMENTREQUEST_0_SHIPTOCITY=San Jose'.
              '&PAYMENTREQUEST_0_SHIPTOSTATE=CA'.
              '&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE=US'.
              '&PAYMENTREQUEST_0_SHIPTOZIP=95131'.
              '&PAYMENTREQUEST_0_SHIPTOPHONENUM=408-967-4444'.
             */

            '&NOSHIPPING=1' . //set 1 to hide buyer's shipping address, in-case products that does not require shipping

            '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
            '&PAYMENTREQUEST_0_TAXAMT=' . urlencode($TotalTaxAmount) .
            '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
            '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
            '&LOCALECODE=GB' . //PayPal pages to match the language on your website.
            '&ALLOWNOTE=0';

    ############# set session variable we need later for "DoExpressCheckoutPayment" #######
    $_SESSION['ItemName'] = $ItemName; //Item Name
    $_SESSION['ItemPrice'] = $ItemPrice; //Item Price
    $_SESSION['ItemNumber'] = $ItemNumber; //Item Number
    $_SESSION['ItemDesc'] = $ItemDesc; //Item Number
    $_SESSION['ItemQty'] = $ItemQty; // Item Quantity
    $_SESSION['ItemTotalPrice'] = $ItemTotalPrice; //(Item Price x Quantity = Total) Get total amount of product;
    $_SESSION['TotalTaxAmount'] = $TotalTaxAmount;  //Sum of tax for all items in this order.
 
 
    $_SESSION['GrandTotal'] = $GrandTotal;


    //We need to execute the "SetExpressCheckOut" method to obtain paypal token
    $paypal = new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

    //Respond according to message we receive from Paypal
    if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
    
        
        
        //Redirect user to PayPal store with Token received.
        $paypalurl = 'https://www' . $paypalmode . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
         
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

    $token = $_GET["token"];
    $payer_id = $_GET["PayerID"];

    //get session variables
    $ItemName = $_SESSION['ItemName']; //Item Name
    $ItemPrice = $_SESSION['ItemPrice']; //Item Price
    $ItemNumber = $_SESSION['ItemNumber']; //Item Number
    $ItemDesc = $_SESSION['ItemDesc']; //Item Number
    $ItemQty = $_SESSION['ItemQty']; // Item Quantity
    $ItemTotalPrice = $_SESSION['ItemTotalPrice']; //(Item Price x Quantity = Total) Get total amount of product;
    $TotalTaxAmount = $_SESSION['TotalTaxAmount'];  //Sum of tax for all items in this order.
 
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
            /*
              //Additional products (L_PAYMENTREQUEST_0_NAME0 becomes L_PAYMENTREQUEST_0_NAME1 and so on)
              '&L_PAYMENTREQUEST_0_NAME1='.urlencode($ItemName2).
              '&L_PAYMENTREQUEST_0_NUMBER1='.urlencode($ItemNumber2).
              '&L_PAYMENTREQUEST_0_DESC1=Description text'.
              '&L_PAYMENTREQUEST_0_AMT1='.urlencode($ItemPrice2).
              '&L_PAYMENTREQUEST_0_QTY1='. urlencode($ItemQty2).
             */

            '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
            '&PAYMENTREQUEST_0_TAXAMT=' . urlencode($TotalTaxAmount) .
    
            '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
 
            '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
            '&SOLUTIONTYPE=Sole&LANDINGPAGE=Billing'    
            ;
    
    
    

    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
    $paypal = new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

    //Check if everything went ok..
    if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

        echo '<h2>Success</h2>';
        echo 'Your Transaction ID : ' . urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);

        /*
          //Sometimes Payment are kept pending even when transaction is complete.
          //hence we need to notify user about it and ask him manually approve the transiction
         */

        if ('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
            echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
        } elseif ('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
            echo '<div style="color:red">Transaction Complete, but payment is still pending! ' .
            'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
        }

        // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
        // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
        $padata = '&TOKEN=' . urlencode($token);
        $paypal = new MyPayPal();
        $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

            echo '<br /><b>Stuff to store in database :</b><br /><pre>';
            /*
              #### SAVE BUYER INFORMATION IN DATABASE ###
              //see (http://www.sanwebe.com/2013/03/basic-php-mysqli-usage) for mysqli usage

              $buyerName = $httpParsedResponseAr["FIRSTNAME"].' '.$httpParsedResponseAr["LASTNAME"];
              $buyerEmail = $httpParsedResponseAr["EMAIL"];

              //Open a new connection to the MySQL server
              $mysqli = new mysqli('host','username','password','database_name');

              //Output any connection error
              if ($mysqli->connect_error) {
              die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
              }

              $insert_row = $mysqli->query("INSERT INTO BuyerTable
              (BuyerName,BuyerEmail,TransactionID,ItemName,ItemNumber, ItemAmount,ItemQTY)
              VALUES ('$buyerName','$buyerEmail','$transactionID','$ItemName',$ItemNumber, $ItemTotalPrice,$ItemQTY)");

              if($insert_row){
              print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />';
              }else{
              die('Error : ('. $mysqli->errno .') '. $mysqli->error);
              }

             */

            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        } else {
            echo '<div style="color:red"><b>GetTransactionDetails failed:</b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        }
    } else {
        echo '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
        echo '<pre>';
        print_r($httpParsedResponseAr);
        echo '</pre>';
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

        //improve for check

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
        $sql = "SELECT
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
                    WHERE sc_single_car.single_car_id NOT IN
                    (
                    SELECT single_car_id FROM sc_single_car_status WHERE
                    '$car_dto_string' >= date_from AND date_to >= '$car_dfrom_string'
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
                    GROUP BY posts.ID";
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
        include dirname( __FILE__ ) . '/paypal_checkout.php';   
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