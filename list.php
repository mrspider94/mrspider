<?php

$sql = "SELECT * FROM CRAWLER";
$result = mysqli_query($conn, $sql);
?> <textarea readonly> <?php 

while ($data = mysqli_fetch_assoc($result)) {
    $url = $data['destination'];
    $date = $data['date_time'];
    echo $url . " - " . $date . "\r\n";
} ?>