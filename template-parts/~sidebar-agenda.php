

<?php 
	//container to be echoed
	$is_tbd = "";
	$is_dtd = "";
	$years = array();
	//the only loop needed
	$SE_cats = akseki_get_ministrial_categories();
	array_push($SE_cats,'summit-level-statements','cpr-level');
	$SE_query = new WP_Query(array(
		'category_name'=> implode( ',', $SE_cats ),
		'post_status' => 'future',
		'orderby'           => 'date',
		'order'             => 'ASC',
		'posts_per_page'=>-1
		)
	);
	if( $SE_query->have_posts() ) :
		$tempyear = $tempmonth = $tempdtdcount = 0;
		$prevtagSCyear = false;
		$whileelement = 1;
		
		while($SE_query->have_posts()):
			$numelement = $SE_query->post_count;
			$SE_query->the_post();		
			
			$flagdisplay = '';
			$mecloc = akseki_get_mec_location(get_the_ID());
			if(empty($mecloc) or $mecloc == '' or $mecloc == 'tbd'){
				$flagdisplay = '';
			}else{
				$flagdisplay = '&ensp;'.akseki_get_the_flag(get_the_ID());
			}
			$qcats = get_the_category();
			$qcatsarr = wp_list_pluck( $qcats, 'slug' );
			$qcatint = array_intersect($qcatsarr,$SE_cats);
			$qcatObj = get_category_by_slug(implode($qcatint)); 
				
			if(has_tag("SC_nodate")) {
				//the to be determined ones
				//$is_tbd .= '<span class="bg-light">&ensp;'.get_the_title().'</span><br>';
				$is_tbd .= '<div class="row ml-4 mb-1">
								<div class="col-12 pl-0"><span class="bg-light">&ensp;</span>&ensp;'.$flagdisplay.'&ensp;'.akseki_get_shortname(get_the_title(), get_the_ID()).'</div>
								<div class="col-auto"><em class="badge badge-light"><a title="'.$qcatObj->name.' ('.$qcatObj->description.')" class="text-dark font-weight-normal" href="'.get_category_link($qcatObj).'">'.$qcatObj->description.'</a></em></div>
							</div>';
			} else {
				
				//for ones have year
				$qyear = get_the_date('Y');
				if($qyear !== $tempyear){
					if($tempdtdcount==0){
						//first element
						$is_dtd .= '<div class="agenda-element">';
					}else{
						//other elements in the middle
						$is_dtd .= '</div><div class="agenda-element">';
					}
					$is_dtd .= '<h3 class="font-weight-bold">'.$qyear.'</h3>'; 
					$tempyear = $qyear;
					$tempdtdcount = 1;
				}
				//for ones have month
				$qmonth = get_the_date('ny');
				
				if(has_tag('SC_year')){
					$datedisplay = '<span class="bg-light">&ensp;</span>&ensp;<span class="badge badge-light">'.get_the_date('Y').'</span>';
					$printmonth = False;
				}else if(has_tag('SC_month')){
					$datedisplay = '<span class="bg-secondary">&ensp;</span>&ensp;<span class="badge badge-info">'.get_the_date('F Y').'</span>';
					$printmonth = True;
				}else{
					$datedisplay = '<span class="bg-secondary">&ensp;</span>&ensp;<span class="badge badge-primary">'.get_the_date('j F Y').'</span>';
					$printmonth = True;
				}
				
				if($qmonth !== $tempmonth and $printmonth == True){
					$is_dtd .= '<h5 class="ml-4 mb-1 mt-2"><span class="badge badge-secondary">'.get_the_date('F').'<span></h5>';
					$tempmonth = $qmonth;
				}
				
				/*if(has_tag("SC_year") and $prevtagSCyear == false){
					$is_dtd .= '<hr class="my-2 mx-4 w-50">';
				}*/
				if(has_tag("SC_year")){
					$prevtagSCyear = true;
				}else{
					$prevtagSCyear = false;
				}
				$is_dtd .= '<div class="row ml-4 mb-1">
								<div class="col-12 pl-0">'.$datedisplay.$flagdisplay.'&ensp;'.akseki_get_shortname(get_the_title(), get_the_ID()).'</div>
								<div class="col-auto"><em class="badge badge-light"><a title="'.$qcatObj->name.' ('.$qcatObj->description.')" class="text-dark font-weight-normal" href="'.get_category_link($qcatObj).'">'.$qcatObj->description.'</a></em></div>
							</div>';
			}
			++$whileelement;
		endwhile;

	endif;
	wp_reset_postdata();
	?>
	
<section>	

	<!--EVENTS-->

	

	<div class="container" id="agenda-content">				

		<div id="agenda-inner-content">
		    <?php echo($is_dtd);?>
		    </div><!--close the last element in dtd-->
			<?php if($is_tbd !== ""):?>
				
				<div class="agenda-element">
					<h3 class="mt-3">to be determined</h3>
					<?php echo($is_tbd);?>
				</div>
			<?php endif;?>
		</div>

											

	</div>

</section>

<style>

#agenda-inner-content .numberer{font-weight:normal;font-size:1em;}
#agenda-inner-content em{white-space: normal;text-align: left;}
#agenda-inner-content{padding-top:2em;}
@media only screen and (min-width: 950px) {
	#agenda-inner-content{column-count:2;}
	#agenda-inner-content .agenda-element{break-inside: avoid;margin-bottom:1em;}
}
</style>