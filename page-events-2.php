<?php
get_header();
?>
	<script type="text/javascript">	
		//smooth scrolling
		jQuery(function($) {			
			$('.smoothscroll').click(function(){
				$('html, body').animate({
					scrollTop: $( $(this).attr('href') ).offset().top
				}, 500);
				return false;
			});			
		});
	</script>	
		<main id="main" class="site-main">	
			<section>	
				<!--EVENTS-->
				<div class="topic-head mt-4" id="page-events-2">
					<div class="container">
						<h2>Agenda</h2>
					</div>
				</div>
				<div class="container" id="agenda-content">				
					<div class="row">
						<div class="col-12 col-lg-2">
							<h3 class="pt-4">Upcoming</h3>
						</div>
						<div class="col-12 col-lg-10">
							<div class="row py-4">
							<?php get_template_part("template-parts/sidebar-agenda"); ?>						
							</div>
						</div>
					</div>
					<?php
					$SA_cats = akseki_get_ministrial_categories();
					array_push($SA_cats,'summit-level-statements');
					$echo1 = '';
					$SA_query = new WP_Query(array(
						'category_name'=> implode( ',', $SA_cats ),
						'post_status' => 'publish',
						'orderby'           => 'date',
						'order'             => 'DESC',
						'posts_per_page'=>-1
						)
					);						
					$years = array();
					if( $SA_query->have_posts() ) :
						while ( $SA_query->have_posts() ):
							$SA_query->the_post();
							$year = get_the_date( 'Y' );
							$current_categories = get_the_category();
							$thedate = get_the_date( 'd F' );
							$thecat = '';
							foreach($current_categories as $cat){
								if(in_array($cat->slug, $SA_cats)){
									$thecat = $cat->term_id;
								}
							}						
							if ( ! isset( $years[ $year ] ) ) $years[ $year ] = array();
							$years[ $year ][] = array( 'id' => get_the_ID(), 'title' => get_the_title(), 'permalink' => get_the_permalink(), 'cat' => $thecat, 'date' => $thedate );
						endwhile;
					endif;
					wp_reset_postdata();
					foreach($years as $key => $value):
						$toggler = '<a class="btn btn-secondary collapse-toggle collapsed d-flex align-items-center justify-content-center my-1 w-auto" data-toggle="collapse" href="#collapse'.$key.'" role="button" aria-expanded="false" aria-controls="collapse'.$key.'"><h3 class="mb-0">'.$key.'</h3></a>';
						echo('<div class="row border-top mt-2">');
						//button
						echo '<div class="col-12 col-lg-2 text-center">'.$toggler.'</div>';
						//first item, only appear when collapsed
						$fleft = akseki_get_shortname($value[0]['title'],$value[0]['id']);
						$fflag = akseki_get_the_flag($value[0]['id']);
						$first = '<ul class="list-group list-group-flush w-100"><li class="list-group-item w-100 d-flex py-1 px-0 justify-content-between"><a href="'.$value[0]["permalink"].'"><span class="counter-badge badge badge-secondary py-1 my-1">'.$fleft.'</span>&nbsp;&nbsp;'.$value[0]["title"].'</a><span class="pt-2 pl-2" style="white-space: nowrap;"><em>'.$value[0]['date'].'</em>&nbsp;&nbsp;'.$fflag.'</span></li></ul>';
						echo '<div class="d-none d-lg-flex col-lg-10 pl-0">'.$first.'</div>';
						//the collapsed content
						echo '<div class="w-100 row collapse" id="collapse'.$key.'">';
						echo '<div class="d-none d-lg-flex col-lg-2"></div>';
						echo '<div class="col-12 col-lg-10 pr-0"><ul class="list-group list-group-flush w-100 pl-3 pl-lg-0">';
						foreach($value as $k => $v):
							//hide the first value on large screens
							reset($value);
							$firstonly = '';
							if($k===key($value)){
								$firstonly = " d-flex d-lg-none";
							}
							$theleft = akseki_get_shortname($v['title'],$v['id']);
							$theflag = akseki_get_the_flag($v['id']);
							echo('<li class="list-group-item w-100 d-flex py-1 px-0 justify-content-between'.$firstonly.'"><a href="'.$v["permalink"].'"><span class="counter-badge badge badge-secondary py-1 my-1">'.$theleft.'</span>&nbsp;&nbsp;'.$v["title"].'</a>');
							echo('<span class="pt-2 pl-2" style="white-space: nowrap;"><em>'.$v['date'].'</em>&nbsp;&nbsp;'.$theflag.'</span>');
							echo('</li>');							
						endforeach;
						echo('</ul></div></div>');
						echo('</div>');
					endforeach;
					
					?>
					
										
				</div>
			</section>			
		</main>
		<!--style>
			#agenda-content .collapse-toggle:not(.collapsed):after{content:"\25B2";}
			#agenda-content .collapse-toggle.collapsed:after{content:'\25BC';}
		</style-->
<?php
get_footer();
