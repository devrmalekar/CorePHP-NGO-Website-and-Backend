<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/27/15
 * Time: 12:34 PM
 */


require $_SERVER['DOCUMENT_ROOT'].'/Controller/PayPal-PHP-SDK/autoload.php';
//require($_SERVER['DOCUMENT_ROOT'] . '/Controller/PayPal-PHP-SDK/paypal/rest-api-sdk-php/sample/common.php');
require($_SERVER['DOCUMENT_ROOT'].'/Controller/bootstrap.php');

use PayPal\Api\Amount;
use PayPal\Api\Address;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\PaymentExecution;

if(!class_exists("dbFunction")){ include_once($_SERVER['DOCUMENT_ROOT'] . "/Controller/dbFunction.php"); }

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $invoiceNumber = uniqid();
    $donateAmt = filter_input(INPUT_POST, "donateAmt");

    if(filter_input(INPUT_POST,"donate") == "donate with paypal"){
         $payer=new Payer();
         $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName("Donation")
            ->setDescription("Donate For Children")
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($donateAmt);

        $itemList = new ItemList();
        $itemList->setItems(array($item));

        $amountDetails = new Details();
        $amountDetails->setSubtotal($donateAmt);

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($donateAmt)
            ->setDetails($amountDetails);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Thank You for your donation')
            ->setItemList($itemList)
            ->setInvoiceNumber($invoiceNumber);

         $baseUrl = getBaseUrl();
         $redirectUrls = new RedirectUrls();
         $redirectUrls->setReturnUrl($baseUrl."/paypal.php?success=true&invoice=".$invoiceNumber);
         $redirectUrls->setCancelUrl($baseUrl."/paypal.php?cancel=true");

         $payment = new Payment();
         $payment->setIntent("sale");
         $payment->setPayer($payer);
         $payment->setRedirectUrls($redirectUrls);
         $payment->setTransactions(array($transaction));

        try {
            $response = json_decode($payment->create($apiContext));

            header("location:".$response->links[1]->href);
        } catch (Exception $ex) {
            //ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://ppmts.custhelp.com/app/answers/detail/a_id/750">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
            exit(1);
        }



     } else if(filter_input(INPUT_POST,"donate") == "donate") {
        $line1 = filter_input(INPUT_POST, "saddr");
        $city = filter_input(INPUT_POST, "city");
        $state = filter_input(INPUT_POST, "state");
        $countryCode = filter_input(INPUT_POST, "country");
        $postalcode = filter_input(INPUT_POST, "postalcode");

        $fname = filter_input(INPUT_POST, "fname");
        $lname = filter_input(INPUT_POST, "lname");
        $email = filter_input(INPUT_POST, "email");

        $cardNumber = filter_input(INPUT_POST, "number");
        $cvv2 = filter_input(INPUT_POST, "Cvv2");
        $expireYear = filter_input(INPUT_POST, "ExpireYear");
        $expireMonth = filter_input(INPUT_POST, "ExpireMonth");
        $cardType = filter_input(INPUT_POST, "cardType");

        $addr = new Address();
        $addr->setLine1($line1)
            ->setCity($city)
            ->setCountryCode($countryCode)
            ->setPostalCode($postalcode)
            ->setState($state);

        $creditCard = new CreditCard();
        $creditCard->setType($cardType)
            ->setNumber($cardNumber)
            ->setExpireMonth($expireMonth)
            ->setExpireYear($expireYear)
            ->setCvv2($cvv2)
            ->setFirstName($fname)
            ->setLastName($lname)
            ->setBillingAddress($addr);

        $fi = new FundingInstrument();
        $fi->setCreditCard($creditCard);

        $payer = new Payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($donateAmt);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setInvoiceNumber($invoiceNumber)
            ->setDescription("Thank You for your donation");

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction));
        $request = clone $payment;
        try {
            $payment->create($apiContext);
            $paramVal=array($donateAmt, $invoiceNumber, $payment->transactions[0]->related_resources[0]->sale->id, $fname, $lname, $line1, $city, $state, $postalcode, $countryCode, $email);
            NewDonation($paramVal);

        } catch (Exception $ex) {
           // ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://ppmts.custhelp.com/app/answers/detail/a_id/750">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
            exit(1);
        }

    }
} else if($_SERVER["REQUEST_METHOD"]=="GET") {
    $success=filter_input(INPUT_GET,"success");
    $cancel=filter_input(INPUT_GET,"cancel");
    $invoiceNumber =filter_input(INPUT_GET,"invoice");

    if(isset($success) && $success=="true"){
        $paymentId = filter_input(INPUT_GET, "paymentId");
        $payerId = filter_input(INPUT_GET, "PayerID");

        $payment=new Payment();
        $payment->setId($paymentId);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $payment->execute($execution, $apiContext);
        /*for database integration*/
        $response=json_decode($payment);
        $transactions =$response->transactions[0];
       $transaction_id = $response->transactions[0]->related_resources[0]->sale->id;
       $fname  = $response->payer->payer_info->first_name;
       $lname  = $response->payer->payer_info->last_name;
       $saddr  = $response->payer->payer_info->shipping_address->line1;
       $city  = $response->payer->payer_info->shipping_address->city;
       $state  = $response->payer->payer_info->shipping_address->state;
       $postal_code  = $response->payer->payer_info->shipping_address->postal_code;
       $countryCode  = $response->payer->payer_info->shipping_address->country_code;
       $email  = $response->payer->payer_info->email;
       $time  = $response->create_time;
        $donateAmt=$response->transactions[0]->amount->total;
        $paramVal=array($donateAmt, $invoiceNumber, $transaction_id, $fname, $lname, $saddr, $city, $state, $postal_code, $countryCode, $email);
        NewDonation($paramVal);
    } else if(isset($cancel) && $cancel="true"){

    }
} else {
    header("location:".getBaseUrl());
}


function NewDonation($paramVal){
    $dbFunction = new dbFunction();
    $paramName= array('donateAmt' ,'invoice', 'trasaction_id', 'payer_fname', 'payer_lname',
        'payer_address', 'payer_city', 'payer_state', 'payer_zip', 'payer_country', 'payer_email',
        'payment_status');
    $dbFunction->Insert("SP_NewDonation", $paramName, $paramVal);
    header("location:".getBaseUrl()."/thankyou.php");
}


/*function getBaseUrl()
{
    if (PHP_SAPI == 'cli') {
        $trace=debug_backtrace();
        $relativePath = substr(dirname($trace[0]['file']), strlen(dirname(dirname(__FILE__))));
        echo "Warning: This sample may require a server to handle return URL. Cannot execute in command line. Defaulting URL to http://localhost$relativePath \n";
        return "http://localhost" . $relativePath;
    }
    $protocol = 'http';
    if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
        $protocol .= 's';
    }
    $host = $_SERVER['HTTP_HOST'];
    $request = $_SERVER['PHP_SELF'];
    return dirname($protocol . '://' . $host . $request);
}*/