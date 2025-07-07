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
	
	$catinfo = $args['cat'];
	$thetitle = get_the_title();
	if($catinfo == 'abmf'){
		$abmf_link = get_post_custom_values('abmf_link', get_the_id());
		//var_dump($abmf_link);
		if(!empty($abmf_link)){
			$titled = '<a href="'.$abmf_link[0].'" target="_blank">'.$thetitle.'</a><span class="abmficon dashicons dashicons-external"></span>';
		}else{
			$titled = $thetitle;
		}
	}else{
	    if(has_tag("hasnocontent") or $futurearticle){
    		$titled = $thetitle;
    	}else{			
    		$titled = '<a href="'.get_the_permalink().'" target="_blank">'.$thetitle.'</a>';
    	}
	}
	
	//echo everything
	echo '
		<div class="list-group-item w-100 d-flex'.($futurearticle?" futurearticle":"").'">
			<div class="col px-3 d-flex justify-content-start">
				'.($futurearticle?$futurethumb:"").'
				<div class="'.($futurearticle?"text-secondary":"").'">
					<h4 class="d-block font-weight-bold mt-1 mb-0">'.$titled.'</h4>
					<p class="akseki-meta mb-0">'.$echothemeta.'</p>
				</div>
			</div>
		</div>';
?>