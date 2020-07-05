<?php
if (!defined('DOCROOT'))
    die;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Panda</title>
        <script src="<?php echo ROOT; ?>/assets/lib/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="<?php echo ROOT; ?>/node_modules/clipboard/dist/clipboard.min.js"></script>
        <?php
        if (isset($scripts)) {
            foreach ($scripts as $script) {
                ?>
                <script src="<?php echo ROOT; ?>/assets/scripts/<?php echo $script; ?>" type="text/javascript"></script>
                <?php
            }
        }
        ?>
        <link href="<?php echo ROOT; ?>/dist/main.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <header class="main-navigation">
            <div class="container h-100">
                <a href="<?php echo ROOT; ?>" class="nav-logo">
                    <img src="<?php echo ROOT; ?>/assets/images/panda_logo.png" />
                </a>

                <div class="nav-links">
                    <?php
                    if ($panda->loggedIn) {
                        ?>
                        <a href="<?php echo ROOT; ?>/vault" class="nav-link">Vault</a>
                        <a href="<?php echo ROOT; ?>/account/settings.php" class="nav-link"><?php echo $panda->user['FirstName'] == '' ? 'Account' : $panda->user['FirstName']; ?></a>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo ROOT; ?>/account/login.php" class="nav-link">Login</a>
                        <a href="<?php echo ROOT; ?>/account/register.php" class="nav-link">Register</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </header>