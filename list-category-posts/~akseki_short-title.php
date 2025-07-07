<?php

$lcp_display_output = '';
$lcp_display_output .= '<div class="toggler-title text-right btn btn-secondary" data-toggle="collapse" href="#collapseLcpCat" role="button" aria-expanded="false" aria-controls="collapseLcpCat">';
$lcp_display_output .= $this->get_category_link('h3');
$lcp_display_output .= '<h3 class="more-less fas fa-caret-down ml-2"></h3>';
$lcp_display_output .= $this->get_category_description();
// Show the conditional title:
//$lcp_display_output .= $this->get_conditional_title();
$lcp_display_output .= '</div>';
//Add 'starting' tag. Here, I'm using an unordered list (ul) as an example:
//$lcp_display_output .= '<ul class="lcp_catlist">';

/* Posts Loop
 *
 * The code here will be executed for every post in the category.  As
 * you can see, the different options are being called from functions
 * on the $this variable which is a CatListDisplayer.
 *
 * CatListDisplayer has a function for each field we want to show.  So
 * you'll see get_excerpt, get_thumbnail, etc.  You can now pass an
 * html tag as a parameter. This tag will sorround the info you want
 * to display. You can also assign a specific CSS class to each field.
*/
global $post;
$current_post_ID = $post->ID;
$lcp_display_output .= '<div class="collapse" id="collapseLcpCat">';
$lcp_display_output .= '<ul class="list-group list-group-flush">';
while ( have_posts() ):
	the_post();
	$longtitle = strip_tags(get_the_title());
	$lcp_display_output .= '<li class="list-group-item p-1'.($current_post_ID == get_the_ID()?" list-group-item-warning":"").'">';
	$shorttitle3 = '';
	$fixedtitle = '';
	$noshorttitle = false;
	preg_match('/\d\d*(:?st|nd|rd|th)/', $longtitle, $shorttitle);
	if(!empty($shorttitle)){
		$shorttitle3 = trim(strtolower($shorttitle[0]));		
	}else{
		preg_match('/(:?first|second|third|fourth|fifth|sixth|seventh|eighth|ninth|tenth)/i', $longtitle, $shorttitle2);
		if(!empty($shorttitle2)){
			$shorttitle3 = trim(strtolower($shorttitle2[0]));
		}else{
			$shorttitle3 = $longtitle;
			$noshorttitle = true;
		}
	}
	if($noshorttitle == false) :
	switch ($shorttitle3) {
		case "1st":
		case "first":
			$fixedtitle="1st";			
			break;
		case "2nd":
		case "second":
			$fixedtitle="2nd";
			break;
		case "3rd":
		case "third":
			$fixedtitle="3rd";
			break;
		case "4th":
		case "fourth":
			$fixedtitle="4th";
			break;	
		case "5th":
		case "fifth":
			$fixedtitle="5th";
			break;
		case "6th":
		case "sixth":
			$fixedtitle="6th";
			break;
		case "7th":
		case "seventh":
			$fixedtitle="7th";
			break;
		case "8th":
		case "eighth":
			$fixedtitle="8th";
			break;
		case "9th":	
		case "ninth":	
			$fixedtitle="9th";
			break;
		case "10th":
		case "tenth":
			$fixedtitle="10th";
			break;
		default:
			$fixedtitle=$shorttitle3;
		}
	endif;
	if($current_post_ID !== get_the_ID()){
		$lcp_display_output .= '<a class="related-link" href="'.get_permalink().'">';
	}
	if($noshorttitle){
		$lcp_display_output .= $shorttitle3 . ' - ';
	}else{
		$lcp_display_output .= preg_replace('/(st|nd|rd|th)/', '<sup>$1</sup>', $fixedtitle);
	}
	$lcp_display_output .= ' '.$this->get_category_link();
	if($current_post_ID !== get_the_ID()){
		$lcp_display_output .= '</a>';
	}
	$lcp_display_output .= ' <span class="badge badge-secondary">' . date('Y', strtotime($this->get_date($post))) . '</span>';
	
	
	$lcp_display_output .= ' <span class="roundflag">'.akseki_get_the_flag(get_the_ID()).'</span>';
	
	$lcp_display_output .= '</li>';

endwhile;
$lcp_display_output .= '</ul>';
$lcp_display_output .= '</div>';
$this->lcp_output = $lcp_display_output;