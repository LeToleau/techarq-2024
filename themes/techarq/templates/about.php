<?php
/*
Template Name: About Us
*/

    get_header();
?>

    <div class="entry-content techarq-about">
        <div class="techarq-about__hero">
            <div class="techarq-about__hero-bgd" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>')"></div>
        </div>

        <div class="techarq-about__heading">
            <div class="techarq-about__title-wrapper">
                <h1 class="techarq-about__title techarq-title"><?php _e('Quienes Somos'); ?></h1>
            </div>
        </div>
        <div class="techarq-about__container">
            <?php
                echo the_content();
            ?>
        </div>
    </div>

<?php
    get_footer();
?>