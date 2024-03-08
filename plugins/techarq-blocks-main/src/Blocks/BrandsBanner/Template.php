<?php

    $title = get_field('brands_banner_title');
    $images = get_field('brands_banner_imgs');

?>

<div class="brands-banner js-brands-banner">
    <div class="brands-banner__container techarq-container">
        <?php if ($title) : ?>
            <h2 class="techarq-title brands-banner__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <div class="brands-banner__images">
            <?php if ($images) : 
                foreach ($images as $img) : ?>
                    <div class="brands-banner__image" style="background-image: url('<?php echo esc_url($img); ?>')"></div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>
    