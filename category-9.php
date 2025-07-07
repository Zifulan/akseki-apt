<?php get_header(); 
$thisCat = get_queried_object();
?>
<main id="main" class="site-main">
	
		<div class="topic-head mt-4">
			<div class="container mt-4">
				<h2><?php echo($thisCat->name);?></h2>
			</div>
		</div>
		<div class="container pt-4" id="category-9">
			<?php if ( have_posts() ) : ?>
				<div class="row">
					<div class="col-12 col-md-4 d-flex align-items-center rounded bg-secondary text-center">
						<span class="p-2">The ASEAN Plus Three (APT) Cooperation Work Plan serves as a principal guide to enhance APT cooperation over the next five years towards achieving the long-term goal of establishing an East Asia community with ASEAN as the driving force. Consistent with existing regional mechanisms, APT recognises ASEAN Centrality as the driving force in the evolving regional architecture.</span>
					</div>
					<div class="col-12 col-md-8 d-flex align-items-center">
						<ul class="list-group list-group-flush">
						<?php
							while ( have_posts() ):
								the_post();		
								$the_ameta = akseki_get_the_meta(get_the_id());
								echo '<li class="list-group-item w-100">
										<h6 class="w-100 font-weight-bold"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h6>
										<span class="akseki-meta w-100">'.$the_ameta.'</span></li>';
							endwhile;	
						?>	
						</ul>
					</div>		
				</div>		
			<?php endif;?>					
		</div>
	<style>
	.mys {
		text-align:right;
	} 

	@media (max-width: 768px) {
	  .mys {
		text-align:left;
	  } 
	}
	</style>
</main>
<?php get_footer(); ?>
