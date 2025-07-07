<?php
/*
Plugin Name: List Category Posts - Template "Default"
Plugin URI: http://picandocodigo.net/programacion/wordpress/list-category-posts-wordpress-plugin-english/
Description: Template file for List Category Post Plugin for Wordpress which is used by plugin by argument template=value.php
Version: 0.9
Author: Radek Uldrych & Fernando Briano
Author URI: http://picandocodigo.net http://radoviny.net
*/

/*
Copyright 2009 Radek Uldrych (email : verex@centrum.cz)
Copyright 2009-2015 Fernando Briano (http://picandocodigo.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or any
later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301
USA
*/

/**
* The format for templates changed since version 0.17.  Since this
* code is included inside CatListDisplayer, $this refers to the
* instance of CatListDisplayer that called this file.
*/

/* This is the string which will gather all the information.*/
$lcp_display_output = '';

// Show category link:

$lcp_display_output .= '<div class="toggler-title text-right btn btn-secondary" data-toggle="collapse" href="#collapseLcpYear" role="button" aria-expanded="false" aria-controls="collapseLcpYear">';
$lcp_display_output .= $this->get_category_link('strong');

$lcp_display_output .= $this->get_category_description();
// Show the conditional title:
$lcp_display_output .= $this->get_conditional_title();
$lcp_display_output .= '<h3 class="more-less fas fa-caret-down ml-2"></h3></div>';
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
$lcp_display_output .= '<div class="collapse" id="collapseLcpYear">';
$lcp_display_output .= '<ul class="list-group list-group-flush">';
while ( have_posts() ):
	the_post();
	$SM = akseki_get_sm(get_the_ID());
	$longtitle = strip_tags(get_the_title());
	//echo($current_post_ID).' - ' . get_the_ID() . '<br/>';
	$lcp_display_output .= '<li class="list-group-item p-1'.($current_post_ID == get_the_ID()?" list-group-item-warning":"").'">';
	$noshorttitle = false;
	$shorttitle3 = '';
	$fixedtitle = '';
	preg_match('/\d\d*(:?st|nd|rd|th)/', $longtitle, $shorttitle);
	if(!empty($SM)){
	    $shorttitle3 = substr($SM,3);
	}elseif(!empty($shorttitle)){
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
	if($current_post_ID !== get_the_ID()){
		$lcp_display_output .= '<a class="related-link" href="'.get_permalink().'">';
	}
	if($noshorttitle){
		$lcp_display_output .= $shorttitle3 . ' - ';
	}else{
		$lcp_display_output .= preg_replace('/(\d)(st|nd|rd|th)/', '$1<sup>$2</sup>', $fixedtitle);
	}
	
	$appear = ['apt-foreign-ministers-meeting','ammtc3','aem3','afmgm3','m-atm3','amaf3','amem3','amme3-emm','ammswd3','ammy3','accsm3','almm3','amca3','amri3','aptemm','ahmm3','summit-level-statements'];
	foreach($appear as $thecat){
		if(has_category($thecat,get_the_ID())){
		    if($thecat == 'summit-level-statements'){
				if(empty($SM)){
					$lcp_display_output .= ' APT Summit';
				}
			}else{
				if(empty($SM)){
					$lcp_display_output .= ' '.get_category_by_slug($thecat)->name;
				}
			}
		}
	}
	if($current_post_ID !== get_the_ID()){
		$lcp_display_output .= '</a>';
	}
	$lcp_display_output .= ' <span class="badge badge-secondary">' . get_the_date("F") . '</span>';
	
	
	$lcp_display_output .= ' <span class="roundflag">'.akseki_get_the_flag(get_the_ID()).'</span>';
	
	$lcp_display_output .= '</li>';

endwhile;
$lcp_display_output .= '</ul>';
$lcp_display_output .= '</div>';

$this->lcp_output = $lcp_display_output;