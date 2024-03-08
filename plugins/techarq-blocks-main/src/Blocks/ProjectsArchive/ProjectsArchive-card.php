<?php
/**
 * Block Template: latest-news
 *
 * @package Techarq
 */

use TecharqBlocks\Helpers\SvgHelper;

$post_features = get_field( 'project_features', get_the_ID() );

?>

<article class="projects-archive__item">
	<a href="<?php the_permalink(); ?>" class="projects-archive__item__link"></a>
	<div class="projects-archive__item__left-side">
		<div class="projects-archive__item__thumbnail">
			<div class="thumbnail-overlay"></div>
			<img src="<?php echo get_the_post_thumbnail_url(null, 'medium_large'); ?>" alt="Project Thumbnail" class="projects-archive__item-img">
		</div>
		<div class="projects-archive__item__content">
			<h3 class="projects-archive__item__title techarq-title">
				<?php the_title(); ?>
			</h3>
			<div class="projects-archive__item__excerpt">
				<?php the_excerpt(); ?>
			</div>
			<div class="projects-archive__item__project-features">
				<?php if ($post_features['project_surface']) : ?>
					<div class="projects-archive__item__feature">
						<div class="projects-archive__item__feature-icon">
							<?php echo SvgHelper::get_svg('assets/icons/space-icon.svg'); ?>
						</div>
						<div class="projects-archive__item__feature-value">
							<span><?php echo esc_html($post_features['project_surface'] . ' m2'); ?></span>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($post_features['project_rooms']) : ?>
					<div class="projects-archive__item__feature">
						<div class="projects-archive__item__feature-icon">
							<?php echo SvgHelper::get_svg('assets/icons/house-icon.svg'); ?>
						</div>
						<div class="projects-archive__item__feature-value">
							<span><?php echo esc_html($post_features['project_rooms'] . ' Ambientes'); ?></span>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($post_features['project_services']) : ?>
					<div class="projects-archive__item__feature">
						<div class="projects-archive__item__feature-icon">
							<?php echo SvgHelper::get_svg('assets/icons/worker-icon.svg'); ?>
						</div>
						<div class="projects-archive__item__feature-value">
							<span><?php echo esc_html($post_features['project_services']); ?></span>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="projects-archive__item__buttons">
				<a href="<?php the_permalink(); ?>" class="projects-archive__item__cta button button--primary">
					<?php esc_html_e( 'Ver', 'techarq-blocks' ); ?>
				</a>
			</div>
		</div>
	</div>
</article>