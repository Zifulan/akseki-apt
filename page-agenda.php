<?php
get_header();
?>
<script type="text/javascript">	

	//smooth scrolling

	jQuery(function($) {			

		$('.smoothscroll').click(function(){

			$('html, body').animate({

				scrollTop: $( $(this).attr('href') ).offset().top

			}, 500);

			return false;

		});			

	});

</script>	

<main id="main" class="site-main">	
	<div class="topic-head mt-4" id="page-agenda">
		<div class="container">
			<h2>Agenda</h2>
		</div>
	</div>
	<?php get_template_part("template-parts/sidebar-agenda"); ?>
</main>

		

<?php
get_footer();
?>