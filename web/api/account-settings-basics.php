<?php
define('API', 1);
require './../globals.php';

$error = '';

if ($panda->loggedIn) {
    $firstName = '';
    $lastName = '';

    if (isset($_POST['i_firstName'])) {
        $firstName = addslashes(htmlspecialchars($_POST['i_firstName']));

        if (strlen($firstName) > 20) {
            $error = 'First name must be less than 20 characters';
        }
    }

    if (isset($_POST['i_lastName'])) {
        $lastName = addslashes(htmlspecialchars($_POST['i_lastName']));

        if (strlen($lastName) > 20) {
            $error = 'Last name must be less than 20 characters';
        }
    }

    if ($error == '') {
        $uid = $panda->user['ID'];

        $updateQ = $panda->db->prepare("UPDATE `accounts` SET `FirstName`='$firstName', `LastName`='$lastName' WHERE `ID`='$uid'");
        $updateQ->execute();

        echo json_encode(array(
            'Result' => 'Success'
        ));
    
        die;
    }

} else $error = 'You must be logged in.';

echo json_encode(array(
    'Result' => 'Error',
    'Message' => $error
));

die;