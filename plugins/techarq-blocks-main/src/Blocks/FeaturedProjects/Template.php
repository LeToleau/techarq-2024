<?php
    $title = get_field('featured_projects_title');
    $copy = get_field('featured_projects_copy');
    $projects = get_field('featured_projects');

    use TecharqBlocks\Helpers\SvgHelper;
?>

<div class="featured-projects js-featured-projects" aria-status="not-init">
    <div class="container techarq-container">
        <div class="featured-projects__text">
        <?php if ($title) : ?>
            <h2 class="featured-projects__title techarq-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($copy) : ?>
            <p class="featured-projects__copy"><?php echo esc_html($copy) ?></p>
        <?php endif; ?>
        </div>
        <div class="featured-projects__projects">
            <div class="featured-projects__projects-wrapper">
                <?php if ($projects) : ?>
                    <?php foreach ($projects as $project) : 
                        $post_id = $project->ID;
                        $post_title = $project->post_title;
                        $post_excerpt = $project->post_excerpt;
                        $post_features = get_field('project_features', $post_id);
                    ?>
                        <div class="featured-projects__project" style="background: url( <?php echo esc_url( get_the_post_thumbnail_url($post_id, 'medium_large') ); ?> )">
                            <a href="<?php echo esc_url(get_the_permalink($post_id)); ?>" class="featured-projects__project-link"></a>
                            <div class="featured-projects__project-label">
                                <div class="info">
                                    <h3 class="main techarq-title"><?php echo esc_html($post_title); ?></h3>
                                    <p class="sub"><?php echo esc_html($post_excerpt); ?></p>
                                </div>
                                <div class="featured-projects__project-features">
                                    <?php if ($post_features['project_surface']) : ?>
                                        <div class="featured-projects__feature">
                                            <div class="featured-projects__feature-icon">
                                                <?php echo SvgHelper::get_svg('assets/icons/space-icon.svg'); ?>
                                            </div>
                                            <div class="featured-projects__feature-value">
                                                <span><?php echo esc_html($post_features['project_surface'] . ' m2'); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($post_features['project_rooms']) : ?>
                                        <div class="featured-projects__feature">
                                            <div class="featured-projects__feature-icon">
                                                <?php echo SvgHelper::get_svg('assets/icons/house-icon.svg'); ?>
                                            </div>
                                            <div class="featured-projects__feature-value">
                                                <span><?php echo esc_html($post_features['project_rooms'] . ' Ambientes'); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($post_features['project_services']) : ?>
                                        <div class="featured-projects__feature">
                                            <div class="featured-projects__feature-icon">
                                                <?php echo SvgHelper::get_svg('assets/icons/worker-icon.svg'); ?>
                                            </div>
                                            <div class="featured-projects__feature-value">
                                                <span><?php echo esc_html($post_features['project_services']); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    