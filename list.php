<?PHP include "includes/header.php"?>
<?PHP include "includes/list.php"?>

<div class="section">
    <div class="wrapper">
        <?php 
        $listLinks = new listUrls();
        $listLinks->listAll();
        ?>
    </div>
</div>

<?PHP include "includes/footer.php"?>