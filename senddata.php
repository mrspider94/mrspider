<?PHP
include "includes/spider.php";
include "includes/request.php";
// Send data class

class sendData extends mySql {

    public function send() {
        $sql = "SELECT DISTINCT email FROM CRAWLER";
        $result = $this->connect()->query($sql);
        $sendData = new mailCompose(); // send data class
        $spider = new spider(); // crawl class
        $update = new request(); // update class

        while ($row = $result->fetch_assoc())
        {
            $email = $row['email'];
            $this->updateContent($email, $spider, $update);
            $sendData->mailData($email); // sending data
        }
    }

    protected function updateContent($email, $spider, $update) {
        $sql = "SELECT * FROM CRAWLER WHERE email = '$email'";
        $result = $this->connect()->query($sql);
        while ($row = $result->fetch_assoc())
        {
            $url = $row['destination'];
            $link = $row['target_link'];

            
            $status = $spider->crawl($url, $link); // checking for link status
            $update->updateData($url, $link, $email, $status);  // updating database
        }
    }
}

$send = new sendData();
$send->send();

?>
