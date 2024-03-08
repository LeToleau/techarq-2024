<?php
    $address = get_field('footer_address', 'option');
    $map = get_field('footer_embed_map', 'option');
    $phone_number = get_field('footer_phone', 'option');
    $instagram = get_field('footer_instagram', 'option');
    $schedule = get_field('footer_schedule', 'option');
?>


<footer id="site-footer" class="footer js-footer">
    <div class="footer__container container">
        <div class="footer__left-side">
            <div class="footer__logo-text">
                <div class="footer__logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/techarq-logo.png' ) ?>" alt="Site Logo">
                    </a>
                </div>
                <span><?php _e('Desarrolladora & Constructora', 'techarq-blocks'); ?></span>
            </div>
            <div class="footer__data">
                <?php if ( $phone_number ) : ?>
                    <div class="footer__data-item footer__data--phone">
                        <div class="footer__data-item_icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/phone.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <span><a href="tel: <?php echo esc_html($phone_number); ?>"><?php echo esc_html($phone_number); ?></a></span>
                    </div>
                <?php endif; ?>
                <?php if ( $instagram ) : ?>
                    <div class="footer__data-item footer__data--instagram">
                        <div class="footer__data-item_icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/instagram.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <span><a href="<?php echo esc_url( $instagram['url'] ); ?>"><?php echo esc_html( $instagram['title'] ); ?></a></span>
                    </div>
                <?php endif; ?>
                <?php if ( $schedule ) : ?>
                    <div class="footer__data-item footer__data--schedule">
                        <div class="footer__data-item_icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/time.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <span><?php echo esc_html($schedule); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ( $address ) : ?>
                    <div class="footer__data-item footer__data--address">
                        <div class="footer__data-item_icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/location.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <span><?php echo esc_html($address); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="footer__copyright">
                <span><?php _e( '© Techarq 2023 - Todos los derechos reservados', 'techarq-blocks' ); ?></span>
                <span><?php _e( 'Desarrollado por ConicDev', 'techarq-blocks' ); ?></span>
            </div>
        </div>
        <div class="footer__right-side">
            <div class="footer__map">
                <?php if ( $map ) : ?>
                    <div class="footer__data-item footer__data--map">
                        <?php echo $map; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer__extra-links">
                <?php if ( have_rows('extra_links', 'option') ) : 
                    while ( have_rows('extra_links', 'option') ) : the_row();
                    $link = get_sub_field( 'link' ); ?>

                    <div class="footer__extra-link">
                        <a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
                    </div>
                <?php endwhile;
                endif; ?>
            </div>
        </div>
    </div>
</footer>