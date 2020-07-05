<?php
define('API', 1);
require './../globals.php';

$error = '';

if ($panda->loggedIn) {
    if (isset($_POST['i_currentPassword']) && isset($_POST['i_newPassword']) && isset($_POST['i_retypePassword'])) {
        if (hash('sha512', $panda->user['Salt'] . $_POST['i_currentPassword'] . $panda->user['Salt']) === $panda->user['Password']) {
            if ($_POST['i_newPassword'] == $_POST['i_retypePassword']) {
                if (strlen($_POST['i_newPassword']) > 6) {
                    $newPassword = hash('sha512', $panda->user['Salt'] . $_POST['i_newPassword'] . $panda->user['Salt']);
                    $uid = $panda->user['ID'];

                    $updateQ = $panda->db->prepare("UPDATE `accounts` SET `Password`='$newPassword' WHERE `ID`='$uid'");
                    $updateQ->execute();

                    echo json_encode(array(
                        'Result' => 'Success'
                    ));
                
                    die;
                } else $error = 'New password must be at least 7 characters long.';
            } else $error = 'New password does not match retype password.';
        } else $error = 'Current password is incorrect.';
    } else $error = 'Please fill in all fields.';

    echo json_encode(array(
        'Result' => 'Error',
        'Message' => $error
    ));

    die;
}