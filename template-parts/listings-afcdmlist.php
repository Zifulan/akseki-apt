<?php 
	//detect future post
	$articledate = new DateTime(get_the_date());
	$nowdate = new DateTime("now");
	$futurearticle = false;
	if(($articledate > $nowdate) == true){
		$futurearticle = true;
	}
	
	$echothelink = '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
	$echothemeta = akseki_get_the_meta(get_the_id());	
	
	$catinfo = $args['cat'];
	$thetitle = get_the_title();
	if(has_tag("hasnocontent") or $futurearticle){
		$titled = $thetitle;
	}else{			
		$titled = '<a href="'.$abmf_link[0].'" target="_blank">'.$thetitle.'</a>';
	}
	//echo everything
	echo '
		<div class="pl-0 list-group-item w-100 d-flex'.($futurearticle?" futurearticle":"").'">
			<div class="col px-3 d-flex justify-content-start">
				
				<div class="'.($futurearticle?"text-secondary":"").'">
					<h4 class="d-block font-weight-bold mt-1 mb-0">'.$titled.'</h4>
					<p class="akseki-meta mb-0">'.$echothemeta.'</p>
				</div>
			</div>
		</div>';
?>
