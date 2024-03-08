<div class="left-right">
    <div class="left-right__container container">
        <?php if (have_rows('left_right_repeater')) : ?>
            <div class="left-right__content">
                <?php while (have_rows('left_right_repeater')) : the_row(); 
                    $text = get_sub_field('text');
                    $image = get_sub_field('image');
                    $order = get_sub_field('order');
                ?>
                    <div class="left-right__row<?php echo $order ? ' reverse' : '' ?>">
                        <div class="left-right__row-text">
                            <?php echo $text; ?>
                        </div>
                        <div class="left-right__row-image">
                            <img src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
    