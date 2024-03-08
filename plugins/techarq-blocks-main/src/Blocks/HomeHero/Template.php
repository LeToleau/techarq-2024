<?php
    $techarq_video = get_field('home_hero_video');
    $techarq_title = get_field('home_hero_title');
    $techarq_copy = get_field('home_hero_copy');
    $techarq_cta = get_field('home_hero_cta');

    use TecharqBlocks\Helpers\SvgHelper;
?>

<div class="home-hero">
    <?php if ($techarq_video) : ?>
        <video class="home-hero__video" autoplay muted loop>
            <source src="<?php echo esc_url( $techarq_video ); ?>" type="video/mp4">
            Tu navegador no soporta la etiqueta de video.
        </video>
    <?php elseif ( is_admin() ) : ?> 
        <div class="home-hero__video-placeholder">
            <?php echo SvgHelper::get_svg('assets/icons/add-video.svg'); ?>
            <span><?php _e('Puedes agregar un video como fondo de este bloque.', 'techarq-blocks'); ?></span>
        </div>
    <?php endif; ?>

    <div class="home-hero__overlay"></div>

    <div class="home-hero__content <?php echo $techarq_video ? '' : 'darken-bgd' ?>">
        <?php if ($techarq_title || $techarq_copy || $techarq_cta) : ?>
            <div class="home-hero__text-container">
                <div class="home-hero__text-holder">
        <?php endif; ?>
                    <?php if ($techarq_title) : ?>
                        <h1 class="home-hero__title"><?php echo esc_html( $techarq_title ); ?></h1>
                    <?php elseif ( is_admin() ) : ?> 
                        <h2 class="home-hero__title"><?php _e('Agrega un titulo.', 'techarq-blocks'); ?></h2>
                    <?php endif; ?>
                    <?php if ($techarq_copy) : ?>
                        <div class="home-hero__copy"><?php echo $techarq_copy; ?></div>
                    <?php elseif ( is_admin() ) : ?> 
                        <h2 class="home-hero__copy"><?php _e('Agrega un texto.', 'techarq-blocks'); ?></h2>
                    <?php endif; ?>
                    <?php if ($techarq_cta) : ?>
                        <div class="home-hero__cta-wrapper">
                            <a href="<?php echo esc_url( $techarq_cta['url'] ); ?>" class="home-hero__cta button button--primary"><?php echo esc_html( $techarq_cta['title'] ); ?></a>
                        </div>
                    <?php elseif ( is_admin() ) : ?> 
                        <div class="home-hero__cta-wrapper">
                            <span class="home-hero__cta button button--primary"><?php _e('Agrega un boton.', 'techarq-blocks'); ?></span>
                        </div>
                    <?php endif; ?>
        <?php if ($techarq_title || $techarq_copy || $techarq_cta) : ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
    