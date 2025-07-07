<?php
	//$content = get_the_content();
	/*$pattern = '/<div class="wp-block-file">(.*?)<\/div>/';
    if(preg_match_all($pattern, $content, $matches)){
		$docdls = $matches[1];
		$pattern4 = '/wp-block-file__embed\" data=\"(.+?)\" type=\"application/';
		$replacement4 = 'wp-block-file__embed" data="$1#toolbar=1&navpanes=0" type="application';
		$content = preg_replace($pattern4,$replacement4,$content);
	}else{
		$docdl = "";
	}*/
	//get children of ministerial-political category
	$pol_child=get_categories(
		array( 'parent' => 63 )
	);
	//get children of ministerial-economic category
	$eco_child=get_categories(
		array( 'parent' => 47 )
	);
	//get children of ministerial-socio category
	$soc_child=get_categories(
		array( 'parent' => 54 )
	);
	//get current categories
	$curcat = get_the_category(get_the_ID());	
	$curcat_array = wp_list_pluck($curcat, 'term_id');
	$mingab = array();
	$mca_array = array_push($mingab, wp_list_pluck($pol_child, 'term_id'), wp_list_pluck($eco_child, 'term_id'), wp_list_pluck($soc_child, 'term_id'));		
	$mcap = array_reduce($mingab, 'array_merge', array());
	//if SOM
	//children of som-level
	$somcap = get_term_children(280,'category');
    $othlevcap = get_term_children(295,'category');
	//is current category part of a category child? compare gab_child and curcat, get the intersection
	//if ministerial, use $mcap. if summit, use cat id for summit level statement
	if(array_intersect($mcap, $curcat_array)){
		//echo ('it is ministerial');
		$cat_intersect = array_intersect($mcap, $curcat_array);
		$cat_ancestor = "ministerial";
	}else if(in_array('cpr-level',wp_list_pluck($curcat,'slug'))){
		//it is cpr
		$idObj = get_category_by_slug('cpr-level'); 
		$cprid = $idObj->term_id;
		$cat_intersect = array($cprid);
		$cat_ancestor = "cpr";
	}else if(in_array('summit-level-statements',wp_list_pluck($curcat,'slug'))){
		//echo ('it is summit');
		$cat_intersect = array("41");
		$cat_ancestor = "summit";
	}else if(array_intersect($somcap, $curcat_array)){
		//if SOM
		$cat_intersect = array_intersect($somcap, $curcat_array);	
		$cat_ancestor = "som";
	}else if(array_intersect($othlevcap, $curcat_array)){
		//if othlev
		$cat_intersect = array_intersect($othlevcap, $curcat_array);	
		$cat_ancestor = "othlev";
	}else{
		//do not display breadcrumb
		$cat_intersect = array("-1");
		$cat_ancestor = "other";
	}		
	$the_curcat = reset($cat_intersect);
	
	//current category's ancestors, check if ancestor is summit (41) or ministerial (43)
	/*$curcat_anc = get_ancestors($the_curcat,'category');
	if(in_array(41, $curcat_anc)){
		$cat_ancestor = "summit";
	}else if(in_array(43, $curcat_anc)){
		$cat_ancestor = "ministerial";
	}else if(in_array('cpr-level',wp_list_pluck($curcat,'slug'))){
		$cat_ancestor = "cpr";
	}else{
		$cat_ancestor = "other";
	}*/
?>

 
		<div class="row akseki-detail-style1">
			
			<div class="col-md-8">	
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php //the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php
				$SMt = akseki_get_SM($post->ID);
				if($cat_ancestor !== "other"){
					if(empty($SMt)){
						$smornott = akseki_get_shortname(get_the_title(get_the_ID()),get_the_ID(), 7);
					}else{
						$smornott = $SMt;
					}
					echo('<h1 class="fj-title">'.$smornott.', '.get_the_date("Y").'</h1>');
					the_title( '<h2 class="fj-subtitle">', '</h2>' ); 
				}else{
					the_title( '<h1 class="fj-title">', '</h1>' );
				}
				
				//breadcrumb
				get_template_part( 'template-parts/sidebar', 'breadcrumb', $args = array('the_curcat'=>$the_curcat) );
				?>
				<?php //echo the_post_thumbnail( 'large' ); ?>
				<p class="akseki-meta fj-meta"><?php echo akseki_get_the_meta(get_the_ID());?></p>
					<div class="entry-content">
						<?php
						the_content(
							sprintf(
								wp_kses(
									
									__( 'Continue reading<span class="screen-reader-text"> "%s"</span>' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								get_the_title()
							)
						);
						//echo($content);
						
						?>
					</div><!-- .entry-content -->
					<style>
						#post-<?php the_ID(); ?> .wp-block-file object
						{
							/*//visibility:hidden;*/
							display:none;
						}
						.entry-content .flickr-embed-frame
						{
						    display:block;
						    margin: 1em auto !important;
						}
						#post-<?php the_ID(); ?> .wp-block-file a:hover{
							color:white;
							text-decoration:none;	
							padding-right: 1.25em;
						}
						#post-<?php the_ID(); ?> .wp-block-file a:hover:after{
							font-family: "dashicons";
							font-weight: 900;
							content: "\f345";
							position: absolute;
						}
					</style>
					<script>
						jQuery('#post-<?php the_ID(); ?> .wp-block-file a').attr("target", "_blank");
						jQuery('#post-<?php the_ID(); ?> .wp-block-file a').removeAttr("download");
						jQuery('#post-<?php the_ID(); ?> .wp-block-file a').text("Click for the full statement");
					</script>
				</article><!-- #post-<?php the_ID(); ?> -->
			</div>
			
			<div class="col-md-4 sidebar-left order-md-first">
				<div class="sidebar-left-item">
					<a href="#" class="popup-image sidebar-left-item">
						<?php 
							if(has_post_thumbnail()):
								echo the_post_thumbnail( 'medium_large' ); 
							else:
								echo '<img src="'.wp_get_attachment_image_url( 1007, "medium_large" ).'" class="attachment-medium_large size-medium_large wp-post-image" sizes="(max-width: 768px) 100vw, 768px" width="768" height="512">';
							endif;
						?>
					</a>
				</div>
				<?php
					/*if(!empty($docdls)){
						foreach($docdls as $docdl){
							echo('<div class="sidebar-left-item docdl"><button class="btn btn-primary text-right"><span class="dashicons dashicons-download mt-1"></span>'.$docdl.'</button></div>');
						}
					}*/
					//for CPR and SOM, note that documents are not for public viewing
					if($cat_ancestor == "cpr" or $cat_ancestor == "som" or $cat_ancestor == "othlev"){
					    $curcat_slug = implode(wp_list_pluck($curcat,'slug'));
						if($curcat_slug !== "apterr"){
							echo('<div class="sidebar-left-item docdl"><em class="btn btn-outline-primary text-right">Documents download is limited.</em></div>');
						}
					}
				?>
				
				<?php
				/*$categories = get_the_category();
				$separator = ' ';
				$output = '';
				if ( ! empty( $categories ) ) {
					echo '<div class="sidebar-left-item">';
					foreach( $categories as $category ) {
						$output .= '<a class="badge badge-pill badge-primary" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
					}
					echo trim( $output, $separator );
					echo '</div>';
				}*/
				?>

				<?php
					//list of categories slug where this list will appear
					/*$appear = akseki_get_ministrial_categories();
					array_push($appear,'summit-level-statements','cpr-level');	
					foreach($categories as $cat){
						if(in_array($cat->slug, $appear)){
							//related by same category
							get_template_part( 'template-parts/sidebar', 'akseki_short-title', $args = array('current_category'=>$the_curcat) );
							//related by same year
							get_template_part( 'template-parts/sidebar', 'akseki_same-year', $args = array('current_year'=>get_the_date('Y')) );
						}
					}*/					
				?>	
				
				<?php
				$categories = get_the_category();
				if ((!empty($categories)) and (in_array($cat_ancestor,["som","cpr","ministerial","summit","othlev"]))) {
					//related by same category
					get_template_part( 'template-parts/sidebar', 'akseki_short-title', $args = array('current_category'=>$the_curcat) );
					//related by same year
					get_template_part( 'template-parts/sidebar', 'akseki_same-year', $args = array('current_year'=>get_the_date('Y')) );
				}
				?>
				
			</div>
			
		</div>
	

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0"><?php echo get_the_title(); ?></h5>
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

