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
	<script type="text/javascript">
		
		
		
		//smooth scrolling
		jQuery(function($) {
			//var viewportWidth = window.innerWidth;
			//var viewportHeight = $(window).height();
			//console.log(viewportHeight);
			$('.smoothscroll').click(function(){
				$('html, body').animate({
					scrollTop: $( $(this).attr('href') ).offset().top
				}, 500);
				return false;
			});
			
			//$("#front-top").height(viewportHeight);
			
		});
	</script>
	
		<main id="main" class="site-main">
		    
		    <?php get_template_part("template-parts/front-topnew3"); ?>	
			<!--LATEST NEWS-->
			<section>
				<div class="topic-head" id="front-news">
					<div class="container">
						<h2>APT Latest News & Activities</h2>
					</div>
				</div>
				<?php get_template_part("template-parts/front-news"); ?>
			</section>
			<section>	
				<!--ABOUT-->
				<div class="topic-head" id="front-about" style="border-bottom:none;">
					<div class="container">
						<!--h2>About ASEAN+3</h2-->
					</div>
				</div>
				<?php get_template_part("template-parts/front-about"); ?>
			</section>
			<section>	
				<!--RESOURCES NEW-->
				<div class="topic-head" id="front-resources" style="border-bottom:none;">
					<div class="container">
						<h2>Resources</h2>
					</div>
				</div>
				<?php get_template_part("template-parts/front-resources2"); ?>
			</section>
			
			<section>	
				<!--EVENTS-->
				<div class="topic-head" id="front-events">
					<div class="container">
						<h2>Agenda</h2>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<?php /*
						<div class="col-12">
							<?php echo do_shortcode('[MEC id="431"]'); ?>
						</div>
						*/?>
						<?php get_template_part("template-parts/sidebar-agenda"); ?>
					</div>
					
				</div>
			</section>
			
		</main><!-- #main -->
	

<?php
get_footer();
