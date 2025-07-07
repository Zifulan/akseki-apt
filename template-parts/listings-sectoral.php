<?php 
	//check if post is future
	$future = get_post_status(get_the_id());
	$SM = akseki_get_sm(get_the_id());
	$theleft = akseki_get_shortname(get_the_title(),get_the_id());
	$echotheleft = '<div class="col-auto d-flex flex-column justify-content-start pl-0 pr-2">';
	//handle SPECIAL MEETING
	if($future == "future"){
		$echotheleft .= '<span class="rounded bg-secondary align-content-center flex-wrap d-flex mt-1 py-0 mb-1 px-3 font-weight-bold text-white h-100">upcoming&nbsp;&#10151;</span>';
	}else{
		if(!empty($SM)){
			$echotheleft .= '<span class="counter-badge badge badge-secondary py-2 px-3 mt-1 text-uppercase font-weight-bold">Extra</span>';
		}else{
			$echotheleft .= '<span class="counter-badge badge badge-secondary py-2 mt-1 font-weight-bold">'.$theleft.'</span>';
		};
		$echotheleft .= '<span class="badge badge-pill badge-secondary mt-1">'.get_the_date( 'Y' ).'</span>';
	}
	$echotheleft .= '</div>';
	if($future == "future"){
		$echothetitle = '<h6 class="d-inline text-muted"><em>'.get_the_title().'</em></h6>';
	}else{
		$echothetitle = '<h6 class="d-inline"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h6>';
	}
	
	echo '		
		<div class="list-group-item w-100 d-flex'.($future == "future" ? " futureitem" : "").'">
			'.$echotheleft.'
			<div class="col pl-0 mt-1">								
				'.$echothetitle.'
				<p class="akseki-meta mb-0'.($future == "future" ? " text-muted font-italic" : "").'">'.akseki_get_the_meta(get_the_id()).'</p>
			</div>
		</div>';
?>
	


