<?php

$post_features = get_field('project_features');
$surface = $post_features['project_surface'];
$surface_details = $post_features['surface_details'];
$location = $post_features['project_location'];
$rooms = $post_features['project_rooms'];
$rooms_details = $post_features['rooms_details'];
$services = $post_features['project_services'];



get_header();
?>

<main class="techarq-single-project">

    <div class="techarq-single-project__hero">
        <div class="techarq-single-project__hero-bgd" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>')"></div>
    </div>
    <div class="techarq-single-project__heading">
        <div class="techarq-single-project__title-wrapper">
            <h1 class="techarq-single-project__title techarq-title"><?php the_title(); ?></h1>
        </div>
    </div>
    <div class="techarq-single-project__info-wrapper">
        <div class="techarq-single-project__content">
            <?php
            the_content();
            ?>
        </div>
        <div class="techarq-single-project__sidebar">
            <div class="techarq-single-project__sidebar-wrapper">
                <div class="techarq-single-project__map">
                    <span class="techarq-single-project__sidebar-label">Ubicación</span>
                    <p class="techarq-single-project__sidebar-address">Rio Negro 1175, San Jose, Buenos Aires, Argentina</p>
                    <?php if ( $location ) : ?>
                        <div class="techarq-single-project__data-item techarq-single-project__data--map">
                            <?php echo $location; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="techarq-single-project__features">
                    <div class="techarq-single-project__feature">
                        <div class="techarq-single-project__feature-icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/space-icon.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <div class="techarq-single-project__feature-text-wrapper">
                            <div class="techarq-single-project__feature-text"><?php echo esc_html($surface) . ' m2'; ?></div>
                            <?php if ($surface_details) : ?>
                                <div class="techarq-single-project__feature-detail-wrapper">
                                    <p class="techarq-single-project__feature-details"><?php echo $surface_details; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="techarq-single-project__feature">
                        <div class="techarq-single-project__feature-icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/house-icon.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <div class="techarq-single-project__feature-text-wrapper">
                            <div class="techarq-single-project__feature-text">
                                <?php echo esc_html($rooms) . ' ambientes'; ?>
                            </div>
                            <?php if ($rooms_details) : ?>
                                <div class="techarq-single-project__feature-detail-wrapper">
                                    <p class="techarq-single-project__feature-details"><?php echo $rooms_details; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="techarq-single-project__feature">
                        <div class="techarq-single-project__feature-icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/worker-icon.svg' ) ?>" alt="Phone Icon">
                        </div>
                        <div class="techarq-single-project__feature-text"><?php echo esc_html($services); ?></div>
                    </div>
                </div>
                <div class="techarq-single-project__share-bar">
                    <?php echo do_shortcode('[Sassy_Social_Share title="Compartí este proyecto"]') ?>
                </div>
            </div>
        </div>
    </div>
    <?php get_template_part('template-parts/single/single', 'photo-slider'); ?>
    <?php get_template_part('template-parts/single/single', 'related-posts'); ?>
</main>

<?php
get_footer();