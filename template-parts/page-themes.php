
<?php
//get custom field
$current_id = get_the_id();
$tpc_pillar = get_post_custom_values( "tpc_pillar", get_the_id());
$tpc_pillar_obj = get_category_by_slug($tpc_pillar[0]);
$tpc_topics = get_post_custom_values( "tpc_topics", get_the_id());
$tpc_topics = explode(",",$tpc_topics[0]);
$dgcatid=377;$wgcatid=373;$mincatid = 43;$somcatid = 280;$othcatid = 295;$ottcatid = 399;$ott_themespageid = 6262;
$dglevel=[];$wglevel=[];$minlevel = [];$somlevel = [];$othlevel = [];$mechanisms = [];
foreach($tpc_topics as $topic){
	$to = get_category_by_slug($topic);
	$ta = get_ancestors($to->term_id,'category');
	if(in_array($mincatid,$ta)){
		$minlevel[] = $to;
	}elseif(in_array($somcatid,$ta)){
		$somlevel[] = $to;
	}elseif(in_array($dgcatid,$ta)){
		$dglevel[] = $to;
	}elseif(in_array($wgcatid,$ta)){
		$wglevel[] = $to;
	}
}
if($current_id == $ott_themespageid){
	$ottchildrenobj = get_categories(array('parent'=>$ottcatid));
	foreach($ottchildrenobj as $child){
		$grandchildren = get_categories(array('parent'=>$child->term_id));
		$mechanisms[$child->cat_name] = $grandchildren;
	}
}else{
    $mechanisms['Ministerial Level'] = $minlevel;
    $mechanisms['SOM Level'] = $somlevel;
    $mechanisms['WG Level'] = $wglevel;
    $mechanisms['DG Level'] = $dglevel;
    $mechanisms['Other'] = $othlevel;
    $mechanisms = array_filter($mechanisms);
}
//mechanisms columns
if(count($mechanisms) == 4){
	$grid = 6;
}elseif(count($mechanisms) == 3){
	$grid = 4;
}elseif(count($mechanisms) == 2){
	$grid = 6;
}else{
	$grid = 12;
}
//latest post in category
function latest_post_in_cat($cat){
	$args = array(
		'posts_per_page' => 1, // we need only the latest post, so get that post only
		'cat' => $cat, // Use the category id, can also replace with category_name which uses category slug
		//'category_name' => 'SLUG OF FOO CATEGORY,
	);
	$q = new WP_Query( $args);
	
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();       
			return get_the_id();
		}
		wp_reset_postdata();
	}

}
function return_post_echo($type, $id, $catperma){
	$return = "";
	if($type == "upcoming"){
		$return .= '<span>'.akseki_get_shortname(get_the_title($id), $id, 0).'</span>';
	}else{
		if(has_tag("hasnocontent")){
			$linkage = $catperma;
		}else{
			$linkage = get_the_permalink($id);
		}
		$return .= '<a class="" href="'.$linkage.'" title="'.strip_tags(get_the_title($id)).'">'.akseki_get_shortname(get_the_title($id), $id,0).'</a>';
		
	}
	$return .= '<br/><em class="small">'.akseki_get_the_meta($id).'</em>';

	return $return;
}
//other themes
$themes = get_children(5733);
$levels = get_categories(array( 'parent' => 7));
$pillars = get_categories(array( 'parent' => 43));

function echo_other_themes($items,$type,$curid){
	$echo_themes = '<ul style="display:inline;padding-left:.5em;">';
	foreach($items as $item){
		if($type == "cats"){
			$id = $item->term_id;
			$title = $item->name;
			$permalink = get_category_link($id);
		}else{
			$id = $item->ID;
			$title = $item->post_title;
			$permalink = get_permalink($id);
		}
		//echo('<pre>');print_r(get_the_id());echo('</pre>');
		if($id !== $curid){
			$echo_themes .= '<li style="display:inline;list-style-type:none;padding-right:.5em;"><a href="'.$permalink.'" class="badge badge-secondary">'.$title.'</a></li>';
		}
	}
	$echo_themes .= '</ul>';
	return $echo_themes;
}
//get description from overview. if not found, use the original from theme pages.
$current_slug = get_post_field( 'post_name', get_post() );
$overview_content = get_post(3363);//echo($overview_content->post_content);
if($current_id == 5733){
	$pillardesc = [];
	$pillars = ["political","economic","socio-cultural"];
	foreach($pillars as $pillar){
		$regexth = '/\<p?\sclass\=[\'|"]tcp_themes_'.$pillar.'.*?\>(.+)?\<\/p\>/';
		preg_match($regexth, $overview_content->post_content, $regexresult);
		$pillardesc[$pillar] = $regexresult[1];
		
	}//echo('<pre>');print_r($pillardesc);echo('</pre>');
}else{
	$regex = '/\<p?\sclass\=[\'|"]tcp_'.$current_slug.'.*?\>.+?\<\/p\>/';
	preg_match_all($regex, $overview_content->post_content, $desc);
}
?>


		<div class="row">
			
			<div class="col-md-12">	
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php if($current_id == 5733): ?>
						<?php the_title( '<h1 class="entry-title">APT Cooperation '.$tpc_pillar_obj->name, '</h1>' ); ?>
					<?php elseif($current_id == $ott_themespageid): ?>
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php else: ?>
						<?php the_title( '<h1 class="entry-title"><a href="'.get_category_link($tpc_pillar_obj->term_id).'" class="badge badge-secondary">'.$tpc_pillar_obj->name.': </a> ', '</h1>' ); ?>
					<?php endif;?>
					
					<hr style="border-bottom:1px gray dotted;margin-bottom:1em;"/>
				</header>
					<div class="entry-content">
						<?php if($current_id == 5733): ?>
						
						<?php
						echo('<div class="row">');
						foreach($pillars as $key=>$pillar){
							echo('<div class="col-lg-4 mb-4">');
							echo('<div class="card bg-light">');
							echo('<div class="card-body">');
							if($pillar == "political"){
							    $pillarname = "political-security";
							}else{
							    $pillarname = $pillar;
							}
							echo('<h2 class="card-title">'.ucfirst($pillarname).' Cooperations</h2><hr>');
							echo('<p class="card-text">'.$pillardesc[$pillar].'</p>');
							//echo('<div class="row"><div class="col-auto pr-0"><strong class="btn font-weight-bold">Themes:</strong></div><div class="col pl-0">');
							echo('<div class="d-flex align-content-around flex-wrap mb-2">');
							foreach($themes as $theme){
								$theme_pillar = get_post_custom_values( "tpc_pillar", $theme->ID);
								
								if($theme_pillar[0] == $pillar.'-cooperations'){
									//print_r($theme);
									echo('<a href="'.get_permalink($theme->ID).'" class="btn btn-primary m-1 flex-fill">');
									echo($theme->post_title);
									echo('</a>');
								}
							}
							echo('</div></div></div></div>');
						}
						
						/*echo('<div class="col-12 mx-3 mt-4">');
						echo('<div class="d-flex align-content-around flex-wrap mb-2">');
						echo('<span class="btn m-1"><strong>See Also: </strong></span>');
						foreach($levels as $level){
							if(!in_array($level->term_id,[$mincatid,$somcatid,$wgcatid,$dgcatid])){
								echo('<a href="'.get_category_link($level->term_id).'" class="btn btn-secondary m-1">'.$level->name.'</a>');
							}
						}						
						echo('</div>');
						echo('</div>');*/
						
						echo('</div>');
						?>

						<?php else: ?>
						<?php
						if(!empty($desc)){
							foreach($desc[0] as $d){
								echo($d);
							}
							//echo('<pre>');print_r($desc);echo('</pre>');
						}elseif(!empty(the_content())){
							
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
						}
						?>
						<h2 class="mt-4">Mechanisms</h2>
						<div class="container">
						<div class="row">
							<?php 
							foreach($mechanisms as $key=>$mech){
								
								echo('<div class="mb-2 col-12 col-lg-'.$grid.'"><div class="card bg-light shadow mt-2">');
								echo('<h4 class="card-header">'.$key.'</h4><ul class="mt-0 pb-4 bg-white list-group list-group-flush">');
								
								foreach($mech as $eachm){
								    
								    //upcoming item
    								$upcoming_item = akseki_get_future_post_in_category($eachm->term_id)[0];
    								
    								//latest item
    								$latest_item = latest_post_in_cat($eachm->term_id);
								    
								    //category permalink
									$catperma = get_category_link($eachm->term_id);
									
								    //if category doesn't have articles, don't display link
								    if($eachm->count !== 0){
								        $eachm_link = '<a href="'.get_category_link($eachm->term_id).'">'.$eachm->name.'</a>';
								    }else{
								        $eachm_link = $eachm->name;
								    }
								    
									echo('<li class="list-group-item"><h5 class="mb-0 mt-2">'.$eachm_link.'</h5><em class="small">'.$eachm->description.'</em>');
									
									//extra category property, if has no listing, don't display
									$cat_extra = get_term_meta( $eachm->term_id, '_catextra', true );
									if($cat_extra !== "has_no_listing"){
									   echo('<div class="card-body border mr-4 mt-2 py-2 rounded">');
									   if(!empty($latest_item)){     
									        echo('<p class="ml-4 mb-0"><span class="badge badge-primary">Latest:</span> '.return_post_echo("latest", latest_post_in_cat($eachm->term_id), $catperma).'</p>');
									    }
									
    									if(!empty($upcoming_item)){
    									echo('<p class="ml-4 mb-0"><span class="mt-3 badge badge-info">Upcoming:</span> <span class="text-muted">'.return_post_echo("upcoming",$upcoming_item, $catperma).'</span></p>');
    									}
    									echo('</div>');
									}
									echo('</li>');
								}
								echo('</ul></div></div>');
							}
							?>
							
						</div>
						</div>
							

						<!--h2>Key Documents</h2-->
						<h2 class="mt-4">Other Places</h2>
						<ul>
							
							<li>Cooperation levels: <?php echo(echo_other_themes($levels,"cats",$current_id)); ?></li>
							<li>Cooperation pillars: <?php echo(echo_other_themes($pillars,"cats",$current_id)); ?></li>
							<li>Other themes: <?php echo(echo_other_themes($themes,"pages",$current_id)); ?></li>
							
						</ul>
						<?php endif; ?>
					</div><!-- .entry-content -->

				</article><!-- #post-<?php the_ID(); ?> -->
			</div>
			
		</div>
<style>
    
</style>