<?php

    $query_args = array(
        'post_type' => 'proyecto',
        'posts_per_page' => 2,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    );

    $posts_query = new WP_Query($query_args);

    ?>

<div class="related-posts js-related-posts">
    <div class="related-posts__container">
        <h2 class="techarq-title related-posts__title">
            <?php _e( 'Otros Proyectos', 'techarq-blocks' ); ?>
        </h2>
        <div class="related-posts__posts-wrapper">
            <?php
                if ($posts_query->have_posts()) :
                    while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                        <div class="related-posts__post">
                            <div class="related-posts__post-background" style="background: url(<?php echo esc_url(get_the_post_thumbnail_url()) ?>); background-position: center; background-size: cover;"></div>
                            <a href="<?php the_permalink(); ?>" class="related-posts__post-background overlay"></a>
                            <h3 class="techarq-title">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/arrow-ne.svg' ) ?>" alt="Phone Icon"><?php the_title(); ?>
                            </h3>
                        </div>
                    <?php endwhile;
                endif;
                wp_reset_postdata();
            ?>
        </div>
    </div>
</div>