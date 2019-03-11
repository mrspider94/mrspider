<?php 
// connect to database
$conn = mysqli_connect("localhost", "USERNAME", "PASSWORD", "DATABASE");
if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error());
}
// define global constants
define ('ROOT_PATH', realpath(dirname(__FILE__)));
?>