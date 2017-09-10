<?php
$current = $app->request->getCurrentUrl();
?>

<nav
    <?php foreach ($navbar["config"] as $config => $configVal) : ?>
        <?php if ($config === 'navbar-class') : ?>
             class='<?= $configVal ?>'
        <?php endif; ?>
    <?php endforeach; ?>
>
    <ul>
        <?php foreach ($navbar["items"] as $item) : ?>
            <li
            <?php if ($app->url->create($item["route"]) === $current) : ?>
                 class='current'
            <?php endif; ?>
            ><a href='<?= $app->url->create($item["route"]) ?>'><?= $item["text"] ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>
