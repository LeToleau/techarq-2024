<?php
    $images = get_field('project_images');
?>

<div class="photo-slider js-photo-slider">
    <div class="photo-slider__wrapper swiper">
        <div class="swiper-wrapper">

            <?php if ($images !== null) : 
                foreach ($images as $img) : ?>
                    <div class="photo-slider__item swiper-slide">
                        <img class="photo-slider__img" src=<?php echo esc_url($img["sizes"]["large"]); ?>>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>