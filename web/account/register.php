<?php
$scripts = array(
    'account/register.js'
);

require './../globals.php';
require './../header.php';
?>
<div class="container">
    <?php
    $panda->errorHolder();
    ?>
    <form action="" method="post" id="register-form">
        <?php
        $panda->form();
        ?>
        <label for="i_email" class="mt-3 mb-0">Email address:</label>
        <input type="text" id="i_email" name="i_email" class="form-control" />
        <label for="i_password" class="mt-3 mb-0">Password:</label>
        <input type="password" id="i_password" name="i_password" class="form-control" />
        <label for="i_cpassword" class="mt-3 mb-0">Retype password:</label>
        <input type="password" id="i_cpassword" name="i_cpassword" class="form-control" />
        <input type="submit" class="btn btn-success mt-3" value="Create Account" />
    </form>
</div>
