<?php 

// Crawler class 

class spider {
    protected $status = array();

    protected function cURL($url) {
        $curl = curl_init();
        $timeout = 5;

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        
        $html = curl_exec($curl);
        curl_close($curl);

        return $html;
    }

    public function crawl($url, $link) {
        $data = $this->cURL($url);

        $dom = new DOMDocument();
        @$dom->loadHTML($data);
        $links = $dom->getElementsByTagName('a');

        return $this->findLink($links, $link);
    }

    protected function findLink($links, $link) {
        $statusLink = 0; // 0 - link not found, 1 - link was found
        $statusNoFollow = 0; // 0 - link doesn't have NOFOLLOW, 1 - link has NOFOLLOW
        
        // Checking if link was found
        foreach ($links as $item)
        {
            if ($item->getAttribute('href') == $link)
            {  
                $statusLink = 1;
                // Checking for NOFOLLOW 
                if ($item->getAttribute('rel') == 'nofollow')
                {
                    $statusNoFollow = 1;
                }
                break;
            }
    
        }
        
        $status = array($statusLink, $statusNoFollow); // Placing link status in array
        
        return $status; 
    }
}
?>