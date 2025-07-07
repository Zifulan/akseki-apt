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
						<h2>News</h2>
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
									if ( has_post_thumbnail() ) {
										$thumb = '<img src="'.get_the_post_thumbnail_url( get_the_ID(), "medium" ).'" class="card-img-top p-3" alt="'.get_the_title().'"/>';
									}else{
										$thumb = '<img src="'.wp_get_attachment_image_src( 1007, "medium" )[0].'" class="card-img-top p-3" alt="'.get_the_title().'"/>';
									} 

									$latest_card = '
										<div class="latest-item pb-3 col-12 col-md-6 col-lg-4">
											<div class="card w-100 h-100 shadow-sm" id="card_com-'.get_the_id().'">
												'.$thumb.'															
												<div class="card-body d-flex justify-content-start flex-column flex-wrap">
													<h5 class="card-title w-100 font-weight-bold"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>
													<span class="caption-title"></span>
													<p class="akseki-meta">'.akseki_get_the_meta(get_the_id()).'</p>
													<p class="card-text w-100">'.get_the_excerpt().'</p>
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
			</section>			
		</main>
<?php
get_footer();
