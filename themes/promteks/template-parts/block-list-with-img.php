<?php
    $fields = get_fields();
?>
<div class="list-with-img">
    <h4 class="list-with-img__title"><?= $fields['title']; ?></h4>
    <ul class="list-with-img__list">
        <?php foreach ($fields['list'] as $item):?>
            <li class="list-with-img__item">
                <img class="list-with-img__img" src="<?= $item['img']; ?>">
                <p class="list-with-img__text"><?= $item['text']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
