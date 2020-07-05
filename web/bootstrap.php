<?php
if (!defined('DOCROOT')) 
    die;

require DOCROOT . '/vendor/autoload.php';
require DOCROOT . '/panda.php';

// load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . './../');
$dotenv->load();

// attempt a database connection
try {
    $db = new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
} catch (PDOException $e) {
    if (getenv('production') == "false") {
        echo "Error connecting to database: " . $e->getMessage();
        die;
    } else {
        die("Unexpected error.");
    }
}

$panda = new Panda($db);