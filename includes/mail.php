<?php
require_once "sql.php";
// Mail composition class

class mailCompose extends mySql {
    public function mailData($sendTo) {
        $contents = $this->getContent($sendTo);
        $subject = "Mr. Spider Data";
        $headers = "From: data@mrspider.com";

        return mail($sendTo,$subject,$contents,$headers);
    }

    protected function getContent($sendTo) {
        $notfound = 0;
        $nofollow = 0;
        $notfoundArray = array();
        $nofollowArray = array();

        $sql = "SELECT * FROM CRAWLER WHERE email = '$sendTo'";
        $result = $this->connect()->query($sql);
        $rows = $result->num_rows;

        while ($row = $result->fetch_assoc()) {
            if ($row['link_status'] == 0) {
                $notfound++;
                $notfoundArray[] = $row['destination'];
            }
            elseif ($row['nofollow'] == 1) {
                $nofollow++;
                $nofollowArray[] = $row['destination'];
            }
        }
    
        $contents_one = $rows . " URLs checked, " . $notfound . " backlinks not found, " . $nofollow . " backlinks found with NOFOLLOW: \n";
        $contents_two = '';
        $contents_three = '';
    
        foreach ($notfoundArray as $notfound_link) {
            $contents_two = $contents_two . "- " . $notfound_link . "\n";
        }
    
        foreach($nofollowArray as $nofollow_link) {
            $contents_three = $contents_three .  "- " . $nofollow_link . " - NOFOLLOW \n";
        }

        $contents = $contents_one . $contents_two . $contents_three;

        return $contents;

    }
}
?>