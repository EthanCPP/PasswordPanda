<?php

define('API', 1);
require './../globals.php';

$error = '';

if (isset($_POST['i_email'])) {
    $email = addslashes($_POST['i_email']);
    
    // check email is registered
    $checkEmailQ = $panda->db->prepare("SELECT * FROM `accounts` WHERE `Email`='$email'");
    $checkEmailQ->execute();
    $account = $checkEmailQ->fetch(PDO::FETCH_ASSOC);

    if ($account != null) {

        // create an email key
        $forgotKey = hash('sha1', rand() . rand());

        // set the key
        $accountId = $account['ID'];
        $setKeyQ = $panda->db->prepare("UPDATE `accounts` SET `ForgotKey`='$forgotKey' WHERE `ID`='$accountId'");
        $setKeyQ->execute();

        $emailSubject = 'Your request to retrieve your Panda account';
        $emailBody = 'Please go here to retrieve your Panda account: ' . getenv('BASE_URL') . '/account/reset.php?activation=' . $forgotKey;

        $emailResponse = $panda->sendEmail($email, $emailSubject, $emailBody, $account['FirstName']);

        if ($emailResponse == 'Success') {
            echo json_encode(array(
                'Result' => 'Success',
            ));
            
            die;
        } else $error = $emailResponse;
    } else $error = 'Email is not registered with us.';

} else $error = 'Please fill in all fields.';


echo json_encode(array(
    'Result' => 'Error',
    'Message' => $error
));

die;