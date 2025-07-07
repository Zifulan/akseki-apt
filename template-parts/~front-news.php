			<div class="container">				
				<div id="latestnewsCarousel" class="owl-carousel owl-theme">					
					<?php		
					$fpn_cats = akseki_get_ministrial_categories();
                    array_push($fpn_cats,'summit-level-statements','news');
					$latest_args = [
						'post_type' => 'post',
						'post_status' => 'publish',
						/*'cat' => 10,*/
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
							if(has_post_thumbnail()):
								$thethumb = get_the_post_thumbnail_url( $latest['id'], "medium_large" ); 
							else:
								$thethumb = wp_get_attachment_image_url( 1007, "medium_large" );
							endif;
							$latest_card = '
								<div class="latest-item m-1 pb-3">
									<div class="card w-100 h-100 shadow-sm" id="card_com-'.get_the_id().'">
										
										<img src="'.$thethumb.'" class="card-img-top p-3" alt="'.get_the_title().'"/>
													
										<div class="pt-2 card-body d-flex justify-content-start flex-column flex-wrap">
											<span class="caption-title"></span>
											<h5 class="card-title w-100 font-weight-bold"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>
											
											<p class="akseki-meta">'.akseki_get_the_meta($latest["id"]).'</p>
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
				<div class="text-center mt-4">				
					<!--a class="btn btn-primary shadow" href="<?php echo get_category_link(10);?>">See all News</a-->
					<a class="btn btn-primary shadow" href="/news-2">See all News</a>
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