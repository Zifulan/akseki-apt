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

				$theme_page_children = get_children(5733);
				//print_r($theme_page_children);
				$tpc_ids = wp_list_pluck( $theme_page_children, 'ID' ); 
				//print_r($tpc_ids);
				//for themes pages
				if(get_the_id() == 5733 or in_array(get_the_id(),$tpc_ids)){
					get_template_part( 'template-parts/page-themes' );
				}else{	
					get_template_part( 'template-parts/page-detail' );
				}

			endwhile; // End of the loop.
			?>

		</div>
	</main><!-- #main -->

<?php
get_footer(); ?>
