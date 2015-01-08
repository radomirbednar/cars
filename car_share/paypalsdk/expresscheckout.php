<?php

require_once ("paypalfunctions.php");
// ==================================
// Payflow Express Checkout Module
// ==================================

//'------------------------------------
//' The paymentAmount is the total value of 
//' the shopping cart, that was set 
//' earlier in a session variable 
//' by the shopping cart page
//'------------------------------------
$paymentAmount = $_SESSION["Payment_Amount"];

//'------------------------------------
//' The currencyCodeType and paymentType 
//' are set to the selections made on the Integration Assistant 
//'------------------------------------
$currencyCodeType = "USD";
$paymentType = "Sale";

//'------------------------------------
//' The returnURL is the location where buyers return to when a
//' payment has been succesfully authorized.
//'
//' This is set to the value entered on the Integration Assistant 
//'------------------------------------
$returnURL = "test";

//'------------------------------------
//' The cancelURL is the location buyers are sent to when they hit the
//' cancel button during authorization of payment during the PayPal flow
//'
//' This is set to the value entered on the Integration Assistant 
//'------------------------------------
$cancelURL = "test";

//'------------------------------------
//' Calls SetExpressCheckout
//'
//' The CallShortcutExpressCheckout function is defined in the file PayPalFunctions.php,
//' it is included at the top of this file.
//'-------------------------------------------------
$resArray = CallShortcutExpressCheckout ($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL);
$ack = strtoupper($resArray["RESULT"]);
if($ack=="0")
{
	RedirectToPayPal ( $resArray["TOKEN"] );
} 
else  
{
	// See Table 4.2 and 4.3 in http://www.paypal.com/en_US/pdf/PayflowPro_Guide.pdf for a list of RESULT values (error codes)
	//Display a user friendly Error on the page using any of the following error information returned by Payflow
	$ErrorCode = $ack;
	$ErrorMsg = $resArray["RESPMSG"];

	echo "SetExpressCheckoutDetails API call failed. ";
	echo "Error Message: " . $ErrorMsg;
	echo "Error Code: " . $ErrorCode;
}
?>