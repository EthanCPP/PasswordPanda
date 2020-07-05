<?php
define('API', 1);
require './../globals.php';

$error = '';

if ($panda->loggedIn) {

    // well.. goodbye! :(
        
    $uid = $panda->user['ID'];

    $deletePasswordsQ = $panda->db->prepare("DELETE FROM `passwords` WHERE `AccountID`='$uid'");
    $deletePasswordsQ->execute();

    $deleteAccountQ = $panda->db->prepare("DELETE FROM `accounts` WHERE `ID`='$uid'");
    $deleteAccountQ->execute();

    echo json_encode(array(
        'Result' => 'Success'
    ));

    die;

}