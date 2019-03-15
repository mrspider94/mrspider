<?php
require_once "sql.php";
include "mail.php";

// Request class

class request extends mySql {

    protected $urls_array = array();

    public function setRequest($urls_list, $email, $link) {

        $spider = new spider(); // crawl class
        $sendData = new mailCompose(); // send data class
        $this->urls_array = explode(PHP_EOL, $urls_list);
        $time_added = date("Y-m-d");

        if ($urls_list != '' && $email != '' && $link != '')
        {
            foreach (array_filter($this->urls_array) as $url)
            {
                $url = trim(preg_replace('/\s+/', ' ', $url)); // removing line breaks ir $url just in case there are any
                $result = $spider->crawl($url, $link); // checking for link status
                $this->saveRequest($url, $link, $email, $result, $time_added); // saving data
            }
           $sendData->mailData($email); // send data 
        }
        else {
            $this->requestError($urls_list, $email, $link);
        }
    }

    protected function requestError($urls_list, $email, $link) {
        if ($urls_list == '') {
            echo '  <div class="wrapper">
                        <div class="error">
                            <i class="fas fa-exclamation-triangle"></i><span>Please enter at least one URL for crawling</span>
                         </div>
                    </div>';
        }
        if ($link == '') {
            echo '  <div class="wrapper">
                        <div class="error">
                            <i class="fas fa-exclamation-triangle"></i><span>Please enter a link to search for</span>
                         </div>
                    </div>';
        }
        if ($email == '') {
            echo '  <div class="wrapper">
                        <div class="error">
                            <i class="fas fa-exclamation-triangle"></i><span>Please enter an email</span>
                        </div>
                    </div>';
        }   
    }

    protected function saveRequest($url, $link, $email, $status, $time_added) {
        $sqlCheck = "SELECT 1 from CRAWLER WHERE destination='$url'";
        $result = $this->connect()->query($sqlCheck);

        if ($result->num_rows > 0) // if data about current link is present -> update data.
        {
            $this->updateData($url, $link, $email, $status);
        }
        else
        {
            $this->insertData($url, $link, $email, $status, $time_added);
        }
    }

    public function updateData($url, $link, $email, $status) {
        $sqlUpdate = "UPDATE CRAWLER SET link_status = '$status[0]', nofollow = '$status[1]', target_link = '$link' WHERE destination = '$url'";
        $this->connect()->query($sqlUpdate);
    }

    protected function insertData($url, $link, $email, $status, $time_added) {
        $sqlInsert = "INSERT INTO CRAWLER (destination, target_link, email, link_status, nofollow, date_time) VALUES('$url', '$link', '$email', '$status[0]',  '$status[1]', '$time_added')";
        $this->connect()->query($sqlInsert);
    }
}

if(isset($_POST['submit']))
{   
    $urls_list = $_POST['url_list'];
    $email = $_POST['inp_email'];
    $link = $_POST['check_link'];

    $dataRequest = new request();
    $dataRequest->setRequest($urls_list, $email, $link);
}

?>