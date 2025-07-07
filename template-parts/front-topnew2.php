<?php
	//main query, for carousel and front top
	$ftn_args = [
		'tag' => 'front',
		'posts_per_page' => 7,
	];
	$ftn_query = new WP_Query($ftn_args);
?>
				
<!--FRONT TOP 2-->
<section class="d-none d-lg-flex ftnSectionContainer">
<?php
//handle the thumbnail URL if none available
function a_get_the_post_thumbnail_url(){
	$th = get_the_post_thumbnail_url(get_the_ID(),"large");
	if($th !== false){
		$return = $th;
	}else{
		$return = wp_get_attachment_image_url(1007,"large");
	}
	return $return;
}

//NEW
$ftn_cards = '';
$ftn_slides = '';
$ftn_script = '';
if ( $ftn_query->have_posts() ) : 
	while ( $ftn_query->have_posts() ) : $ftn_query->the_post();
		$ftn_ID = get_the_ID();
		$ftn_SM = akseki_get_SM($ftn_ID);
		$ftn_title = strip_tags(get_the_title());
		
		//displaying category description
		$aa = [];
		$ftn_categories = get_the_category();
		$cats = akseki_get_ministrial_categories();
		$cats[] = 'summit-level-statements';
		foreach($ftn_categories as $cat){
			$aa[] = $cat->slug;
		}
		$ab = array_intersect($aa, $cats);
		$catObj = get_category_by_slug(implode($ab));
		if(!empty($catObj)){
			$ad = $catObj->description;
		}else{
			$ad = "";
		}
		
		//displaying the title
		if(!empty($ab)){
			//$ab not empty->is ministerial or summit
			if(empty($ftn_SM)){				
				$ftn_smornot = akseki_get_shortname($ftn_title, $ftn_ID, 7);
			}else{
				$ftn_smornot = $ftn_SM;
			}
		}else{
			//$ab empty, neither ministerial nor summit
			$ftn_smornot = $ftn_title;			
		}
		$ftn_smornot = preg_replace('/\s+/', '&nbsp;', $ftn_smornot);
		$ftn_smornot = preg_replace('/-/', '&#8209;', $ftn_smornot);
		
		//print em out
		$ftn_slide = '<h3 class="mb-0 pb-0 pt-1 text-dark">'.$ftn_smornot.'</h3>';			
		$ftn_slide .= '<p class="my-0 py-0 text-dark">'.akseki_get_the_meta($ftn_ID).'</p>';
		$ftn_slide .= '<p class="mb-0 pb-0 pt-2"><em>'.$ad.'</em></p>';	
		
		$ftn_cards .= '<div class="boxImgCon"><img id="img_'.$ftn_ID.'" class="focusImages focusImagesInit" src="'.a_get_the_post_thumbnail_url().'" alt="'.$ftn_title.'"/></div>';
		$ftn_slides .= '<div class="ftn_slides ml-3" id="ftn_'.$ftn_ID.'">'.$ftn_slide.'</div>';
		$ftn_script .= '<script type="text/javascript">	
			jQuery(function($) {
				
				jQuery(".ftn_slides").hide();
				jQuery( ".imageCollage #img_'.$ftn_ID.'" ).hover(
					function() {
						$( "#ftn_'.$ftn_ID.'" ).show();
						$( "#ftn_'.$ftn_ID.'" ).animate({"width": "500px"},1000);
						
						//Focus in the image
						$(this).addClass( "focusIn" );
						$(this).removeClass( "focusOut" );
						$(this).removeClass( "focusImagesInit" );
						
						//Focus out other images
						$(".focusImagesInit").addClass("focusOut");
					},
					function() {
						$( "#ftn_'.$ftn_ID.'" ).hide();
						//Focus out the image
						$(this).removeClass( "focusIn" );
						$(this).addClass( "focusOut" );
					}
				)
				jQuery( ".imageCollage #img_'.$ftn_ID.'" ).click(function(){
					location.href="'.get_the_permalink().'";
				});
			});
		</script>';
	endwhile;
endif;
?>

<div class="d-flex mainContainer container">
	<div class="boxContainer col-5 d-flex align-items-end">
		<div class="box">
			<h1 class="text-primary">ASEAN Plus Three</h1>	
			<hr class="text-primary mt-1 mb-2" style="border-top:2px solid #98294b">
			<p>
				<a class="smoothscroll" href="#front-about"><span class="dashicons dashicons-info-outline"></span>&nbsp;About</a>&nbsp;&nbsp;
				<a class="smoothscroll" href="#front-news"><span class="dashicons dashicons-rss"></span>&nbsp;News</a>&nbsp;&nbsp;
				<a class="smoothscroll" href="#front-resources"><span class="dashicons dashicons-portfolio"></span>&nbsp;Resources</a>&nbsp;&nbsp;
				<a class="smoothscroll" href="#front-events"><span class="dashicons dashicons-calendar-alt"></span>&nbsp;Agenda</a>
			</p>
		</div>
	</div>
	<div class="col-7 imageCollageContainer">
		<div class="imageCollage">
			<?php echo($ftn_cards);?>
		</div>
	</div>
	<?php echo($ftn_slides);?>
	<?php echo($ftn_script);?>
</div>

<style>
.ftnSectionContainer{
	background:url("<?php echo(get_template_directory_uri().'/img/mb.png'); ?>") no-repeat left center;
	background-size: contain;
	overflow:hidden;
}
.mainContainer{	
	height:100vh;
	width:100%;
	position:relative;
	}
.box{margin-bottom:80px;}
.boxContainer{height:100vh;}
.box h1{
	font-size:2.4em;
	text-shadow: 2px 2px 4px grey;
}
.imageCollageContainer{
	padding-top:120px;
}
.imageCollage {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	margin: 0 auto;
	max-width:900px;
	transform: rotate(-10deg) scale(1.1) translateX(120px);
	box-shadow: rgb(0 0 0 / 25%) 0px 14px 28px, rgb(0 0 0 / 22%) 0px 10px 10px;
	
}
.imageCollage img{
	/*filter: opacity(55%);*/	
}
.imageCollage img, .imageCollage .boxImgCon{
  height: 200px;
  flex-grow: 1;
  object-fit: cover;
  margin: 2px;
  display:flex;
  position:relative;
  overflow:hidden;
  cursor: pointer; 
}
.boxImgCon{}
.inboxText{
	position:absolute;
	bottom:0;
	background-color:white;
	padding:.5px;
}
.imageCollage .focusImages{}
.imageCollage .focusIn{
	transform:rotate(10deg) scale(1.5);	
	opacity:1;
	transition: 1s;
}
.imageCollage .focusOut{
	opacity:.5;
	transition: 1s;
}
.ftn_slides{
	position:absolute;
	top:45%;
	display:none;
}
.ftn_slides p, .ftn_slides h1{
	line-height:1;
	white-space: nowrap;
	display:block;
}

</style>
</section>

<!--OLD TOP-->
<div class="d-flex d-lg-none align-content-center flex-column m-0 p-0 ger" id="front-top">
				<div class="row p-0 m-0" id="fc-row">	
					
					<!--front old-->
					
					<div class="col-12 p-0 m-0" id="fc-col">
												
						
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
							<?php $post_count = $ftn_query->post_count; ?>
							<?php 
							$keyy=0;
							while($keyy <= $post_count){
								//echo('<br>'.$key.'<br>');
								echo('<li data-target="#carouselExampleIndicators" data-slide-to="'.$keyy.'" class="'.($keyy==0 ? "active" : "").'"></li>');
								$keyy++;
							}
							?>
							
							
							</ol>
							<div class="carousel-inner d-flex align-items-center">
							<?php
							$key=0;
							if ( $ftn_query->have_posts() ) : 
								while ( $ftn_query->have_posts() ) : $ftn_query->the_post();
							?>
													
								<div class="carousel-item<?php echo($key==0 ? " active" : ""); ?>">
									
									<div class="row" style="background: white url('<?php echo a_get_the_post_thumbnail_url() ?>') no-repeat center center;background-size:cover;">
									
										
										
										<div class="carousel-item-image-container col-12">
											<img class="w-100" src="<?php echo a_get_the_post_thumbnail_url() ?>" alt="<?php echo get_the_title() ?>"/>
										</div>
										<div class="carousel-caption d-md-block text-left pb-0 mb-0 w-100">
											<div class="d-flex align-content-center flex-wrap" style="margin:0 auto;">
												<div class="w-100">
													<div class="">
														<div class="captionbg">
															<h3 class="d-block caption-title font-weight-bold w-100"><a class="" href="<?php echo get_post_permalink(); ?>"><?php echo get_the_title() ?></a></h3>
															
															<p class="w-100 front-top-meta akseki-meta mb-0">
															<?php echo(akseki_get_the_meta(get_the_ID())); ?>
															</p>
														</div>
													</div>
													<div class="col-4">
														
													</div>
												</div>
											</div>
										</div>
									
									</div>
									
								</div>							
							<?php 
								$key++;
								endwhile;
							endif; 
							?>
							
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
						<a class="smoothscroll" href="#front-about">About&nbsp;<i class="fas fa-info-circle"></i></a>
						<a class="smoothscroll" href="#front-news">News&nbsp;<i class="fas fa-newspaper"></i></a>
						<a class="smoothscroll" href="#front-resources">Resources&nbsp;<i class="fas fa-file-download"></i></a>
						<a class="smoothscroll" href="#front-events">Agenda&nbsp;<i class="far fa-bell"></i></a>
					</div>
					
					
				</div>
</div>

<?php wp_reset_postdata(); ?>