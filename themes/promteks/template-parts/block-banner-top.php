<?php
$r = get_fields();
var_dump($r);
?>
<section class="top-banner br20 bg-gray">
    <div class="wrap">
        <div class="top-banner__content">
            <h1 class="top-banner__title">
                <?php echo $r['title']; ?>
            </h1>
        </div>
    </div>
</section>