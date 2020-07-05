<?php
require 'globals.php';

if ($panda->loggedIn) {
    header('location: vault/');
    die;
} else {
    header('location: account/login.php');
    die;
}