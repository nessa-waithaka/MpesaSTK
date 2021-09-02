<?php

if (isset($_POST['submit'])){
    date_default_timezone_set('Africa/Nairobi');
    
    #Access token
    $consumerKey='RJ0r3s67pGo7cfsO9e8cXm52tXc82xba';
    $consumerSecret='qzaGoUUWzfwV7Db7';
    
    #Variables defined
    $Amount = $_POST['1'];
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    
    $PartyA = $_POST['0725306832']; #Put in your phone number here
    $AccountReference = $_POST['phone'];
    $TransactionDesc = 'testapi';
    
    #Timestamp , format YYYYmmddhhmm -> 202108290900
    $Timestamp = date('YmdHi'); 
    
    #Get the pass key(MPESA Public key) in base64 encoded String
    $Password = base64_decode($BusinessShortCode, $Passkey.$Timestamp);
    
    $headers = ['Content-Type:application/json; charset=utf8'];
    
    #MPESA End point URLs
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials ';
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest ';
    
    $CallBackURL = 'https://9dc0e41f-eb65-4566-83a0-8a3d34134b63.mock.pstmn.io'; //This may need a 
    
    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    $access_token = $result->access_token;
    curl_close($curl);
    
    $stkheader = ['Content-Type:application/json','Authorization:Bearer '. $access_token];
    
    #Checks Phone Number
    $phone = (substr($phone, 0, 1) == "+") ? str_replace("+", "", $phone) : $phone;
    $phone = (substr($phone, 0, 1) == "0") ? preg_replace("/^0/", "254", $phone) : $phone;
    $phone = (substr($phone, 0, 1) == "7") ? "254{$phone}" : $phone;
    
    #Initiating the transaction
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURL_HTTPHEADER, $stkheader);
    
    $curl_post_data = array(
        'BusinessShortCode' =>  $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransacDesc' => $TransactionDesc
    );
    
    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURL_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    print_r($curl_response);
    
    echo $curl_response;
    
    $response = $configuration->remote_post($endpoint, $curl_post_data);
    $result   = json_decode($response, true);


    if ($result['ResponseCode'] && $result['ResponseCode'] == 0) 
    {
        $_SESSION['MerchantRequestID'] = $result['MerchantRequestID'];
        $_SESSION['CheckoutRequestID'] = $result['CheckoutRequestID'];
        $_SESSION['Amount'] = $amount;

        header("location: ../confirm-payment.php");
    } 
    elseif ($result['errorCode'] && $result['errorCode'] == '500.001.1001') {
        $errors = "Error! A transaction is already in progress for the current phone number";
        header("location: ../error.php?error=" . $errors . "");
    } 
    elseif ($result['errorCode'] && $result['errorCode'] ==  '400.002.02') {
        $errors = "Error! Invalid Request";
        header("location: ../error.php?error=" . $errors . "");
    }
    else 
    {
        $errors = "Error! Unable to make MPESA STK Push request.";
        header("location: ../error.php?error=" . $errors . "");
    } 
}
?>