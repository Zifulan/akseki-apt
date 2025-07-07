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
			<section>	
				<!--NEWS-->
				<div class="topic-head mt-4" id="page-news-2">
					<div class="container">
						<h2>APT Latest News & Activities</h2>
					</div>
				</div>
				<div class="container pt-4">
					
						<?php
							//$cats1 = akseki_get_ministrial_categories();
							//$cats2 = akseki_get_commision_categories();
							//$cats = array_merge($cats1,$cats2);
							$paged=(get_query_var('paged'))?get_query_var('paged'):1;
							$latest_query = new WP_Query(array(
												'posts_per_page' => 12,
												'paged'=>$paged,
												'post_type' => 'post',
												'post_status' => 'publish',
												'order'=>'DESC',
												//'nopaging'=>FALSE,
												//'category_name'=>implode(',',$cats),
												'public'   => true
												));
							if ( $latest_query->have_posts() ) : 
							
								echo('<div class="row">');
								
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
										$ll='<p class="card-text w-100 border-bottom pb-2 mb-2">Level: <a class="font-italic" href="'.get_category_link($levobj->term_id).'">'.$levobj->name.'</a></p>';
									}else{
										$ll='';
									}
									//pillar
									$pilobj=get_category(akseki_get_level_from_id($latest['id'],'post','pillar'));
									if($pilobj){
										$lp='<p class="card-text w-100 border-bottom pb-2 mb-2">Pillar: <a class="font-italic" href="'.get_category_link($pilobj->term_id).'">'.$pilobj->name.'</a></p>';
									}else{
										$lp='';
									}
									//theme
									$thmid = akseki_get_theme_from_id($latest['id'],'post');
									if(!empty($thmid)){
										$thmobj=get_post(akseki_get_theme_from_id($latest['id'],'post'));
										$lt='<p class="card-text w-100 border-bottom pb-2 mb-2">Theme: <a class="font-italic" href="'.get_permalink($thmobj->ID).'">'.$thmobj->post_title.'</a></p>';
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
										<div class="latest-item pb-3 col-12 col-md-6 col-lg-4">
											<div class="card w-100 h-100 shadow-sm'.$latest['cardbg'].'" id="card_com-'.get_the_id().'">
										
												<img src="'.$thethumb.'" class="card-img-top p-3" alt="'.get_the_title().'"/>
															
												<div class="pt-2 card-body">
													<h3>'.akseki_get_shortname($latest["title"],$latest["id"],0).'</h3>'
													.$st.
													'<p class="akseki-meta rounded">'.akseki_get_the_meta($latest["id"]).'</p>
													'.$ll.$lp.$lt.'
													

													<p class="card-text w-100 border-bottom pb-2 mb-2">Topic: <a class="font-italic" href="'.get_category_link($latest["category"]).'">'.$latest["category"]->description.'</a></p>
													'.$readmore.'
												</div>
											</div>
										</div>';
									echo($latest_card);
								endwhile;
								
								echo('</div>');
								
								//pagination
								//disassemble paginate_links to have it bootstrapped
								/*function akseki_bootstrapped_pagination($query){
									$currentPage=max(1,get_query_var('paged',1));
									$pages=range(1,max(1,$query->max_num_pages));
									return array_map(function($page)use($currentPage){
										return(object)array(
											"isCurrent"=>$page==$currentPage,
											"page"=>$page,
											"url"=>get_pagenum_link($page)
										);
									},$pages);
								}
								foreach akseki_bootstrapped_pagination($latest_query):
									//loop it
								endforeach;*/
								echo('<div class="row justify-content-center mt-3"><nav id="latest-news-nav" aria-label="Page navigation" class="shadow-sm mb-0">');
								echo paginate_links(
									array(
										'base'=>get_pagenum_link(1).'%_%',
										'format'=>'?paged=%#%',
										'current'=>max(1,get_query_var('paged')),
										'total'=>$latest_query->max_num_pages,
										'type'=>'list',
									)
								);
								echo('</nav></div>');
								//change classes to be bootstrapped
								?>

								<script type="text/javascript">
									jQuery(document).ready(function(jQuery){							
										$('nav#latest-news-nav > ul').removeClass().addClass('pagination mb-0');
										$('nav#latest-news-nav > ul > li').removeClass().addClass('page-item');
										$('nav#latest-news-nav > ul > li > a').removeClass().addClass('page-link');
										$('nav#latest-news-nav > ul > li > span').addClass('page-link');
										$('nav#latest-news-nav > ul > li > span.current').parent('li').addClass('active');
									});
								</script>
								<?php
							endif;
						?>						
					</div>					
				</div>
				<style>
					.caption-title::before {    
						border-bottom:3px solid #98294b;
					}
				</style>
			</section>			
		</main>
<?php
get_footer();
