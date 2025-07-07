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
		
			<!-- CAROUSEL AND SEARCH-->
			<div class="d-flex align-content-center flex-column m-0 p-0" id="front-top">
				<div class="container d-flex align-content-center flex-wrap">
				<div class="row p-0 m-0 w-100" id="fc-row">					
					<div class="col-12 p-0 m-0" id="fc-col">
						<?php						
						global $post;
						$args = [
							'tag' => 'front'
						];
						$myposts = get_posts( $args );
						?>						
                    
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
							
							<?php foreach( $myposts as $key=>$post ) :  setup_postdata($post); 	?>
							
								<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo($key); ?>" class="<?php echo($key==0 ? "active" : ""); ?>"></li>
							
							<?php endforeach; ?>
							
							</ol>
							<div class="carousel-inner d-flex align-items-center">
							
							<?php foreach( $myposts as $key=>$post ) :  setup_postdata($post); 	?>							
							
								<div class="carousel-item<?php echo($key==0 ? " active" : ""); ?>">
									
									<div class="row" style="background: white url('<?php echo get_the_post_thumbnail_url( $post->ID) ?>') no-repeat center center;background-size:contain;">
									
										
										
										<div class="carousel-item-image-container col-12 h-100">
											<img class="w-100 d-none" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ) ?>" alt="<?php echo get_the_title( $post->ID ) ?>"/>
										</div>
										<div class="carousel-caption d-md-block text-left pb-0 mb-0 w-100">
											
												<div class="row w-100">
													<div class="col-8 text-primary">
														<div class="captionbg">
															<h3 class="d-block caption-title font-weight-bold w-100"><a class="text-white" href="<?php echo get_post_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ) ?></a></h3>
															
															
															<?php
															$mec_location = get_post_meta($post->ID, 'mec_location', true);
															if($mec_location){
																$mec_text = get_term($mec_location)->name.', ';
															}else{
																$mec_text = '';
															}
															?>
															<p class="w-100 front-top-meta text-white mb-0"><?php echo($mec_text.get_the_date()); ?></p>
														</div>
													</div>
													<div class="col-4">
														
													</div>
												</div>
											
										</div>
									
									</div>
									
								</div>							
							
							<?php endforeach; ?>
							<?php wp_reset_postdata(); ?>
							</div>
						  
							<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
					</div>
					<div class="fixed-buttons-front">
						<a class="smoothscroll" href="#front-news"><i class="fas fa-newspaper"></i>News</a>
						<a class="smoothscroll" href="#front-resources"><i class="fas fa-arrow-down"></i>Resources</a>
						<a class="smoothscroll" href="#front-events"><i class="fas fa-arrow-down"></i>Events</a>
					</div>
				</div>
				</div>
			</div>
			
			<!-- FLAGS -->
			<!--div class="topic-head">
				<div class="container">
					<h2>Member Countries</h2>
				</div>
			</div>
			<div class="container">
				
				<div class="row">
					<div class="col-12 ">
						<div id="flags" class="d-flex justify-content-around w-100">
							<?php get_template_part("img/flags/bn.svg"); ?>
							<?php get_template_part("img/flags/kh.svg"); ?>
							<?php get_template_part("img/flags/id.svg"); ?>
							<?php get_template_part("img/flags/my.svg"); ?>
							<?php get_template_part("img/flags/mm.svg"); ?>
							<?php get_template_part("img/flags/ph.svg"); ?>
							<?php get_template_part("img/flags/sg.svg"); ?>
							<?php get_template_part("img/flags/th.svg"); ?>
							<?php get_template_part("img/flags/vn.svg"); ?>
							<?php get_template_part("img/flags/cn.svg"); ?>
							<?php get_template_part("img/flags/jp.svg"); ?>
							<?php get_template_part("img/flags/kr.svg"); ?>
						</div>
					</div>
				</div>
			</div-->
			
			<!--LATEST NEWS DD-->
			<div class="topic-head" id="front-news">
				<div class="container">
					<h2>News</h2>
				</div>
			</div>
			<div class="container">				
				<div id="latestnewsCarousel" class="owl-carousel">					
					<?php			
					//only include ministerial and summit cats
                    $fpn_cats = akseki_get_ministrial_categories();
                    array_push($fpn_cats,'summit-level-statements','news');
					$latest_args = [
						'post_type' => 'post',
						'post_status' => 'publish',
						'cat' => 10,
						'order'=>'DESC',
						'posts_per_page' => 12,
						'category_name'=> implode( ',', $fpn_cats )
					];										
					$latest_query = new WP_Query( $latest_args ); 
					//$the_query->the_post();
					if ( $latest_query->have_posts() ) : 
						$key = 1;
						while ( $latest_query->have_posts() ) : $latest_query->the_post(); 
							$latest['title'] = get_the_title();
							$latest['id'] = get_the_ID();
							$latest_card = '
								<div class="latest-item m-1 pb-3">
									<div class="card w-100 h-100 shadow-sm" id="card_com-'.get_the_id().'">
										
										<img src="'.get_the_post_thumbnail_url( $latest['id'], "medium_large" ).'" class="card-img-top p-3" alt="'.get_the_title().'"/>
													
										<div class="card-body d-flex justify-content-start flex-column flex-wrap">
											<h5 class="card-title w-100 font-weight-bold"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>
											<span class="caption-title"></span>
											<p class="card-text w-100">'.get_the_excerpt().' &rarr;</p>
										</div>
									</div>
								</div>';
							echo($latest_card);
							++$key;
						endwhile;
					endif;
					wp_reset_postdata(); 
					?>
				</div>					
				
				<script type="text/javascript">				
					jQuery(function($) {						
						$(".owl-carousel").owlCarousel({
							items:3,
							loop:true,
							margin:10,
							autoplay:true,
							autoplayTimeout:1000,
							autoplayHoverPause:true,
							responsiveClass:true,
							responsive:{
								0:{
									items:1									
								},
								640:{
									items:2								
								},
								1000:{
									items:3									
								}
							}
						});						
					});
				</script>
				
				
			</div><!--  -->
			
			<!--RESOURCES-->
			<div class="topic-head">
				<div class="container">
					<h2>Resources</h2>
				</div>
			</div>
			<div class="container" id="resources">
				<div class="row">
					<div class="col-md-4 col-sm-6">
						<div class="card w-100 h-100 shadow-sm bg-primary text-white">										
							<div class="card-body">
								<h2 class="card-title w-100 topic-head">About ASEAN+3</h2>
								<p class="card-text w-100">ASEAN Plus Three (APT) consist of ten ASEAN Member States and the People’s Republic of China, Japan and the Republic of Korea. The APT Cooperation process began in December 1997 and since than has evolve as the main vehicle to promote East Asian Cooperation towards the long-term goal of building an East Asian Community, with ASEAN as the driving force. The APT has become one of the most comprehensive cooperation frameworks in the region, and APT cooperation continue to be broadened and deepened in a wide range of areas, including political-security, trade and investment, finance, energy, tourism, agriculture and forestry, environment, education, health, culture and arts, etc, among others. The APT also supports the implementation of the ASEAN Community Vision 2025.</p>
							</div>
						</div>
					</div>
				
					<div class="col-md-8 col-sm-6">
						<div class="">
							<?php 
							wp_list_categories( array(        
								'exclude' => [1,10,44],
								'title_li' => '',								
							) );														
							?>
							<script type="text/javascript">
								jQuery(function($) {
									$('#resources .cat-item > a').each(function(){										
										let replacement = $(this).attr('title');
										$(this).html(replacement);
									});
								});
							</script>
						</div>
					</div>
				</div>
			</div>
			
			<div class="topic-head" id="front-events">
				<div class="container">
					<h2>Events</h2>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php echo do_shortcode('[MEC id="431"]'); ?>
					</div>
				</div>
				
			</div>
			
		</main><!-- #main -->
	

<?php
get_footer();
