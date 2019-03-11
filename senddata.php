<?PHP
include "includes/sql.php";
include "includes/crawler.php";

$sql = "SELECT * FROM CRAWLER";
$result = mysqli_query($conn, $sql);

while($data = mysqli_fetch_assoc($result))
{
    $url = $data['destination'];
    $link = $data['target_link'];
    $email = $data['email'];

    $results_page = curl($url);
    $got = crawl($results_page, $link);

    $sqlUpdate = "UPDATE CRAWLER SET link_status = '$got[0]', nofollow = '$got[1]' WHERE destination = '$url' AND email = '$email'";
    $resultUpdate = mysqli_query($conn,$sqlUpdate);
}
sendData($email, $conn);

?>