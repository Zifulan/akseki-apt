<?php get_header(); ?>

<?php
//category query
$current_category = get_queried_object()->slug;
$current_category_id = get_queried_object()->term_id;
$ministerial = akseki_get_ministrial_categories();
$sectoral = akseki_get_sectoral_categories();
$commision = akseki_get_commision_categories();
$category_query = '';
if(in_array($current_category,$ministerial)){
	$category_query = 'ministerial';
}else if(in_array($current_category,$sectoral)){
	$category_query = 'sectoral';
}else if(in_array($current_category,$commision)){
	$category_query = 'commision';
}

$wlc3_args = array(
	'echo' => false,
	'child_of' => $current_category_id,
	'hide_empty' => 0,
	'title_li' => '',
);
$wlc3 = wp_list_categories($wlc3_args);
$curcat_children = get_categories(
    array( 'parent' => $current_category_id )
);
?>

	<main id="main" class="site-main">
		<div class="container" id="avi-content">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php					
					echo '<h1 class="page-title">';
					single_term_title();
					echo '</h1>';
					if($category_query == 'ministerial') :
						echo '<p class="category-subtitle badge badge-primary"><i class="fas fa-arrow-alt-circle-right mr-2"></i>'.strip_tags(category_description()).'</p>';
					/*elseif($category_query == 'sectoral'):
						echo('<div class="alert alert-secondary sectoral-listing">
							<ul class="">'.$wlc3.'</ul>
							</div>');*/
					else:
						echo('<hr/>');
					endif;
				?>
			<script type="text/javascript">
				/*modifying*/
				jQuery(document).ready(function(jQuery){
					$('.sectoral-listing .cat-item > a').each(function(){		
						let replacement = $(this).attr('title');
						$(this).after('<p>'+replacement+'</p>');
						$(this).removeAttr('title')
					});
				});
			</script>
				
			</header><!-- .page-header -->
			
			<div class="listings-wrapper row">			
			<!--top sidebar for commision-->
			<?php if($category_query == 'commision' && $current_category == 'ministerial-level-statements') :?>
			<ul class="nav nav-pills w-100 mb-3 nav-justified" id="commision-pills-tab">
				<?php
				foreach($curcat_children as $key=>$child) :
					$active = "";
					if ($key === array_key_first($curcat_children)) :
						$active = " active";
						$arrow = "";
					endif;
					echo '
					<li class="nav-item">
						<a class="nav-link'.$active.'" id="commision-'.$child->slug.'-tab" data-toggle="pill" href="#commision-'.$child->slug.'" role="tab" aria-controls="commision-'.$child->slug.'" aria-selected="true">'.$child->name.'</a>
					</li>';		
				endforeach;
				?>
			</ul>			
			<div class="tab-content" id="commisionTabContent">
				<?php
				echo '<div class="tab-content pr-0 list-group list-group-flush" id="commision-tabContent">';				
				foreach($curcat_children as $key=>$child):				
					$active = "";
					if ($key === array_key_first($curcat_children)) :
						$active = " show active";
					endif;
					echo '<div class="container tab-pane fade'.$active.'" id="commision-'.$child->slug.'" role="tabpanel" aria-labelledby="commision-'.$child->slug.'-tab">';
						set_query_var( 'sectoral_catid', $child->term_id );
						get_template_part( 'template-parts/listings', 'commision' );						
					echo '</div>';
				endforeach;
				echo '</div>';
				?>
			</div>
			<?php elseif($category_query == 'commision' && $current_category == 'summit-level-statements') :
				$prev_year = null;
				$b_year = '';
				$b_title = '';
				$b_content = '';
				$b_output_nav = '';
				$b_output_con = '';
				$b_shortname = '';
				$first = 0;
				if( have_posts() ) {
					while ( have_posts() ):
						the_post();					
						$b_the_ID = get_the_ID();
						//for the tab nav
						$this_year = get_the_date('Y');					
						$active = "";
						if ($first <= 2) :
							$active = " show active";
							$arrow = "";
						endif;
						//is it the start of next year? if it is, vomit the output
						if (!empty($prev_year) && $prev_year != $this_year) {	 
							
							//echoing the prev year
							$b_output_nav .= '<a class="w-100 nav-link'.$active.' text-center"  id="summit-'.$b_the_ID.'-tab" data-toggle="pill" href="#summit-'.$b_the_ID.'" role="tab" aria-controls="summit-'.$b_the_ID.'" aria-selected="true">';
							$b_output_nav .= $b_year.$b_shortname;
							$b_output_nav .= '</a>';
							
							$b_output_con .= '<div class="tab-pane fade'.$active.'" id="summit-'.$b_the_ID.'" role="tabpanel" aria-labelledby="summit-'.$b_the_ID.'-tab">';
							$b_output_con .= $b_content;
							$b_output_con .= '</div>';
							//resetting the b containers
							$b_year = $b_shortname = $b_content = '';
							//$b_year = '<h4 class="w-100">'.$this_year.'</h4>';	
							$shortname = akseki_get_shortname(get_the_title(), $b_the_ID);						
						}
						//$b_year = '<h4 class="w-100">'.$this_year.'</h4>';
						if(empty($shortname)){
							$shortname = akseki_get_shortname(get_the_title(), $b_the_ID);
						}					
						if(!empty($shortname)){
							//$b_shortname = '<h5 class="w-100">'.$shortname.' APT Summit</h5>';
							//$b_shortname = '<h5 class="w-100">'.$this_year.'</h5>';
							$b_shortname = '<h4 class="w-100"><span class="mb-0 pb-0 pt-2 font-weight-normal mt-1">'.$shortname.' APT Summit</span>&nbsp;'.$this_year.'</h4>';
						}
						//Show the title and link to the post:
						$b_content .= '<div class="list-group-item">'.get_the_title().'</div>';					
						if (!get_next_post_link()) { 
							//echoing this year for the last entry
							$b_output_nav .= $b_year.$b_shortname;
							$b_output_con .= $b_content;
						}
						$prev_year = $this_year;
						++$first;
					endwhile;
					
					//get it all out
					echo '<div class="d-flex pb-3 mx-0 px-0 col-md-4 nav nav-pills" id="summit-tab" role="tablist" aria-orientation="vertical">'.$b_output_nav.'</div>';
					echo '<div class="col-md-8 tab-content list-group list-group-flush" id="summit-tabContent">'.$b_output_con.'</div>';
					
				}
			endif;?>
			
			<!--sidebar for sectoral-->
			<?php if($category_query == 'sectoral') :?>
			<div class="nav flex-column nav-pills col-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				<?php 
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
			<?php endif;?>
			<?php
			if($category_query == 'ministerial') :
				echo('<ul class="list-group list-group-flush w-100 ministerial-listing col-md-9">');
			elseif($category_query == 'sectoral'):
				//echo '<pre>';print_r($curcat_children);echo '</pre>';
				echo '<div class="tab-content col-md-9 pr-0 list-group list-group-flush" id="v-pills-tabContent">';				
				foreach($curcat_children as $key=>$child):				
					$active = "";
					if ($key === array_key_first($curcat_children)) :
						$active = " show active";
					endif;
					echo '<div class="tab-pane fade'.$active.'" id="v-pills-'.$child->slug.'" role="tabpanel" aria-labelledby="v-pills-'.$child->slug.'-tab">';
					while ( have_posts() ) :						
						the_post();
						if(has_category($child->term_id)):
							get_template_part( 'template-parts/listings', 'sectoral' );
						endif;
					endwhile;
					echo '</div>';
				endforeach;
				echo '</div>';
			endif;			
			
			$args = [];
			while ( have_posts($args) ) :
				the_post();
				
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				if($current_category == 'news'){
					get_template_part( 'template-parts/listings', 'cards' );
				}elseif($category_query == 'ministerial'){
					get_template_part( 'template-parts/listings', 'list' );
				}elseif($category_query == 'commision'){
					//get_template_part( 'template-parts/listings', 'commision' );
				}elseif($category_query !== 'sectoral'){
					get_template_part( 'template-parts/listings' );
				}
				// End the loop.
			endwhile;
			
			if($category_query == 'ministerial') :
				echo('</ul>');
			elseif( $category_query == 'sectoral' ) :
				echo('</div>');
			endif;	
			
			if($category_query == 'ministerial') :
			?>
				</ul>
				<div class="col-md-3 ministerial-sidebar">
					<h3 class="btn btn-primary"><i class="fas fa-arrow-right mr-2"></i>Ministerial-level Statements</h3>
					<ul class="list-group list-group-flush">
					<?php
					$wlc1_args = array(
						'echo' => true,
						'child_of' => 43,
						'hide_empty' => 0,
						'title_li' => '',
						'current_category' => $current_category_id,
					);
					wp_list_categories($wlc1_args);
					?>
					</ul>
					<h3 class="btn btn-primary" style="margin-top:3em;"><i class="fas fa-arrow-right mr-2"></i>Other Statements</h3>
					<ul class="list-group list-group-flush">
					<?php
					$wlc2_args = array(
						'echo' => true,
						'depth'               => 2,
						'hide_empty' => 0,
						'title_li' => '',
						'exclude_tree'        => 43,
						'exclude'             => '44,1,10',
					);
					wp_list_categories($wlc2_args);	
					?>
					</ul>
					<script type="text/javascript">
						/*modifying the sidebar list*/
						jQuery(document).ready(function(jQuery){
							$(".ministerial-sidebar > .list-group > li").addClass("list-group-item");
							$(".ministerial-sidebar > .list-group > li > a").addClass("btn btn-secondary");
							var currentcat = $('.ministerial-sidebar .current-cat a').html();
							$('.ministerial-sidebar .current-cat').empty();
							$('.ministerial-sidebar .current-cat').append('<em>'+currentcat+'</em>');
						});
					</script>
				</div>
		<?php
			endif;
			//pagination - disable
			//the_posts_navigation();
		?>
			</div>
		<?php
			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/notfound' );

		endif;
		?>
			
		</div>	
	</main><!-- .site-main -->


<?php get_footer(); ?>
