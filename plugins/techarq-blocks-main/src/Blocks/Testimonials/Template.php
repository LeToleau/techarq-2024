<?php 
/**
 * 
 */

 use TecharqBlocks\Helpers\PlaceholderHelper;

 $techarq_image = get_field('techarq_testimonials_image');
?>

<div class="techarq-block testimonials">
    <?php if(have_rows('techarq_testimonials')) : ?>
        <div class="quote-slider-area">
            <div class="wrapper">
                <div class="row">
                        <div class="slider-dots">
                            <!-- <img src="<?php echo esc_url($techarq_image); ?>" alt="<?php _e('Quote Background', 'techarq-blocks'); ?>"> -->
                        </div>
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php while (have_rows('techarq_testimonials')) : the_row();
                                $headline = PlaceholderHelper::placeholder('headline', 'Add a Headline', true);
                                $subheadline = PlaceholderHelper::placeholder('sub_headline', 'Add a Subheadline', true);
                                $quote = PlaceholderHelper::placeholder('quote', 'Add a Quote', true);
                                $name = PlaceholderHelper::placeholder('name', 'Add a Name', true);
                                $image = PlaceholderHelper::placeholder('image', plugins_url('techarq-blocks/assets/icons/image-placeholder.png'), true);
                                $button = get_sub_field('button'); ?>
                                
                                <div class="swiper-slide item">
                                    <?php if ($image) : ?>
                                        <div class="col l6 m12 s12">
                                            <div class="quote-image">
                                                <div class="image-wrapper">
                                                    <img src="<?php echo esc_url($image); ?>" alt="<?php _e('Quote Image', 'techarq-blocks'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col <?php echo $image ? 'l6' : 'l12'; ?> m12 s12">
                                        <div class="slider-quote">
                                            <?php if ($headline) : ?>
                                                <h2 class="subheadline"><?php echo esc_html($headline); ?></h2>
                                            <?php endif; ?>
                                            <?php if ($subheadline) : ?>
                                                <div class="intro-text"><?php echo esc_html($subheadline); ?></div>
                                            <?php endif; ?>
                                            <?php if ($quote) : ?>
                                                <blockquote>
                                                    <p><?php echo esc_html($quote); ?><span class="closing-quote">”</span></p>
                                                    <cite><?php echo esc_html($name); ?></cite>
                                                </blockquote>
                                            <?php endif; ?>
                                            <?php if ($button) : ?>
                                                <a href="<?php echo $button['url']; ?>"
                                                    <?php if ($button['target']) : ?>
                                                        target="<?php echo $button['target']; ?>"
                                                    <?php  endif; ?>
                                                class="techarq-button button"><?php echo $button['title']; ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                            endwhile; ?>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                        <!--swiper end-->
                    </div>
                </div>
            </div>
        </div>
        <!--quote-slider-area-->
    <?php elseif (is_admin()) : ?>
        <div class="services-placeholder" style="padding: 50px 0;">
            <span>Start adding Testimonials by clicking on the pencil button!</span>
            <img src="<?php echo plugins_url('/techarq-blocks/assets/icons/pencil.png'); ?>" height="40" width="40">
        </div>
    <?php endif; ?>
</div>