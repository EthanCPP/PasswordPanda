<?php
define('API', 1);
require './../globals.php';

$error = '';

if (isset($_POST['i_email']) && isset($_POST['i_password'])) {
    $email = addslashes($_POST['i_email']);

    $getAccountQ = $panda->db->prepare("SELECT * FROM `accounts` WHERE `Email`='$email'");
    $getAccountQ->execute();

    $account = $getAccountQ->fetch(PDO::FETCH_ASSOC);

    if ($account != null) {
        $salt = $account['Salt'];

        $password = hash('sha512', $salt . $_POST['i_password'] . $salt);

        if ($account['Password'] === $password) {
            $_SESSION['UID'] = $account['ID'];
            $_SESSION['SessionToken'] = $account['SessionToken'];

            setcookie('PHPSESSID', $_COOKIE['PHPSESSID'], time() + (30 * 24 * 60 * 60), "/");

            echo json_encode(array(
                'Result' => 'Success'
            ));

            die;
        } else $error = 'Email/password incorrect.';
    } else $error = 'Email/password incorrect.';
} else $error = 'You must provide an email and password.';

echo json_encode(array(
    'Result' => 'Error',
    'Message' => $error
));

die;