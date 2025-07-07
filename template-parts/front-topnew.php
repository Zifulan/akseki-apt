<?php
$ftn_args = [
	'tag' => 'front',
	'posts_per_page' => 7,
];
$ftn_query = new WP_Query($ftn_args);
$ftn_cards = '';
$ftn_slides = '';
$ftn_script = '';
if ( $ftn_query->have_posts() ) : 
	while ( $ftn_query->have_posts() ) : $ftn_query->the_post();
		$ftn_ID = get_the_ID();
		$ftn_SM = akseki_get_SM($ftn_ID);
		$ftn_title = strip_tags(get_the_title());
		if(empty($ftn_SM)){
			$ftn_smornot = akseki_get_shortname($ftn_title, $ftn_ID, 7);
		}else{
			$ftn_smornot = $ftn_SM;
		}
		$ftn_smornot = preg_replace('/\s+/', '&nbsp;', $ftn_smornot);
		$ftn_smornot = preg_replace('/-/', '&#8209;', $ftn_smornot);
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
		
		$ftn_slide = '<h3 class="mb-0 pb-0 pt-1 text-dark">'.$ftn_smornot.'</h3>';			
		$ftn_slide .= '<p class="my-0 py-0 text-dark">'.akseki_get_the_meta($ftn_ID).'</p>';
		$ftn_slide .= '<p class="mb-0 pb-0 pt-2"><em>'.$ad.'</em></p>';	
		
		$ftn_cards .= '<div class="boxImgCon"><img id="img_'.$ftn_ID.'" class="fadeThis" src="'.get_the_post_thumbnail_url( $ftn_ID, 'large' ).'" alt="'.$ftn_title.'"/></div>';
		$ftn_slides .= '<div class="ftn_slides ml-3" id="ftn_'.$ftn_ID.'">'.$ftn_slide.'</div>';
		$ftn_script .= '<script type="text/javascript">	
			jQuery(function($) {
				jQuery(".ftn_slides").hide();
				jQuery( ".imageCollage #img_'.$ftn_ID.'" ).hover(
					function() {
						$( "#ftn_'.$ftn_ID.'" ).show();
						$( "#ftn_'.$ftn_ID.'" ).animate({"width": "500px"},1000);
						$(this).removeClass( "fadeThis" );
						$( ".fadeThis" ).fadeTo( "fast" , 0.3, function() {
							// Animation complete.
						});
					},
					function() {
						$( "#ftn_'.$ftn_ID.'" ).hide();
						$(this).addClass( "fadeThis" );
						$( "#ftn_'.$ftn_ID.'" ).animate({"width": "0px"},10);
						$( ".boxImgCon .fadeThis" ).fadeTo( "fast" , 1, function() {
							// Animation complete.
						});
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
.imageCollage img:hover{
	transform:rotate(10deg) scale(1.5);
	filter: opacity(100%);
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
