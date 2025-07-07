<?php get_header(); ?>


	<main id="main" class="site-main">
		<div class="container" id="avi-content">
		<?php
		if ( have_posts() ) {

			// Load posts loop.
			while ( have_posts() ) {
				the_post();		
				//fallback, if index is loaded
				get_template_part( 'template-parts/single-detail' );		
			}		

		} else {

			// If no content, include the "No posts found"
			get_template_part( 'template-parts/notfound' );

		}
		?>
		</div>	
	</main><!-- .site-main -->


<?php get_footer(); ?>