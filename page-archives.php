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
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/vendor/jquery.als-2.1.min.js" ></script>
<main id="main" class="site-main">	
	<div class="topic-head mt-4" id="page-archives">

		<div class="container">

			<h2>Yearly Archives</h2>

		</div>

	</div>

	<?php get_template_part("template-parts/sidebar-archives"); ?>

</main>

<style>
/* plus minus in accordion */
    
    .collapser-button[aria-expanded="true"] > span::after {
      content: "\00a0\00a0";
	  float:left;
	  background-repeat:no-repeat;
	  background-position:center center;
	  background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%23333' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' d='M0 8a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H1a1 1 0 0 1-1-1z' clip-rule='evenodd'/%3e%3c/svg%3e");
    }
	.collapser-button[aria-expanded="false"] > span::after {
      content: "\00a0\00a0";
	  float:left;
	  background-repeat:no-repeat;
	  background-position:center center;
	  background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%23333' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' d='M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z' clip-rule='evenodd'/%3e%3c/svg%3e");      
    }
</style>		

<?php
get_footer();
?>