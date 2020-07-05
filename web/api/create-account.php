<?php
define('API', 1);
require './../globals.php';

$error = '';

if (isset($_POST['i_email']) && isset($_POST['i_password']) && isset($_POST['i_cpassword'])) {
    $email = addslashes($_POST['i_email']);
    
    if ($_POST['i_password'] === $_POST['i_cpassword']) {
        if (strlen($_POST['i_password']) > 6) {
            $salt = hash("sha1", rand() . rand());
            $password = hash("sha512", $salt . $_POST['i_password'] . $salt);

            $checkEmailQ = $panda->db->prepare("SELECT * FROM `accounts` WHERE `Email`='$email'");
            $checkEmailQ->execute();

            if ($checkEmailQ->rowCount() == 0) {
                $sessionToken = hash('sha1', rand() . rand());
                $apiSecret = base64_encode(hash('sha1', rand() . rand()));

                $verificationKey = hash('sha1', rand() . rand());

                $createAccountQ = $panda->db->prepare("INSERT INTO `accounts` (`Email`, `Password`, `Salt`, `SessionToken`, `ApiSecret`, `EmailVerified`, `VerificationKey`) VALUES ('$email', '$password', '$salt', '$sessionToken', '$apiSecret', '0', '$verificationKey')");
                $createAccountQ->execute();

                $retrieveAccountQ = $panda->db->prepare("SELECT * FROM `accounts` WHERE `Email`='$email'");
                $retrieveAccountQ->execute();
                $account = $retrieveAccountQ->fetch(PDO::FETCH_ASSOC);

                $_SESSION['UID'] = $account['ID'];
                $_SESSION['SessionToken'] = $sessionToken;

                $emailSubject = 'Please verify your Panda account';
                $emailBody = 'Please go here to verify your Panda account: ' . getenv('BASE_URL') . '/account/verify.php?activation=' . $verificationKey;

                $emailResponse = $panda->sendEmail($email, $emailSubject, $emailBody, $account['FirstName']);
        
                if ($emailResponse == 'Success') {

                    echo json_encode(array(
                        'Result' => 'Success',
                        'UID' => $account['ID'],
                        'SessionToken' => $sessionToken
                    ));

                    die;
                    
                } else $error = $emailResponse;
            } else $error = 'Email is already registered.';
        } else $error = 'Password must be at least 6 characters long.';
    } else $error = 'Password and confirm password do not match.';
} else $error = 'Please fill in all fields.';


echo json_encode(array(
    'Result' => 'Error',
    'Message' => $error
));

die;