<?php
    $fields = get_fields();
?>
<section class="three-blocks" id="<?= $block['id'] ?>">
    <div class="element-large">
        <div class="content">
            <p>
            <?= $fields['large-block']['text']; ?>
            </p>
        </div>
    </div>
    <div class="element-small">
        <div class="content">
            <p>
                <?= $fields['second-block']['text']; ?>
            </p>
        </div>
    </div>
    <div class="element-small">
        <div class="content">
            <p>
                <?= $fields['third-block']['text']; ?>
            </p>
        </div>
    </div>
</section>
