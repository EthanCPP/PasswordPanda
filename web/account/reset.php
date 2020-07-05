<?php
$scripts = array(
    'account/reset.js'
);

require './../globals.php';
require './../header.php';

if (isset($_GET['activation'])) {
    $key = addslashes($_GET['activation']);

    $checkKeyQ = $panda->db->prepare("SELECT * FROM `accounts` WHERE `ForgotKey`='$key'");
    $checkKeyQ->execute();
    $account = $checkKeyQ->fetch(PDO::FETCH_ASSOC);

    if ($account != null) {

        ?>
        <div class="container">
            <?php
            $panda->errorHolder();
            ?>
            <form action="" method="post" id="reset-form">
                <?php
                $panda->form();
                ?>
                <input hidden type="text" name="i_key" value="<?php echo $key; ?>" />
                <label for="i_email" class="mt-3 mb-0">Email address:</label>
                <input type="text" disabled id="i_email" name="i_email" value="<?php echo $account['Email']; ?>" class="form-control" />
                <label for="i_password" class="mt-3 mb-0">New password:</label>
                <input type="password" id="i_password" name="i_password" class="form-control" />
                <label for="i_cpassword" class="mt-3 mb-0">Retype password:</label>
                <input type="password" id="i_cpassword" name="i_cpassword" class="form-control" />
                <input type="submit" class="btn btn-success mt-3" value="Change password" />
            </form>
        </div>
        <?php
        
    } else die;
} else die;