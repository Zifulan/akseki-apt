<?php

$lcp_display_output = '';

$lcp_display_output .= $this->get_category_link('strong');

$lcp_display_output .= $this->get_conditional_title();
$lcp_display_output .= "<ul class='lcp_catlist pl-4'>";

global $post;

while ( have_posts() ):
  the_post();
  //Show the title and link to the post:
  $lcp_display_output .= $this->get_post_title($post, 'li', 'lcp_post mb-1');
endwhile;

$lcp_display_output .= '<li class="lcp_post"><em>'.$this->get_morelink().'&nbsp;&nearr;</em></li>';
$lcp_display_output .= '</ul>';

$this->lcp_output = $lcp_display_output;