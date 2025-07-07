
<div class="row">
<div class="nav flex-column nav-pills col-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
<?php 
	$curcat_children = get_categories(
		array( 'parent' => $sectoral_catid )
	);
	foreach($curcat_children as $key=>$child) :
		$active = "";
		if ($key === array_key_first($curcat_children)) :
			$active = " active";
			$arrow = "";
		endif;
		echo '<a class="nav-link text-right'.$active.'" id="v-pills-'.$child->slug.'-tab" data-toggle="pill" href="#v-pills-'.$child->slug.'" role="tab" aria-controls="v-pills-'.$child->slug.'" aria-selected="true"><h4>'.$child->name.'</h4><p>'.$child->description.'</p></a>';	
	endforeach;
?>
</div>

<?php
			
				echo '<div class="tab-content col-md-9 pr-0 list-group list-group-flush" id="v-pills-tabContent">';				
				foreach($curcat_children as $key=>$child):				
					$active = "";
					if ($key === array_key_first($curcat_children)) :
						$active = " show active";
					endif;
					echo '<div class="tab-pane fade'.$active.'" id="v-pills-'.$child->slug.'" role="tabpanel" aria-labelledby="v-pills-'.$child->slug.'-tab">';
					$futureposts = akseki_get_future_post_in_category($child->term_id);
					if(!empty($futureposts)){
						foreach($futureposts as $futurepost){
							get_template_part( 'template-parts/listings', 'sectoral' );
						}
					}
					while ( have_posts() ) :						
						the_post();
						if(has_category($child->term_id)):							
							get_template_part( 'template-parts/listings', 'sectoral' );
						endif;
					endwhile;
					echo '</div>';
				endforeach;
				echo '</div>';
			
?>
</div>