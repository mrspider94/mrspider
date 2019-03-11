<?php 
// connect to database
$conn = mysqli_connect("localhost", "u928739372_abam", "KAZKOKSAI", "u928739372_abam");
if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error());
}
// define global constants
define ('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'https://mrspider.000webhostapp.com/');
date_default_timezone_set('Europe/Vilnius');
?>