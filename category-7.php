<?php get_header(); 
$thisCat = get_queried_object();
?>
<main id="main" class="site-main">
	<?php
	$indexlimit = 8;
	$sls = [];
	$mls = [];
	while ( have_posts() ):
		the_post();					
		if(in_category(41)){
			//get the summit levels
			array_push($sls,get_the_ID());			
		}else if(has_category(akseki_get_ministrial_categories())){
			//get the ministerial levels
			array_push($mls,get_the_ID());
		}
	endwhile;
	?>
		<div class="topic-head mt-4">
			<div class="container mt-4">
				<h2><?php echo($thisCat->name);?></h2>		
			</div>
		</div>
		<div class="container pt-4" id="category-7">
			<?php if ( have_posts() ) : ?>
				<div class="row">
					<div class="col-12 col-md-6">
						<h3 class="mt-3">Latest Summit Level Statements:</h3>
						<?php if(!empty($sls)):?>
						<div class="accordion mb-3" id="accordionS">
						<?php 
						$sls_out = [];
						
						//iterate on the markers first
						foreach($sls as $i=>$sl):
							if(has_tag('marker', $sl)){
								echo('<div class="card"><div class="card-header bg-light" id="heading'.$sl.'"><h2 class="mb-0">');
								echo('<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse'.$sl.'" aria-expanded="true" aria-controls="collapse'.$sl.'">');
								echo(akseki_get_Shortname(get_the_title($sl),$sl,6));
								echo(' <em class="float-right">'.get_the_date("Y",$sl).'</em>');
								echo('</button></h2></div>');
								echo('<div id="collapse'.$sl.'" class="collapse '.($i!=0 ?: "show").'" aria-labelledby="heading'.$sl.'" data-parent="#accordionS"><div class="card-body">');
								echo('<ul id="'.get_the_date("Ym",$sl).'"><li><a href="'.get_the_permalink($sl).'">'.get_the_title($sl).'</a></li></ul>');        
								echo('</div></div></div>');								
							}
							if($i>=$indexlimit) break;
						endforeach;
						//iterate on the non markers and append it with js
						foreach($sls as $sl):
							if(has_tag('marker', $sl) == False ){
								//find the suitable card to nest in
								$thedate = get_the_date("Ym",$sl);
								$nonmarker = "<li><a href='".get_the_permalink($sl)."'>".get_the_title($sl)."</a></li>";
								/*echo('<script type="javascript">
									jQuery(document).ready(function(){
										if($("#'.$thedate.'").length){
											alert("ok");
											$("#'.$thedate.'").append("'.$nonmarker.'");
										}
									});
									</script>'
								);*/
								echo('<script>
									jQuery(document).ready(function(){				if( jQuery("#'.$thedate.'").length ){
											
											jQuery("#'.$thedate.'").append("'.$nonmarker.'");
										}
									});
									</script>');
								
							}
							if($i>=$indexlimit+2) break;
						endforeach;
						?>
						<a href="<?php echo(get_category_link(41)); ?>" class="border shadow btn btn-light rounded w-100 mt-2"><em>More Summit Level Statements&hellip;</em></a>
						</div>
						
						<?php endif; ?>
						
					</div>
					<div class="col-12 col-md-6">
						<h3 class="mt-3">Latest Ministerial Level Statements:</h3>
						<?php if(!empty($mls)):?>						
						<?php
						echo('<ul class="mb-3">');
						foreach($mls as $i=>$ml):
							echo('<li><a href="'.get_the_permalink($ml).'">'.get_the_title($ml).'</a></li>');        
							if($i>=4) break;
						endforeach;
						echo('</ul>');
						?>
						<a href="<?php echo(get_category_link(43)); ?>" class="border shadow btn btn-light rounded w-100"><em>More Ministerial Level Statements&hellip;</em></a>
						<hr>
						<?php endif; ?>
						
						<h5>Activities at other levels:</h5>
						<div class="container">
						<div class="row">
							<?php
							$children=get_categories(array('parent'=>7));
							$exclude=[41,43];
							foreach($children as $child){								
								if(!in_array($child->term_id,$exclude)){
									echo('<a href="'.get_category_link($child).'" class="shadow border btn btn-light col align-middle d-flex align-items-center justify-content-center">'.$child->name.'</a>&ensp;');
								}
							}
							//echo('<pre>');print_r($children);echo('</pre>');
							?>
							
							
						</div>						
						</div>						
						

						<?php
						//per pillar, won't use
						/*
						echo('<h5>Per Sector:</h5>');
						$child_categories=get_categories(
							array( 'parent' => 43 )
						);
						echo('<div class="d-flex justify-content-around">');
						foreach($child_categories as $cc){
							//echo the name and the children in 3 columns							
							echo('<a href="'.get_category_link( $cc->term_id ).'" class="btn btn-secondary m-2">'.$cc->name.'</a>');							
						}
						echo('</div>');	
						*/					
						?>
						
					</div>		
				</div>		
			<?php endif;?>					
		</div>

</main>
<?php get_footer(); ?>
