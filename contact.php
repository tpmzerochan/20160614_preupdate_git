<?php

// configure
$from = 'Enquiry form <cs@tablepm.com>'; 
$sendTo = 'Enquiry form <cs@tablepm.com>';
$subject = 'New message from Table Plus Medis Website Enquiry';
$fields = array('company' => 'Company', 'name' => 'Name', 'tel' => 'Tel'); // array variable name => Text to appear in email
$okMessage = '你的信息已成功送出，謝謝你!我們會盡快回覆你!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

// let's do the sending

try
{
    $emailText = "You have new message from enquiry\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    mail($sendTo, $subject, $emailText, "From: " . $from);

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}
