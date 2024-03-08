<?php
/**
 * Techarq Main Template
 *
 * @package TecharqBlocks
 */

get_header();

?>

<main id="content" class="site-content techarq-template">
  <?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	?>
</main>


<?php get_footer(); ?>
