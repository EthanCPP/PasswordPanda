<?php
require './../globals.php';

if (isset($_GET['activation'])) {
    $verifyKey = addslashes($_GET['activation']);
    $checkKeyQ = $panda->db->prepare("SELECT * FROM `accounts` WHERE `VerificationKey`='$verifyKey'");
    $checkKeyQ->execute();
    $account = $checkKeyQ->fetch(PDO::FETCH_ASSOC);

    if ($account != null) {

        $accountId = $account['ID'];
        $updateQ = $panda->db->prepare("UPDATE `accounts` SET `VerificationKey`='', `EmailVerified`='1' WHERE `ID`='$accountId'");
        $updateQ->execute();

        header('location: ../vault/?verified=1');
        die();

    } else die;
} else die;