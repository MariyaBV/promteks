<?php
    $r = get_fields();
?>

<section class="block-slider" id="<?php echo esc_attr($block['id']); ?>">
    <div class="__slider">
        <div class="swiper" id="slider_swiper<?php echo esc_attr($block['id']); ?>">
            <div class="swiper-wrapper slider__wrapper">
                <?php foreach ($r['sliders'] as $item): ?>
                    <div class="swiper-slide slider__slide">
                        <h3 class="slide_text"><?= $item['text']; ?></h3>
                        <img class="img" src="<?= $item['image']; ?>" alt="slide image"/>
                        <a href="<?= $item['link']; ?>"></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="swiper-pagination block-slider__pagination" id="pagination_<?php echo esc_attr($block['id']); ?>"></div>
        <div class="swiper-button-prev block-slider__prev" id="prev_<?php echo esc_attr($block['id']); ?>"></div>
        <div class="swiper-button-next block-slider__next" id="next_<?php echo esc_attr($block['id']); ?>"></div>
    </div>
</section>
