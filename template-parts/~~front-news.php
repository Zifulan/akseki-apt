			<div class="container">				
				<div id="latestnewsCarousel" class="owl-carousel owl-theme">					
					<?php						
					$latest_args = [
						'post_type' => 'aptn_news',
						'post_status' => 'publish',
						'order'=>'DESC',
						'posts_per_page'=>12,
						'no_found_rows'=>true
					];										
					$latest_query = new WP_Query( $latest_args ); 
					//$the_query->the_post();
					if ( $latest_query->have_posts() ) : 
						$key = 1;
						while ( $latest_query->have_posts() ) : $latest_query->the_post(); 
							$latest["title"] = get_the_title();
							$latest["id"] = get_the_ID();
							$latest["link"] = implode(',',get_post_custom_values("aptn_link"));
							$latest["source"] = implode(',',get_post_custom_values("aptn_source"));
							if(get_post_meta($latest["id"],'aptn_thumb', true)){
								$feed_image = implode(',',get_post_custom_values("aptn_thumb"));
							}else{
								$feed_image = get_template_directory_uri().'/img/newslogo/'.sanitize_filename($latest["source"]).'.jpg';  	
							}							
							
							$latest_card = '
								<div class="latest-item m-1 pb-3">
									<div class="card w-100 h-100 shadow-sm" id="card_com-'.$latest["id"].'">
										
										<img src="'.$feed_image.'" class="card-img-top p-3" alt="'.$latest["title"].'"/>
													
										<div class="pt-2 card-body d-flex justify-content-start flex-column flex-wrap">
											<span class="caption-title"></span>
											<h5 class="card-title w-100 font-weight-bold"><a target="_blank" href="'.$latest["link"].'">'.get_the_title().'</a></h5>
											
											<small style="border-left:solid .5em #98294b;padding-left:.5em;"><strong><em>'.$latest["source"].'</em></strong> | '.get_the_date().'</small>
											<span class="caption-border mt-3"></span>
											<p class="card-exc mt-2 pt-0 card-text w-100">'.get_the_excerpt().' &rarr;</p>
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
				<div class="text-center mt-4">				
					
					<a class="btn btn-primary shadow" href="/?post_type=aptn_news">More APT in the News&hellip;</a>
				</div>
				
				
				
				
			</div><!--  -->
			
			<script type="text/javascript">	
				
				jQuery(function($) {						
					$("#latestnewsCarousel").owlCarousel({
						items:3,
						loop:true,
						dots:true,	
						dotsEach:true,
						margin:10,
						autoplay:true,
						autoplayTimeout:5000,
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