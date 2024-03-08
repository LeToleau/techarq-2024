<?php
    $title = get_field('about_title');
    $copy = get_field('about_copy');
    $cta = get_field('about_cta');
    $images = get_field('about_images');
    $order_reverse = get_field('about_order');
?>

<div class="about js-about" aria-status="not-init">
    <div class="about__container container<?php echo $order_reverse ? ' order-reverse' : '' ?>">
        <div class="about__text">
            <?php if ($title) : ?>
                <h2 class="about__title techarq-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ($copy) : ?>
                <div class="about__copy"><?php echo $copy; ?></div>
            <?php endif; ?>
            <?php if ($cta) : ?>
                <div class="about__cta-wrapper">
                    <a href="<?php echo esc_url($cta['url']); ?>" class="about__cta button button--primary"><?php echo esc_html($cta['title']); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <div class="about__images">
            <?php if ($images) : 
                $i = 0;
                foreach ($images as $img) : ?>
                    <div class="about__img-wrapper">
                        <?php  if ($i === 0) { echo wp_get_attachment_image($img, 'medium_large'); } else { echo wp_get_attachment_image($img, 'medium'); } ?>
                    </div>
                    <?php $i++; ?>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>
    