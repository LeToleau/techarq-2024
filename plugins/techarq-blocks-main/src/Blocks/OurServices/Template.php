<?php
    $title = get_field('our_services_title');
?>

<div class="our-services js-our-services" aria-status="not-init">
    <div class="our-services__container techarq-container">
        <?php if ($title) : ?>
            <h2 class="our-services__title techarq-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <div class="our-services__services">
            <?php if (have_rows('our_services_repeater')) : 
                while (have_rows('our_services_repeater')) : the_row() ; 
                $description = get_sub_field('description'); 
                $images = get_sub_field('images'); ?>
                <div class="our-services__service">
                    <div class="our-services__service-banner">
                        <h4 class="our-services__service-description"><?php echo esc_html($description); ?></h4>
                    </div>
                    <div class="our-services__service-images swiper">
                        <?php if ($images) : ?>
                            <div class="swiper-wrapper">
                                <?php foreach ($images as $img) : ?>
                                    <div class="swiper-slide">
                                        <?php echo wp_get_attachment_image($img, 'medium_large'); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif;  ?>
                    </div>
                </div>
            <?php endwhile;
            endif; ?>
        </div>
    </div>
</div>
    