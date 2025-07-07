

<article id="post-<?php the_ID(); ?>" class="col-md-4">
	
	
	<?php 
	if(get_the_post_thumbnail_url( get_the_id(), "medium" )){
		$thumb = '<img src="'.get_the_post_thumbnail_url( get_the_id(), "medium" ).'" class="card-img-top p-3" alt="'.get_the_title().'"/>';
	}else{
		$thumb = "";
	}		
	
	$latest_card = '
								<div class="latest-item m-1 pb-3">
									<div class="card w-100 h-100 shadow-sm" id="card_com-'.get_the_id().'">'
										.$thumb.													
										'<div class="pt-2 card-body d-flex justify-content-around flex-column flex-wrap">
											<span class="caption-title"></span>
											<h5 class="card-title w-100 font-weight-bold"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>
											
											<p class="akseki-meta">'.akseki_get_the_meta(get_the_id()).'</p>
											<p class="card-text w-100">'.get_the_excerpt().' &rarr;</p>
										</div>
									</div>
								</div>';
	echo($latest_card);
	?>
	

	<?php //echo the_post_thumbnail( 'medium' ); ?>


	<!--footer class="entry-footer">
		
	</footer-->
</article><!-- #post-<?php the_ID(); ?> -->
