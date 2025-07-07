<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

	<main id="main" class="site-main site-single">
		<div class="container">
			
			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/detail' );

			endwhile; // End of the loop.
			?>

		</div>
	</main><!-- #main -->

<?php
get_footer(); ?>
