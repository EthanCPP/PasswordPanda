<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!defined('DOCROOT'))
    die;

class Panda {
    public $db;
    public $loggedIn;
    public $user;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkLoggedIn() {
        if (isset($_SESSION['UID']) && isset($_SESSION['SessionToken'])) {
            $uid = addslashes($_SESSION['UID']);
            $sessionToken = addslashes($_SESSION['SessionToken']);
        
            $retrieveAccountQ = $this->db->prepare("SELECT * FROM `accounts` WHERE `ID`='$uid' AND `SessionToken`='$sessionToken'");
            $retrieveAccountQ->execute();
            $account = $retrieveAccountQ->fetch(PDO::FETCH_ASSOC);
        
            if ($account == null)
                session_destroy();
            else {
                $this->loggedIn = true;
                $this->user = $account;

                return true;
            }
        }

        return false;
    }

    public function encode($string) {
        $encrypt_method = getenv('CIPHER');
        $key = hash('sha512', getenv('SECRET_KEY'));
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($encrypt_method));
    
        $encrypted = openssl_encrypt($string, $encrypt_method, $key, 0, $iv, $tag);
    
        return array(
            'encoded_string' => $encrypted,
            'iv'             => $iv,
            'tag'            => $tag
        );
    }

    public function decode($string, $iv, $tag) {
        $encrypt_method = getenv('CIPHER');
        $key = hash('sha512', getenv('SECRET_KEY'));
        return openssl_decrypt($string, $encrypt_method, $key, 0, $iv, $tag);
    }

    public function lockdown() {
        if (!$this->loggedIn)
            die;
    }

    public function errorHolder($class_appends = '') {
        echo '<div class="panda-error-holder' . $class_appends . '"></div>';
    }

    public function message($type, $message) {
        ?>
        <div class="alert alert-<?php echo $type; ?> my-4">
            <span><?php echo $message; ?></span>
        </div>
        <?php
    }
    
    public function error($message) {
        ?>
        <div class="alert alert-danger my-4">
            <span><?php echo $message; ?></span>
        </div>
        <?php
    }

    public function form() {
        echo '<input hidden name="i_root" value="' . ROOT . '" />';
    }

    public function sendEmail($toEmail, $subject, $body, $firstName = '') {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = getenv('EMAIL_DEBUG');
            $mail->isSMTP();
            $mail->Host = getenv('EMAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('EMAIL_USERNAME');
            $mail->Password = getenv('EMAIL_PASSWORD');
            $mail->SMTPSecure = getenv('EMAIL_SECURE');
            $mail->Port = getenv('EMAIL_PORT');

            $mail->setFrom(getenv('EMAIL_USERNAME'), 'Panda Password');
            $mail->addAddress($toEmail, $firstName);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
         
            return 'Success';

        } catch (Exception $e) {
            $error = $mail->ErrorInfo;

            return $error;
        }
    }
}