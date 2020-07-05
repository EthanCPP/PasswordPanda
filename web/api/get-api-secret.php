<?php
define('API', 1);
require './../globals.php';

$error = '';

if ($panda->loggedIn) {
    $uid = $panda->user['ID'];

    $getAccountQ = $panda->db->prepare("SELECT * FROM `accounts` WHERE `ID`='$uid'");
    $getAccountQ->execute();

    $account = $getAccountQ->fetch(PDO::FETCH_ASSOC);

    if ($account != null) {
        $secret = base64_encode(openssl_encrypt($account['ApiSecret'], 'aes-128-ecb', getenv('API_RETRIEVE_KEY')));

        // echo openssl_decrypt(base64_decode($test), 'aes-128-ecb', getenv('API_RETRIEVE_KEY'));

        echo json_encode(array(
            'Result' => 'Success',
            'Data' => $secret
        ));
        
        die;
    } else $error = 'Unexpected error occurred.';
} else $error = 'You must be logged in.';

echo json_encode(array(
    'Result' => 'Error',
    'Message' => $error
));

die;
?>