<?php
$r = get_fields();
?>

<div class="steps">
    <?php foreach ($r['img-text'] as $item): ?>
        <div class="step-item">
            <h3 class="step-subtitle"><?php echo $item['text']; ?></h3>
            <img src="<?php echo $item['img']; ?>" alt="Шаги"  />
        </div>
    <?php endforeach; ?>
</div>