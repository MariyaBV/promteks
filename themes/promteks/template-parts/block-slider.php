<?php
    $r = get_fields();
?>

<section class="block-slider" id="<?php echo esc_attr($block['id']); ?>">
    <div class="__slider">
        <div class="swiper" id="slider_swiper<?php echo esc_attr($block['id']); ?>">
            <div class="swiper-wrapper slider__wrapper">
                <?php foreach ($r['sliders'] as $item): ?>
                    <div class="swiper-slide slider__slide">
                        <a href="<?= $item['image']; ?>" data-fancybox="gallery">
                            <img class="img" src="<?= $item['image']; ?>" alt="slide image"/>
                        </a>
                        <div class="slider-content">
                            <?php if (!empty($item['button']['link']) && !empty($item['button']['link-text'])): ?>
                                <a class="slide-button" href="<?= $item['button']['link']; ?>">
                                    <h4><?= $item['button']['link-text']; ?></h4>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="swiper-pagination block-slider__pagination" id="pagination_<?php echo esc_attr($block['id']); ?>"></div>
        <div class="swiper-button-prev block-slider__prev icon-Vector-13" id="prev_<?php echo esc_attr($block['id']); ?>"></div>
        <div class="swiper-button-next block-slider__next icon-Vector-14" id="next_<?php echo esc_attr($block['id']); ?>"></div>
    </div>
</section>
