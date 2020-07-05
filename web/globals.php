<?php
session_start();

define('ROOT', '/Panda/web');
define('DOCROOT', $_SERVER['DOCUMENT_ROOT'] . ROOT);

require DOCROOT . '/bootstrap.php';

$panda->checkLoggedIn();

if (!isset($_GET['sessdata']) && !defined('API')) {
    // force clear cache
    if (count($_GET) == 0) {
        header('location: ' . $_SERVER['REQUEST_URI'] . '?sessdata=' . hash('sha1', rand() . rand()));
    } else {
        header('location: ' . $_SERVER['REQUEST_URI'] . '&sessdata=' . hash('sha1', rand() . rand()));
    }
    die;
}

// api
if (defined('API')) {
    $allow = false;

    if (defined('API_ALLOW'))
        $allow = true;
    else {
        if (isset($_GET['api_public'])) {
            if ($_GET['api_public'] === getenv('API_PUBLIC_KEY')) {
                $allow = true;
            }
        } else {
            if (strpos($_SERVER['HTTP_REFERER'], getenv('BASE_URL')) !== false)
                $allow = true;
        }
    }

    if (!$allow) 
        die;
}