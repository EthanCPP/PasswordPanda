<?php
define('API', 1);
require './../globals.php';

if ($panda->loggedIn) {
    $uid = $panda->user['ID'];
    $apiKey = $panda->user['ApiSecret'];

    $passwordsQ = $panda->db->prepare("SELECT * FROM `passwords` WHERE `AccountID`='$uid' ORDER BY `SiteName`");
    $passwordsQ->execute();

    $password_data = array();

    if ($passwordsQ->rowCount() > 0) {
        while ($password_item = $passwordsQ->fetch(PDO::FETCH_ASSOC)) {
            $password_item_data = array();
            $password_item_data['SiteName'] = base64_encode(openssl_encrypt($password_item['SiteName'], 'aes-128-ecb', $apiKey));
            $password_item_data['SiteUrl'] = base64_encode(openssl_encrypt($password_item['SiteUrl'], 'aes-128-ecb', $apiKey));
            $password_item_data['Password'] = base64_encode(openssl_encrypt($panda->decode(base64_decode($password_item['Password']), base64_decode($password_item['EncIv']), base64_decode($password_item['EncTag'])), 'aes-128-ecb', $apiKey));
            $password_item_data['Identifier1'] = base64_encode(openssl_encrypt($password_item['Identifier1'], 'aes-128-ecb', $apiKey));
            $password_item_data['Identifier1String'] = base64_encode(openssl_encrypt($password_item['Identifier1String'], 'aes-128-ecb', $apiKey));
            $password_item_data['Identifier2'] = base64_encode(openssl_encrypt($password_item['Identifier2'], 'aes-128-ecb', $apiKey));
            $password_item_data['Identifier2String'] = base64_encode(openssl_encrypt($password_item['Identifier2String'], 'aes-128-ecb', $apiKey));
            $password_item_data['Comments'] = base64_encode(openssl_encrypt($password_item['Comments'], 'aes-128-ecb', $apiKey));

            // echo openssl_decrypt(base64_decode($password_item_data['Password']), 'aes-128-ecb', $apiKey);
            // echo "<br><br>";

            $password_data[] = $password_item_data;
        }
    }

    echo json_encode($password_data);

    die;
}