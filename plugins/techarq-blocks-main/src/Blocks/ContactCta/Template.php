<?php
    $title = get_field('cta_title');
    $cta = get_field('cta_link');

    use TecharqBlocks\Helpers\SvgHelper;
?>

<div class="contact-cta js-contact-cta" aria-status="not-init">
    <div class="contact-cta__container techarq-container">
        <?php if ($title) : ?>
            <div class="contact-cta__title-wrapper">
                <h2 class="contact-cta__title"><?php echo esc_html($title) ?></h2>
            </div>
        <?php endif; ?>
        <?php if ($cta) : ?>
            <div class="contact-cta__cta-wrapper">
                <span class="contact-cta__cta button button--primary"><?php echo esc_html($cta); ?></a>
            </div>
        <?php endif; ?>
    </div>

    <div class="contact-cta__modal">
        <div class="contact-cta__form">
            <div class="contact-cta__form-title techarq-title"><?php _e('Contactanos!', 'techarq-blocks'); ?></div>
            <?php echo do_shortcode('[contact-form-7 id="6127" title="Formulario de Contacto"]'); ?>
            <div class="contact-cta__modal-close">
            <?php echo SvgHelper::get_svg('assets/icons/close-icon.svg'); ?>
            </div>
        </div>
    </div>
</div>
    