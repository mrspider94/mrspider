<?php
// list class

class listUrls extends mySql {

    public function listAll() {
        $sql = "SELECT * FROM CRAWLER";
        $result = $this->connect()->query($sql);

        echo "<textarea readonly>";

        while ($row = $result->fetch_assoc()) {
            $url = $row['destination'];
            $date = $row['date_time'];
            $link = $row['target_link'];
                
            echo "Added on " . $date . " - " . $url . "\n";
        }
    
        echo "</textarea>";
    }
}

?>