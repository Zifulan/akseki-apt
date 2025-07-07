<?php get_header(); ?>


	<main id="main" class="site-main search-listing">
		<div class="container" id="avi-content">
		<?php
		if ( have_posts() ) {

			// Load posts loop.
			while ( have_posts() ) {
				the_post();		
				get_template_part( 'template-parts/listings' );
			}		

		} else {

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/notfound' );

		}
		?>
		</div>	
	</main><!-- .site-main -->


<?php get_footer(); ?>