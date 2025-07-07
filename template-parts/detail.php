<?php
		
	//new method to determine post's category level
	$curcat = get_the_category(get_the_ID());
	$curcat_slugs = wp_list_pluck($curcat, 'slug');
	
	$sumcat = array("summit-level-statements");
	$mincat = akseki_get_ministrial_categories();
	$dgcat = akseki_get_dg_categories();
	$cprcat = array("cpr-level");
	$somcat = akseki_get_som_categories();
	$wgcat = akseki_get_wg_categories();
	$otlcat = akseki_get_othlev_categories();
	$ottcat = akseki_get_ott_categories();
	
	if(array_intersect($sumcat, $curcat_slugs)){
		//echo ('it is summit');
		$cat_intersect = array_intersect($sumcat, $curcat_slugs);
		$cat_ancestor = "summit";
	}else if(array_intersect($mincat, $curcat_slugs)){
		//if Ministrial
		$cat_intersect = array_intersect($mincat, $curcat_slugs);	
		$cat_ancestor = "ministerial";
	}else if(array_intersect($dgcat, $curcat_slugs)){
		//if DG
		$cat_intersect = array_intersect($dgcat, $curcat_slugs);	
		$cat_ancestor = "som";
	}else if(array_intersect($cprcat, $curcat_slugs)){
		//if CPR
		$cat_intersect = array_intersect($cprcat, $curcat_slugs);	
		$cat_ancestor = "cpr";
	}else if(array_intersect($somcat, $curcat_slugs)){
		//if SOM
		$cat_intersect = array_intersect($somcat, $curcat_slugs);	
		$cat_ancestor = "som";
	}else if(array_intersect($wgcat, $curcat_slugs)){
		//if WG
		$cat_intersect = array_intersect($wgcat, $curcat_slugs);	
		$cat_ancestor = "wg";
	}else if(array_intersect($otlcat, $curcat_slugs)){
		//if Other Level
		$cat_intersect = array_intersect($otlcat, $curcat_slugs);	
		$cat_ancestor = "otl";
	}else if(array_intersect($ottcat, $curcat_slugs)){
		//if CPR
		$cat_intersect = array_intersect($ottcat, $curcat_slugs);	
		$cat_ancestor = "ott";
	}else{
		//do not display breadcrumb
		$cat_intersect = array("-1");
		$cat_ancestor = "other";
	}
	
	$cat_intersect = reset($cat_intersect);
	$the_curcat_obj = get_category_by_slug($cat_intersect);
	if(in_array("work-plans-and-plans-of-action",$curcat_slugs)){
		$the_curcat = 9;//work plan category ID
	}else{
		$the_curcat = $the_curcat_obj->term_id;
	}
	
	//if has tag "hasnocontent" redirect to its listing
	if(has_tag("hasnocontent") && $cat_ancestor !== "other"){
		$listing_page = get_category_link($the_curcat);
		echo('<script type="text/javascript">
				jQuery(function($) {
				  window.location.replace("'.$listing_page.'");
				});
			</script>');
	}
	
	//if has tag "hyperlinked" redirect to its source
	$the_source = get_post_custom_values("source");
	if(has_tag("hyperlinked")){
		if(!empty($the_source)){
			echo('<script type="text/javascript">jQuery(function($){window.location.replace("'.$the_source[0].'");});</script>');
		}
	}
	
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
				//only show it on descendants of statements category
				if($cat_ancestor !== "other"){
					get_template_part( 'template-parts/sidebar', 'breadcrumb', $args = array('the_curcat'=>$the_curcat) );
				}
				
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
					
					//for CPR and SOM, note that documents are not for public viewing
					if($cat_ancestor == "cpr" or $cat_ancestor == "som" or $cat_ancestor == "othlev"){
					    $curcat_slug = implode(wp_list_pluck($curcat,'slug'));
						if($curcat_slug !== "apterr"){
							echo('<div class="sidebar-left-item docdl"><em class="btn btn-outline-primary text-right">Documents download is limited.</em></div>');
						}
					}
				
				$categories = get_the_category();
				if (!empty($categories)){
					
					//related by same category for multilevel
					if(in_array($cat_ancestor,["summit","som","wg","cpr","ministerial","otl","ott"]) or in_array("work-plans-and-plans-of-action",$curcat_slugs)){
						get_template_part( 'template-parts/sidebar', 'akseki_short-title', $args = array('current_category'=>$the_curcat) );
						//related by same year
						//get_template_part( 'template-parts/sidebar', 'akseki_same-year', $args = array('current_year'=>get_the_date('Y')) );
					}
					//related by same topic
					//only display in multilevels
					if(in_array($cat_ancestor,["ministerial","som","wg","otl","ott"])){
						get_template_part( 'template-parts/sidebar', 'akseki_same-theme', $args = array('current_category'=>$the_curcat));
					}
				}
				
				//for admin, display the source
				if(is_user_logged_in()){
					echo('<div class="text-success">');
					echo('<h3>Sources</h3>');
					if(!empty($the_source)){
						echo('<ul>');
						foreach($the_source as $source){
							if(str_starts_with($source, 'http')){
								echo('<li><a class="text-success" target="_blank" href="'.$source.'">'.$source.'</a></li>');
							}else{
								echo('<li>'.$source.'</li>');
							}
						}
						echo('</ul>');
					}
					echo('</div>');
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

