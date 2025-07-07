<?php
$futurearticle = false;
$lcp_display_output = '';

$lcp_display_output .= $this->get_category_link('strong');

$lcp_display_output .= $this->get_conditional_title();
$lcp_display_output .= "<ul class='list-group list-group-flush'>";

global $post;

while ( have_posts() ):
  the_post();
  //Show the title and link to the post:
  
  $lcp_display_output .= '<li class="list-group-item w-100 d-flex'.($futurearticle?" futurearticle pt-0 pb-2":" py-2").'">

			<div class="col pl-2 my-auto">

				<p class="py-1 my-0"><a class="d-inline font-weight-bold" href="'.get_the_permalink().'">'.akseki_get_shortname(get_the_title(),get_the_ID()).'</a> | '.akseki_get_the_meta(get_the_id()).'</p>

			</div>

		</li>';
  
  
endwhile;

//$lcp_display_output .= '<li class="lcp_post"><em>'.$this->get_morelink().'&nbsp;&nearr;</em></li>';
$lcp_display_output .= '</ul>';
$lcp_display_output .= '<style>
						.akseki-detail-style1 .meta-date::before {
							content: " ";
						}
						.b_cpr .su-spoiler-content{
							column-count:2;
						}
						.b_cpr ul:first-child{border-top:1px solid rgba(0,0,0,.125);}
						.b_cpr li{
							column-break-inside:avoid;
							page-break-inside: avoid;           /* Theoretically FF 20+ */
							break-inside: avoid-column;         /* Chrome, Safari, IE 11 */
							display:table;
						}							
						@media (max-width: 1000px) {
							.b_cpr .su-spoiler-content{
								column-count:1;
							}
						}
						</style>';
$this->lcp_output = $lcp_display_output;