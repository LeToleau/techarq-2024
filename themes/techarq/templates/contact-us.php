<?php
/*
Template Name: Contact Us
*/
$address = get_field('footer_address', 'option');
$phone_number = get_field('footer_phone', 'option');
$instagram = get_field('footer_instagram', 'option');

    get_header();
?>

    <div class="entry-content techarq-contact">

        <div class="techarq-contact__hero">
            <div class="techarq-contact__hero-bgd-wrapper">
                <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="Hero image" class="techarq-contact__hero-bgd">
            </div>
        </div>

        <div class="techarq-contact__form">
            <div class="techarq-contact__form-title techarq-title"><?php _e('Comuniquese con nosotros', 'techarq-blocks'); ?></div>
            <div class="techarq-contact__form-content">
                <?php echo do_shortcode('[contact-form-7 id="6127" title="Formulario de Contacto"]'); ?>
                <div class="techarq-contact__sidebar">
                    <div class="techarq-contact__sidebar-title techarq-title">
                        <?php _e('Otros medios de contacto:', 'techarq-blocks'); ?>
                    </div>
                    <div class="techarq-contact__sidebar-item">
                        <div class="techarq-contact__sidebar-icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/phone.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <a href="tel: <?php echo esc_html($phone_number); ?>"><?php echo esc_html($phone_number); ?></a>
                    </div>
                    <div class="techarq-contact__sidebar-item">
                        <div class="techarq-contact__sidebar-icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/instagram.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <a target="_blank" href="<?php echo esc_url( $instagram['url'] ); ?>"><?php echo esc_html( $instagram['title'] ); ?></a>
                    </div>
                    <div class="techarq-contact__sidebar-item">
                        <div class="techarq-contact__sidebar-icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/location.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <span><?php echo esc_html($address); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="techarq-contact__container">
            <?php
                echo the_content();
            ?>
        </div>
    </div>

<?php
    get_footer();
?>