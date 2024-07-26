<?php
  $fields = get_fields();
?>

<div class="list-img">
    <div class="list-img__info">
        <?php foreach ($fields['items'] as $item): ?>
            <div class="list-img__item">
                <div class="list-img__subtitle-img">
                    <img src="<?= $item['img']; ?>">
                    <p><?= $item['subtitle']; ?></p>
                </div>
                <p><?= $item['text']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="map">
        <img src="<?= $fields['img']; ?>" alt="Карта">
    </div>
</div>
