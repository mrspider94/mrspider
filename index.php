<?PHP include "includes/header.php"?>
<?PHP include "includes/crawler.php"?>
    <div class="wrapper">
        <form method="post" action="">
                <div class="p-item">
                    <i class="fas fa-link"></i>
                    <p>Enter links or upload a file with links to the pages that you want to Mr. Spider to crawl</p>
                    <div class="row">
                        <span>ENTER LINKS DOWN BELOW</span>
                        <div class="show-down">
                            <i class="far fa-arrow-alt-circle-down"></i>
                        </div>
                    </div>
                </div>
                <div class="p-item">
                    <i class="fas fa-search"></i>
                    <p>Enter a link that you want to look up for</p>
                    <input type="text" name="check_link" placeholder="Enter the link">
                </div>
                <div class="p-item">
                    <i class="far fa-clock"></i>
                    <p>Enter an email where to send results of the crawl</p>
                    <input type="text" name="inp_email" placeholder="Enter your email">
                </div>
                <textarea name="url_list" placeholder="Enter links to the pages here"></textarea>
                <div class="submit-area">
                    <span class="info-text">START TO </span><input type="submit" name="submit" value="CRAWL" class="submit-btn crawl-btn"><br>
                </div>
                
        </form>
    </div>
<?PHP include "includes/footer.php"?>
    