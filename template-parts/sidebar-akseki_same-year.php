<?php

$current_post_ID = get_the_ID();
$current_year = $args['current_year'];

$asy_display_output = '';
$asy_display_output .= '<div class="sidebar-left-item same-year detail-sidebar">';
$asy_display_output .= '<div class="toggler-title text-right btn btn-secondary" data-toggle="collapse" href="#collapseLcpYear" role="button" aria-expanded="false" aria-controls="collapseLcpYear">';
$asy_display_output .= '<h3>Year '.$current_year;
$asy_display_output .= '<span class="more-less dashicons dashicons-arrow-down"></span></h3></div>';

$asy_display_output .= '<div class="collapse" id="collapseLcpYear">';
$asy_display_output .= '<ul class="list-group list-group-flush">';

//include ministerial, summit, som, othlev
$asy_cats = akseki_get_ministrial_categories();
$asy_otl = akseki_get_othlev_categories();
$asy_som = akseki_get_som_categories();
array_push($asy_cats,'summit-level-statements','cpr-level');
$asy_cats = array_merge($asy_cats,$asy_otl,$asy_som);

$asy_args = array( 'posts_per_page' => -1, 'year' => $current_year, 'category_name'=> implode( ',', $asy_cats ) );
$asy_posts=get_posts($asy_args);
foreach ( $asy_posts as $post ) : setup_postdata( $post );
	$asy_display_output .= '<li class="list-group-item p-1'.($current_post_ID == get_the_ID()?" list-group-item-warning":"").(has_category("Summit Level Statements")?" list-group-item-secondary":"").'">';
	
	$SM = akseki_get_SM($post->ID);
	if(empty($SM)){
		$smornot = '<strong>'.akseki_get_shortname($post->post_title, $post->ID, 3).'</strong>';
	}else{
		$smornot = '<strong>'.$SM.'</strong>';
	}
	if($current_post_ID == $post->ID){
		$asy_display_output .= '<strong>'.$smornot.'</strong>';			
	}else{
		if(has_tag("hasnocontent", $post->ID)){
			$thecats = get_the_category($post->ID);
			$theslugs = wp_list_pluck($thecats,"slug");
			$theintersect = implode(array_intersect($theslugs,$asy_cats));
			$thecatObj = get_category_by_slug($theintersect);
			$asy_display_output .= '<a class="related-link" href="'.get_category_link($thecatObj->term_id).'">'.$smornot.'</a>';
		}else{
			$asy_display_output .= '<a class="related-link" href="'.get_permalink($post->ID).'">'.$smornot.'</a>';
		}
	}

	$asy_display_output .= ' <span class="badge badge-secondary">' . date('F', strtotime($post->post_date)) . '</span>';
	$asy_display_output .= ' <span class="roundflag">'.akseki_get_the_flag($post->ID).'</span>';
	$asy_display_output .= '</li>';
endforeach;

$asy_display_output .= '</ul>';
$asy_display_output .= '</div>';
$asy_display_output .= '</div>';
wp_reset_postdata();
echo($asy_display_output);