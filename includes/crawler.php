<?php 
if(isset($_POST['submit']))
{   
    $urls_list = $_POST['url_list'];
    $urls_array = explode(PHP_EOL, $urls_list);
    $time_added = date("Y-m-d H:i:s");
    $email = $_POST['inp_email'];
    $link = $_POST['check_link'];

    if ($urls_list != '' && $email != '' && $link != '')
    {
        foreach ($urls_array as $url) {
            $got = check($url, $link);
    
            $sqlCheck = "SELECT 1 from CRAWLER WHERE destination ='$url'";
            if ($check_result = mysqli_query($conn,$sqlCheck))
            {
                if(mysqli_num_rows($check_result) > 0)
                {
                    $sqlUpdate = "UPDATE CRAWLER SET link_status = '$got[0]', nofollow = '$got[1]', target_link = '$link' WHERE destination = '$url' AND email = '$email'";
                    $resultUpdate = mysqli_query($conn,$sqlUpdate);
                }
                else
                {
                    $sqlInsert = "INSERT INTO CRAWLER (destination, target_link, email, link_status, nofollow, date_time) VALUES('$url', '$link', '$email', '$got[0]',  '$got[1]', '$time_added')";
                    $resultInsert = mysqli_query($conn,$sqlInsert);
                }     
            }
        }
    
        sendData($email, $conn);
    }
    else {
        if ($urls_list == '') {
            echo '<div class="wrapper"><div class="error"><i class="fas fa-exclamation-triangle"></i><span>Please enter at least one URL for crawling</span></div></div>';
        }
        elseif ($link == '') {
            echo '<div class="wrapper"><div class="error"><i class="fas fa-exclamation-triangle"></i><span>Please enter a link to search for</span></div></div>';
        }
        elseif ($email == '') {
            echo '<div class="wrapper"><div class="error"><i class="fas fa-exclamation-triangle"></i><span>Please enter an email</span></div></div>';
        }
        else {
            echo '<div class="wrapper"><div class="error"><i class="fas fa-exclamation-triangle"></i><span>Please be sure that all fields are filled in</span></div></div>';
        }
    }
}


function check($url, $link)
{
    $dom = new DOMDocument();
    $statusLink = 0;
    $statusNoFollow = 0;

    $html = file_get_contents($url);
    @$dom->loadHTML($html);
    $alinks = $dom->getElementsByTagName('a');

    foreach ($alinks as $alink){

        if ($alink->getAttribute('href') == $link)
        {
            $statusLink = 1;
            if ($alink->getAttribute('rel') == 'nofollow')
            {
                $statusNoFollow = 1;
            }
            break;
        }
    }

    $status = array($statusLink, $statusNoFollow);
    
    return $status;
}

function sendData($email, $conn) {
    $to = $email;
    $subject = "Mr. Spider Data";
    $sql = "SELECT * FROM CRAWLER";
    $sql_result = mysqli_query($conn, $sql);
    $sql_rows = mysqli_num_rows($sql_result);
    $notfound = 0;
    $nofollow = 0;
    $notfoundArray = array();
    $nofollowArray = array();
    while ($row = mysqli_fetch_assoc($sql_result)) {
        if ($row['link_status'] == 0) {
            $notfound++;
            $notfoundArray[] = $row['destination'];
        }
        elseif ($row['nofollow'] == 1) {
            $nofollow++;
            $nofollowArray[] = $row['destination'];
        }
    }

    $contents_one = $sql_rows . " URLs checked, " . $notfound . " backlinks not found, " . $nofollow . " backlinks found with NOFOLLOW: \r\n";
    $contents_two = '';
    $contents_three = '';
    foreach ($notfoundArray as $notfound_link) {
        $contents_two = $contents_two . "- " . $notfound_link . "\r\n";
    }
    foreach($nofollowArray as $nofollow_link) {
        $contents_three = $contents_three .  "- " . $nofollow_link . " - NOFOLLOW \r\n";
    }
    $headers = "From: data@mrspider.com";

    $contents = $contents_one . $contents_two . $contents_three;

    mail($to,$subject,$contents,$headers);
}

?>