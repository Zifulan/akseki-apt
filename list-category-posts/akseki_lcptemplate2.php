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
$lcp_display_output = '<div class="mt-3 lcp-inner-container">';

// Show category link:
$lcp_display_output .= $this->get_category_link('strong');

// Show the conditional title:
$lcp_display_output .= $this->get_conditional_title();

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
$prev_year = null;

//generate the tab contents
$prev_year = null;

//handle future articles
$future_posts = akseki_get_future_post_in_category($this->params['id']);
if(!empty($future_posts)){
	$lcp_display_output .= '<em class="float-left lcp_s_ul bg-secondary py-0 px-2 rounded"><small>upcoming</small></em>';
	$lcp_display_output .= '<ul class="lcp_b_ul" style="margin-left:2rem;">';
	foreach($future_posts as $ft){
		$ft_obj = get_post($ft);
		$shortname = akseki_get_shortname($ft_obj->post_title,$ft);
		
		//$lcp_display_output .= $this->get_post_title($ft_obj, 'li', 'lcp_post');
		$lcp_display_output .= '<li class="lcp_post text-muted mb-2"><em>'.$shortname.'</em><br>';
		$lcp_display_output .= '<em class="badge badge-light font-weight-normal">'.akseki_get_the_meta(get_the_ID()).'</em>';
		$lcp_display_output .= '</li>';
	}
	$lcp_display_output .= '</ul><hr/>';
}

while ( have_posts() ):
  the_post();
  $this_year = get_the_date('Y');
  if ($prev_year != $this_year) {	  
	  if (!is_null($prev_year)) {
		 $lcp_display_output .= '</ul><hr/>';		 
	  }
	  //$lcp_display_output .= '<div class="lcp_ul_container">';
	  $lcp_display_output .= '<strong class="lcp_s_ul bg-secondary py-0 px-2 rounded">'.$this_year.'</strong>';
	  $lcp_display_output .= '<ul class="lcp_b_ul ml-3">';
  }

    //handle no content articles
  

  
	//Show the title and link to the post:
	//$lcp_display_output .= $this->get_post_title($post, 'li', 'lcp_post');
	//handle shortnames and no shortnames
	$lcp_display_output .= '<li class="lcp_post mb-2">';
	$shortname = akseki_get_shortname(get_the_title(),get_the_ID());
	if(has_tag("hasnocontent")){
		$lcp_display_output .= $shortname;
	}else{
		$lcp_display_output .= '<a href="'.get_the_permalink().'">'.$shortname.'</a>';
	}
	//$lcp_display_output .= '<a title="'.strip_tags(get_the_title()).'" href="'.get_the_permalink().'">'.$shortname.'</a>';
	$lcp_display_output .= '<br>';
	$lcp_display_output .= '<em class="badge badge-light font-weight-normal">'.akseki_get_the_meta(get_the_ID()).'</em>';
	$lcp_display_output .= '</li>';
  if (!get_next_post_link()) { 
    $lcp_display_output .= '</ul>';
  }
  
  
  $prev_year = $this_year;
  
endwhile;

$lcp_display_output .= '
</div>
<style>
ul.lcp_b_ul{
	padding-left:4em;
	list-style-type:circle;
}
strong.lcp_s_ul{
	float:left;
}
</style>';

$this->lcp_output = $lcp_display_output;