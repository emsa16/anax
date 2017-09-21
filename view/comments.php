<?php
$sortBestUrl = "$baseUrl?sort=best";
$sortOldesttUrl = "$baseUrl?sort=old";
$sortNewesttUrl = "$baseUrl?sort=new";
?>


<div class="comments">
    <h4>Skriv en kommentar</h4>
    <?= $commentBox ?>

    <h3>Kommentarer:</h3>
    <p>Sortera på <a href="<?= $sortBestUrl ?>">bästa</a> |
                  <a href="<?= $sortOldesttUrl ?>">äldsta</a> |
                  <a href="<?= $sortNewesttUrl ?>">nyaste</a></p>
    <?= $comments ?>
</div>
