<?php get_header(); ?>

<?php
//category query
$current_category = get_queried_object()->slug;
$current_category_id = get_queried_object()->term_id;
$ministerial = akseki_get_ministrial_categories();
$sectoral = akseki_get_sectoral_categories();
$category_query = '';
if(in_array($current_category,$ministerial)){
	$category_query = 'ministerial';
}else if(in_array($current_category,$sectoral)){
	$category_query = 'sectoral';
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
