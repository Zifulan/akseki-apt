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
				<!--GALLERY-->
				<div class="topic-head mt-4" id="page-gallery2">
					<div class="container">
						<h2>Gallery</h2>
					</div>
				</div>
				<div class="container pt-4">
					<div class="row">
						<?php
							$cats1 = akseki_get_ministrial_categories();
							$cats2 = akseki_get_commision_categories();
							$cats = array_merge($cats1,$cats2);
							//echo('<pre>');print_r($cats);echo('</pre>');
							//echo(implode(',',$cats));
							$gq = new WP_Query(array(
												'posts_per_page' => -1,
												'category_name'=>implode(',',$cats),
												'public'   => true
												));
							if( $gq->have_posts() ) :
								while ( $gq->have_posts() ):
									$gq->the_post();
									/*if(has_post_thumbnail()){
										echo '<img src="'.get_the_post_thumbnail_url( get_the_id(), "medium" ).'" class="card-img-top p-3" alt="'.get_the_title().'"/>';
									}else{
										echo "no image";
									}
									echo(get_the_title());
									echo('<hr/><br/>');*/
									//get_template_part( 'template-parts/listings', 'gallery2' );
									if(has_post_thumbnail()):
										echo '<article id="post-'.get_the_id().'" class="col-md-4">';
										
										$thumb = '<img src="'.get_the_post_thumbnail_url( get_the_id(), "medium" ).'" class="card-img-top p-3" alt="'.get_the_title().'"/>';			
									
										echo '	<div class="latest-item m-1 pb-3">
													<div class="card w-100 h-100 shadow-sm" id="card_com-'.get_the_id().'">
														<a href="#" class="popup-image">';
										echo the_post_thumbnail("medium_large", array('class' => 'w-100 h-auto', 'alt' => get_the_title()));
										echo '			</a>					
														<div class="px-2 py-3 card-body d-flex justify-content-around flex-column flex-wrap">
															<em class="caption-title text-center m-0">'.get_the_title().'</em>
														</div>
													</div>
												</div>';									
										echo '</article>';										
									endif;
								endwhile;
								?>
								<!-- Modal -->
								<div class="modal fade bd-example-modal-lg" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<h5 class="mb-0" id="image-title"></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body text-center">
										<img src="" id="imagepreview" class="img-fluid">
									  </div>
									  <!--div class="modal-footer">
										<p>text</p>
									  </div-->
									</div>
								  </div>
								</div>
								<?php
							endif;
						?>						
					</div>					
				</div>
			</section>			
		</main>
<?php
get_footer();
