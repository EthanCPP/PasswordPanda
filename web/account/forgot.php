<?php
$scripts = array(
    'account/forgot.js'
);

require './../globals.php';
require './../header.php';
?>
<div class="container">
    <?php
    $panda->errorHolder();

    if (isset($_GET['sent'])) {
        $panda->message('success', 'An email reminder has been sent.');
    }
    ?>
    <form action="" method="post" id="forgot-form">
        <?php
        $panda->form();
        ?>
        <label for="i_email" class="mt-3 mb-0">Email address:</label>
        <input type="text" id="i_email" name="i_email" class="form-control" />
        <input type="submit" class="btn btn-success mt-3" value="Send email" />
    </form>
</div>