<?php 
    use TecharqBlocks\Helpers\AdvancedPagination;
?>

<div class="projects-archive js-projects-archive" aria-status='not-init'>
        <?php
			AdvancedPagination::print(
				array(
					'post_type'        => 'proyecto',
					'posts_per_page'   => 4,
					'search'           => false,
					'component'        => 'card',
					'component_parent' => 'ProjectsArchive',
					'prev_button'      => '<',
					'next_button'      => '>',
					'filters'          => array( 'category' ),
					'filters_opt'      => array(
						'prepend' => 'Filter by ',
						'append'  => false,
						'title'   => false,
					),
				)
			);
		?>
</div>
    