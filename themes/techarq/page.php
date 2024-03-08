<?php
    get_header();
?>

    <div class="entry-content techarq-<?php echo get_post_type(); ?>">
        <?php
            echo the_content();
        ?>
    </div>

<?php
    get_footer();
?>