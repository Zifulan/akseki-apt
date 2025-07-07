<?php 
	$theleft = akseki_get_shortname(get_the_title(),get_the_id());
	$echotheleft = '<div class="col-auto d-flex flex-column justify-content-start pl-0 pr-2">';
	if(!empty($theleft)){
		$echotheleft .= '<span class="counter-badge badge badge-secondary py-2 mt-1">'.$theleft.'</span>';
	};
	$echotheleft .= '<span class="badge badge-pill badge-secondary mt-1">'.get_the_date( 'Y' ).'</span></div>';
	echo '				
		<li class="list-group-item w-100 d-flex">
			'.$echotheleft.'
			<div class="col pl-0">
				<h6 class="d-inline">				
				<a href="'.get_the_permalink().'">'.get_the_title().'</a></h6>
				<p class="akseki-meta">'.akseki_get_the_meta(get_the_id()).'</p>
			</div>
		</li>';
?>
	


