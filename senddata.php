<?PHP
include "includes/mail.php";
include "includes/spider.php";
include "includes/request.php";

// Send data class

class sendData extends mySql {
    public function send() {
        $sql = "SELECT * FROM CRAWLER";
        $result = $this->connect()->query($sql);

        $spider = new spider(); // crawl class
        $update = new request(); // update class
        $sendData = new mailCompose(); // send data class

        while ($row = $result->fetch_assoc())
        {
            $url = $row['destination'];
            $link = $row['target_link'];
            $email = $row['email'];

            $status = $spider->crawl($url, $link); // checking for link status

            $update->updateData($url, $link, $email, $status);  // updating database
        }
        $sendData->mailData($email); // sending data
    }
}

$send = new sendData();
$send->send();

?>
