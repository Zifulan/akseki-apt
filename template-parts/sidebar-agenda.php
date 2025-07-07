

<?php 
	//container to be echoed
	$is_tbd = "";
	$is_dtd = "";
	$years = array();
	//the only loop needed
	$catsa = get_term_children(7,"category");
	$catsb = get_term_children(45,"category");
	$SE_cats = array_merge($catsa,$catsb);
	$SE_query = new WP_Query(array(
		'cat'=> $SE_cats,
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
		$firstbutton=0;
		while($SE_query->have_posts()):
			if($whileelement == 1){
				$firstbuttonaria = "true";
			}else{
				$firstbuttonaria = "false";
			}
			
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
			$qcatsarr = wp_list_pluck( $qcats, 'term_id' );
			$qcatint = array_intersect($qcatsarr,$SE_cats);
			$qcatObj = get_category(implode($qcatint)); 
			
			//border, if item is ministerial>secondary, if summit>primary
			$thelevel = akseki_get_level_from_id(get_the_ID(),"post","level");
			$thelevelObj = get_category($thelevel);
			$border = '';
			if($thelevelObj->slug == "summit-level-statements"){
				//echo('<pre>');print_r($thelevelObj);echo('</pre>');
				$border = " border border-primary rounded ";
			}elseif($thelevelObj->slug == "ministerial-level-statements"){
				$border = " border border-dark rounded ";
			}
			
			if($qcatObj->count == 0){
				$catdisp = "";
			}else{
				$catdisp = '<a title="'.$qcatObj->name.' ('.$qcatObj->description.')" class="text-dark font-weight-normal" href="'.get_category_link($qcatObj).'">'.$qcatObj->description.'</a>';
			}	
			if(has_tag("SC_nodate")) {
				//the to be determined ones
				//$is_tbd .= '<span class="bg-light">&ensp;'.get_the_title().'</span><br>';
				$is_tbd .= '<div class="'.$border.'mr-4 row ml-4 mb-1 w-100">
								<div class="col-12 pl-0"><span class="bg-light">&ensp;</span>&ensp;'.$flagdisplay.'&ensp;'.akseki_get_shortname(get_the_title(), get_the_ID()).'</div>
								<div class="col-auto"><em class="badge badge-light">'.$catdisp.'</em></div>
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
					$is_dtd .= '<h3 class="font-weight-bold mt-0 pt-3 mb-1">'.$qyear.'</h3>'; 
					$tempyear = $qyear;
					$tempdtdcount = 1;
				}
				//for ones have month
				if(!has_tag("SC_year")){
					$qmonth = get_the_date('ny');
				}else{
					$qmonth = '13'.get_the_date('y');
				}
				
				if(has_tag('SC_year')){
					$datedisplay = '<span class="bg-light">&ensp;</span>&ensp;<span class="badge badge-light">'.get_the_date('Y').'</span>';
					$collapser = "collapse13".get_the_date('Y');
					$printmonth = True;
				}else if(has_tag('SC_month')){
					$datedisplay = '<span class="bg-secondary">&ensp;</span>&ensp;<span class="badge badge-info">'.get_the_date('F Y').'</span>';
					$printmonth = True;
					$collapser = "collapse".get_the_date('Ym');
				}else{
					//have date-month-year
					$datedisplay = '<span class="bg-secondary">&ensp;</span>&ensp;<span class="badge badge-primary">'.get_the_date('j F Y').'</span>';
					$printmonth = True;
					$collapser = "collapse".get_the_date('Ym');
				}
				
				if($qmonth !== $tempmonth and $printmonth == True){
					if(!has_tag("SC_year")){
						$fy = get_the_date("F Y");
						$collapserid = get_the_date('Ym');
					}else{
						$fy = get_the_date("Y")." tbd";
						$collapserid = '13'.get_the_date('Y');
					}
					$is_dtd .= '<button class="font-weight-bold text-left w-100 btn btn-secondary mb-1 collapser-button" type="button" data-toggle="collapse" data-target="#collapse'.$collapserid.'" aria-expanded="'.$firstbuttonaria.'" aria-controls="collapse'.get_the_date('Ym').'"><span>'.$fy.'</span></button>';
					$tempmonth = $qmonth;
					++$firstbutton;
				}
				
				/*if(has_tag("SC_year") and $prevtagSCyear == false){
					$is_dtd .= '<hr class="my-2 mx-4 w-50">';
				}*/
				if(has_tag("SC_year")){
					$prevtagSCyear = true;
				}else{
					$prevtagSCyear = false;
				}

				$is_dtd .= '<div class="'.$border.'mr-4 row ml-4 mb-1 collapse'.($firstbutton==1?" show":"").'" id="'.$collapser.'">
								<div class="col-12 pl-0">'.$datedisplay.$flagdisplay.'&ensp;'.akseki_get_shortname(get_the_title(), get_the_ID()).'</div>
								<div class="col-auto"><em class="badge badge-light">'.$catdisp.'</em></div>
							</div>';
			}
			
			++$whileelement;
		endwhile;

	endif;
	wp_reset_postdata();
	?>
	
<section class="w-100">	

	<!--EVENTS-->

	

	<div class="container" id="agenda-content">				

		<div id="agenda-inner-content">
		    <?php echo($is_dtd);?>
		    </div><!--close the last element in dtd-->
			<?php if($is_tbd !== ""):?>
				
				<div class="agenda-element">
					<h3 class="mt-0 pt-3 mb-1">to be determined</h3>
						<button class="font-weight-bold text-left w-100 btn btn-secondary mb-1 collapser-button" type="button" data-toggle="collapse" data-target="#collapsetbd" aria-expanded="false" aria-controls="collapsetbd"><span>tbd</span></button>
					
					<div class="row ml-4 mb-1 collapse" id="collapsetbd">
						<?php echo($is_tbd);?>
					</div>
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


	/* plus minus in accordion */
    
    .collapser-button[aria-expanded="true"] > span::after {
      content: "\00a0\00a0";
	  float:right;
	  background-repeat:no-repeat;
	  background-position:center center;
	  background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%23333' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' d='M0 8a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H1a1 1 0 0 1-1-1z' clip-rule='evenodd'/%3e%3c/svg%3e");
    }
	.collapser-button[aria-expanded="false"] > span::after {
      content: "\00a0\00a0";
	  float:right;
	  background-repeat:no-repeat;
	  background-position:center center;
	  background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%23333' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' d='M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z' clip-rule='evenodd'/%3e%3c/svg%3e");      
    }
</style>