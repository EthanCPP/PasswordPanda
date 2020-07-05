<?php
define('API', 1);
require './../globals.php';

$error = '';

if (isset($_POST['i_key']) && isset($_POST['i_password']) && isset($_POST['i_cpassword'])) {
    $key = addslashes($_POST['i_key']);

    $checkKeyQ = $panda->db->prepare("SELECT * FROM `accounts` WHERE `ForgotKey`='$key'");
    $checkKeyQ->execute();
    $account = $checkKeyQ->fetch(PDO::FETCH_ASSOC);

    if ($account != null) {

        if (strlen($_POST['i_password']) >= 6) {

            if ($_POST['i_password'] == $_POST['i_cpassword']) {

                $salt = $account['Salt'];
                $password = hash('sha512', $salt . $_POST['i_password'] . $salt);

                $accountId = $account['ID'];
                $updateQ = $panda->db->prepare("UPDATE `accounts` SET `Password`='$password', `Forgotkey`='' WHERE `ID`='$accountId'");
                $updateQ->execute();

                echo json_encode(array(
                    'Result' => 'Success',
                ));
                
                die;

            } else $error = 'Passwords do not match.';

        } else $error = 'Password must be at least 6 characters long.';

    } else $error = 'Invalid reset key.';
} else $error = 'Please enter all fields.';

echo json_encode(array(
    'Result' => 'Error',
    'Message' => $error
));

die;