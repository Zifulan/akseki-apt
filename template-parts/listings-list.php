<?php 
	$thetags = get_the_tags();
	$SM = akseki_get_sm(get_the_id());
	$SC = akseki_get_sc_raw(get_the_id());
	$theleft = akseki_get_shortname(get_the_title(),get_the_id());
	$echotheleft = '<div class="col-auto d-flex flex-column justify-content-start pl-0 pr-2">';
	//handle future post
	$thefuturepost = false;
	if(date('Y-m-d H:i:s', strtotime(get_the_date('Y-m-d H:i:s'))) > date('Y-m-d H:i:s')){
		$thefuturepost = true;
	}
	//handle SPECIAL MEETING
	if(!empty($SM)){
		$echotheleft .= '<span class="counter-badge badge badge-secondary py-2 mt-1 px-3 text-uppercase font-weight-bold">Extra</span>';
	}else{
		$echotheleft .= '<span class="counter-badge badge badge-secondary py-2 mt-1">'.$theleft.'</span>';
	};
	if($thefuturepost && $SC == "SC_nodate"){
		$echotheleft .= '<span class="badge badge-pill badge-secondary mt-1"><em>tbd</em></span></div>';
	}else{
		$echotheleft .= '<span class="badge badge-pill badge-secondary mt-1">'.get_the_date( 'Y' ).'</span></div>';
	}	
	if($thefuturepost){
		$fbg = ' thefuturepost';
		$fstyle = 'style="padding-left:1em;border-left:solid 2em #ced4da;border-bottom:3px solid #ced4da;border-top:1px solid #ced4da;"';
		$echothelink = '<em class="font-weight-normal">'.get_the_title().' (upcoming)</em>';
	}else{
		$fbg = $fstyle = '';
		$echothelink = '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
	}
	
	if($thefuturepost && $SC == "SC_year"){
		//$echothemeta =  akseki_get_the_meta(get_the_id()).'|'.akseki_get_sc(get_the_id());
		$echothemeta = preg_replace('/<span class="meta-date">.+?<\/span>/', akseki_get_sc(get_the_id()), akseki_get_the_meta(get_the_id()) );
	}elseif($thefuturepost && $SC == "SC_month"){
		$echothemeta = preg_replace('/<span class="meta-date">.+?<\/span>/', get_the_date( 'F Y' ), akseki_get_the_meta(get_the_id()) );
	}elseif($thefuturepost && $SC == "SC_nodate"){
		$echothemeta = '<em>tbd</em>';
	}else{
		$echothemeta = akseki_get_the_meta(get_the_id());
	}
	//echo everything
	echo '				
		<li class="list-group-item w-100 d-flex'.$fbg.'" '.$fstyle.'>
			'.$echotheleft.'
			<div class="col pl-0">
				<h6 class="d-inline font-weight-bold">'.$echothelink.'</h6>
				<p class="akseki-meta">'.$echothemeta.'</p>
			</div>
		</li>';
?>
	


