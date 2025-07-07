			<div class="container">				
				<div id="latestnewsCarousel" class="owl-carousel owl-theme">					
					<?php		
					$descats = get_categories(array('child_of' => 7));
					$descats_arr = wp_list_pluck($descats, 'slug');
					$fpn_cats = akseki_get_ministrial_categories();
                    array_push($fpn_cats,'summit-level-statements','news');
					$latest_args = [
						'post_type' => 'post',
						'post_status' => 'publish',
						/*'cat' => 10,*/
						'order'=>'DESC',
						'posts_per_page' => 12,
						'category_name'=> implode( ',', $descats_arr )
					];										
					$latest_query = new WP_Query( $latest_args ); 
					//$the_query->the_post();
					if ( $latest_query->have_posts() ) : 
						$key = 1;
						while ( $latest_query->have_posts() ) : $latest_query->the_post(); 
							$latest['title'] = get_the_title();
							$latest['id'] = get_the_ID();
							$curcats =  get_the_category();
							$catspluck =  wp_list_pluck($curcats, 'term_id');
							$latest['category'] = get_category(akseki_get_descat($catspluck));
							$latest['permalink'] = get_the_permalink();
							$latest['shortname'] = akseki_get_shortname($latest["title"],$latest["id"],0);
							//level
							$levobj=get_category(akseki_get_level_from_id($latest['id'],'post'));
							if($levobj){
								$ll='<p class="card-text w-100 border-bottom pb-1 mb-1">Level: <a class="font-italic" href="'.get_category_link($levobj->term_id).'">'.$levobj->name.'</a></p>';
							}else{
								$ll='';
							}
							//pillar
							$pilobj=get_category(akseki_get_level_from_id($latest['id'],'post','pillar'));
							if($pilobj){
								$lp='<p class="card-text w-100 border-bottom pb-1 mb-1">Pillar: <a class="font-italic" href="'.get_category_link($pilobj->term_id).'">'.$pilobj->name.'</a></p>';
							}else{
								$lp='';
							}
							//theme
							$thmid = akseki_get_theme_from_id($latest['id'],'post');
							if(!empty($thmid)){
								$thmobj=get_post(akseki_get_theme_from_id($latest['id'],'post'));
								$lt='<p class="card-text w-100 border-bottom pb-1 mb-1">Theme: <a class="font-italic" href="'.get_permalink($thmobj->ID).'">'.$thmobj->post_title.'</a></p>';
							}else{
								$lt='';
							}
							
							//read more button
							if(!has_tag("hasnocontent")){
								$readmore = '<p class="text-center pt-2 mb-0"><a class="btn btn-primary shadow w-auto" href="'.$latest["permalink"].'">Read more</a></p>';
							}else{			
								$readmore = '';
							}
							
							$latest['cardbg'] = '';
							if($levobj->name=='Ministerial-level Statements'){
								$latest['cardbg'] = ' bg-light';
							}elseif($levobj->name=='Summit Level Statements'){
								$latest['cardbg'] = ' bg-secondary';
							}
							if($latest['shortname'] !== $latest['title']){
								$st = '<span class="caption-title d-block pt-0"></span><h6 class="card-title w-100 pt-1">'.$latest["title"].'</h6>';
							}else{
								$st = '';
							}
							if(has_post_thumbnail()):
								$thethumb = get_the_post_thumbnail_url( $latest['id'], "medium_large" ); 
							else:
								$thethumb = wp_get_attachment_image_url( 1007, "medium_large" );
							endif;
							$latest_card = '
								<div class="latest-item m-1 pb-3">
									<div class="card w-100 h-100 shadow-sm'.$latest['cardbg'].'" id="card_com-'.get_the_id().'">
										
										<img src="'.$thethumb.'" class="card-img-top p-3" alt="'.get_the_title().'"/>
													
										<div class="pt-2 card-body">
											<h3>'.akseki_get_shortname($latest["title"],$latest["id"],0).'</h3>'
											.$st.
											'<p class="akseki-meta rounded">'.akseki_get_the_meta($latest["id"]).'</p>
											'.$ll.$lp.$lt.'
											

											<p class="card-text w-100 border-bottom pb-1 mb-1">Topic: <a class="font-italic" href="'.get_category_link($latest["category"]).'">'.$latest["category"]->description.'</a></p>
											'.$readmore.'
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
						autoplayTimeout:6000,
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