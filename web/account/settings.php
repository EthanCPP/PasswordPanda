<?php
$scripts = array(
    'account/settings.js'
);

require './../globals.php';
require './../header.php';

$panda->lockdown();
?>
<div class="container account-settings">
    <?php
    if (isset($_GET['password-success'])) {
        ?>
        <div class="alert alert-success">Your password has been changed.</div>
        <?php
    }
    
    if (isset($_GET['basics-success'])) {
        ?>
        <div class="alert alert-success">Your basic info has been changed.</div>
        <?php
    }
    ?>
    <a href="logout.php" class="btn btn-secondary mt-2 float-right">Logout</a>
    <h1>Account settings</h1>

    <h3>About you</h3>
    <?php
    $panda->errorHolder('-basics');
    ?>
    <form action="" method="post" id="settings-basics-form">
        <?php
        $panda->form();
        ?>
        <label for="i_firstName" class="mt-3 mb-0">First name</label>
        <input type="text" name="i_firstName" id="i_firstName" class="form-control" value="<?php echo $panda->user['FirstName']; ?>" />
        
        <label for="i_lastName" class="mt-3 mb-0">Last name</label>
        <input type="text" name="i_lastName" id="i_lastName" class="form-control" value="<?php echo $panda->user['LastName']; ?>" />

        <input type="submit" class="btn btn-primary mt-3" value="Save changes" />
    </form>

    <hr class="my-5" />

    <h3>Change password</h3>
    <?php
    $panda->errorHolder('-password');
    ?>
    <form action="" method="post" id="settings-password-form">
        <?php
        $panda->form();
        ?>
        <label for="i_currentPassword" class="mt-3 mb-0">Current password</label>
        <input type="password" name="i_currentPassword" id="i_currentPassword" class="form-control" />
        
        <label for="i_newPassword" class="mt-3 mb-0">New password</label>
        <input type="password" name="i_newPassword" id="i_newPassword" class="form-control" />
        
        <label for="i_retypePassword" class="mt-3 mb-0">Retype new password</label>
        <input type="password" name="i_retypePassword" id="i_retypePassword" class="form-control" />

        <input type="submit" class="btn btn-primary mt-3" value="Save changes" />
    </form>

    <hr class="my-5" />

    <h3>Danger zone</h3>
    <form action="" method="post" id="settings-delete-form" class="mb-5">
        <?php
        $panda->form();
        ?>
        <pre class="my-3">Your data will be lost forever.</pre>
        <input type="submit" class="btn btn-danger" value="Delete account and all associated data" />
    </form>
</div>