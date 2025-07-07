<?php
get_header();
?>
	<script type="text/javascript" src="<?php echo(get_template_directory_uri()); ?>/vendor/lazysizes.min.js"></script>
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
		//prevent default on click
		jQuery( ".popup-image" ).click(function( event ) {
			event.preventDefault();
			
		});
	</script>	
		<main id="main" class="site-main">	
			<section>	
				<!--MASONRY GALLERY-->
				<div class="topic-head mt-4" id="page-gallery2">
					<div class="container">
						<h2>Photo Gallery</h2>
					</div>
				</div>
				<div class="container pt-4">
					<div class="row">
						<div class="masonryContainer">
						<?php
							$catsa = get_term_children(7,"category");
							$catsb = get_term_children(45,"category");
							$catsc = array_merge($catsa,$catsb);
							
							$gq = new WP_Query(array(
												'posts_per_page' => -1,
												'cat'=> $catsc,
												'public' => true,
												'orderby' => 'rand',
												));
							if( $gq->have_posts() ) :
								while ( $gq->have_posts() ):
									$gq->the_post();
									//get the title
									$ftn_ID = get_the_ID();
									$ftn_SM = akseki_get_SM($ftn_ID);
									$ftn_title = strip_tags(get_the_title());
									if(empty($ftn_SM)){
										$ftn_smornot = akseki_get_shortname($ftn_title, $ftn_ID, 7);
									}else{
										$ftn_smornot = $ftn_SM;
									}
									//get the meta
									$ftn_meta = akseki_get_the_meta($ftn_ID);
									//print the masonry
									if(has_post_thumbnail()):
										//$thumb = '<div class="masonryInner" id="card_com-'.get_the_id().'">';
										$thumb = '<a id="card_com-'.get_the_id().'" href="##" class="popup-image">';
										$thumb .= '<img data-src="'.get_the_post_thumbnail_url( get_the_id(), "medium_large" ).'" class="masonryImg lazyload" alt="'.get_the_title().'"/>';
										$thumb .= '<div class="innerText text-light p-2"><h5 class="m-0">'.$ftn_smornot.'</h5><small>'.$ftn_meta.'</small></div>';
										$thumb .= '</a>';
										//$thumb .= '</div>';
										echo($thumb);
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
				</div>
			</section>			
		</main>

<style>		
.masonryContainer {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	margin: 0 auto;
	box-shadow: rgb(0 0 0 / 25%) 0px 14px 28px, rgb(0 0 0 / 22%) 0px 10px 10px;
	width:100%;
}
.masonryContainer a{
	overflow:hidden;
	display:flex;
	position:relative;
	height: 200px;
	flex-grow: 1;
	margin:2px;
}
.masonryContainer a .innerText{
	position: absolute;
	bottom: 0;
	right: 0;
	text-align:right;
	line-height:1;
	background: rgba(152, 41, 75, .75);
}
.masonryImg{
  width:100%;
  object-fit: cover;
}
#imagemodal{
	padding-right:0px!important;
}
.masonryImg:hover{
	transform:scale(1.25);
	transition: 1s;
}
</style>

<?php
get_footer();
