

	
	
	<?php 
	//detect future post
	$articledate = new DateTime(get_the_date());
	$nowdate = new DateTime("now");
	$futurearticle = false;
	if(($articledate > $nowdate) == true){
		$futurearticle = true;
	}
	
	//handle thumb image
	if($futurearticle){
		$thumb = '<div style="width:250px;position: relative;" class="rounded p-2 bg-secondary"><h6 style="color:white;font-size:2em;position: absolute;top: 50%;left: 50%;transform: translate(-50%,-50%);">upcoming&nbsp;&#10151;</h6></div>';
	}else{
		if(get_the_post_thumbnail_url( get_the_id(), "medium" )){
			$thumb = '<img src="'.get_the_post_thumbnail_url( get_the_id(), "medium" ).'" class="cprimg p-0" alt="'.get_the_title().'" style="max-width:250px;"/>';
		}else{
			$default_image = wp_get_attachment_image_src(1007,"medium");
			$thumb = '<img src="'.$default_image[0].'" class="cprimg p-0" alt="'.get_the_title().'" style="max-width:250px;"/>';
		}		
	}		
	$thetitle = akseki_get_shortname(get_the_title(),get_the_ID(),0);
	if(has_tag("hasnocontent") or $futurearticle){
		$titled = $thetitle;
	}else{			
		$titled = '<a href="'.get_the_permalink().'" target="_blank">'.$thetitle.'</a>';
	}
	$latest_card = '<li class="list-group-item w-100 d-flex'.($futurearticle?" futurearticle pt-0 pb-2":" py-2").'">

			'.$thumb.'

			<div class="col pl-2 my-auto">

				<h4 class="d-inline font-weight-bold'.($futurearticle?" text-secondary":"").'">'.$titled.'</h4>

				<p class="akseki-meta mb-0'.($futurearticle?" text-secondary":"").'">'.akseki_get_the_meta(get_the_id()).'</p>

			</div>

		</li>';
	
	echo($latest_card);
	?>
	


