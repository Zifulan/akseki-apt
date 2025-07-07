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
	$futurethumb = '<div class="rounded mr-2 p-2 bg-secondary h-100 d-flex align-items-center"><h5 class="text-white p-0 m-0">upcoming&nbsp;&#10151;</h5></div>';
	
	if(has_tag("hasnocontent") or $futurearticle){
		$titled = get_the_title();
	}else{
		$titled = '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
	}
	//echo everything
	echo '
		<li class="list-group-item w-100 d-flex'.($futurearticle?" futurearticle":"").'">
			<div class="col px-3 d-flex justify-content-start">
				'.($futurearticle?$futurethumb:"").'
				<div class="'.($futurearticle?"text-secondary":"").'">
					<h4 class="d-block font-weight-bold mt-1 mb-0">'.$titled.'</h4>
					<p class="akseki-meta mb-0">'.$echothemeta.'</p>
				</div>
			</div>
		</li>';
?>