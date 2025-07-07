<?php defined( 'ABSPATH' ) || exit; ?>

<?php
/**
 * READ BEFORE EDITING!
 *
 * Do not edit templates in the plugin folder, since all your changes will be
 * lost after the plugin update. Read the following article to learn how to
 * change this template or create a custom one:
 *
 * https://getshortcodes.com/docs/posts/#built-in-templates
 */
?>

<div class="su-posts su-posts-default-loop <?php echo esc_attr( $atts['class'] ); ?>">

	<?php if ( $posts->have_posts() ) : ?>
		<?php /*
		echo("<pre>");
		print_r($posts); 
		echo("</pre>"); */
		
		
		$children = get_term_children(45,"category");
		if(!empty($children)) {
			echo('<div class="w-100 childcat mb-2 d-flex flex-wrap">');
			foreach($children as $child){
				$term = get_term($child);
				echo('<div class="p-1 m-0" style="flex:0 50%;">');
				echo('<a href="'.get_category_link($child).'" class="btn btn-secondary m-0 w-100 h-100">');
				echo('<h4 class="mb-0"><span>'.$term->name.'</span></h4>');
				echo('<em class="mb-0">'.$term->description.'</em>');
				echo('</a>');
				echo('</div>');
			}
			echo('</div>');
		}
		?>
		<ul id="su-post-<?php the_ID(); ?>" class="su-post <?php echo esc_attr( $atts['class_single'] ); ?> list-group list-group-flush">
		<?php while ( $posts->have_posts() ) : ?>
			<?php 
			$posts->the_post(); 
			$thecats = get_the_category();
			$directparent = wp_list_pluck($thecats,"term_id");
			?>

			<?php if ( ! su_current_user_can_read_post( get_the_ID() ) ) : ?>
				<?php continue; ?>
			<?php endif; ?>
			
			<?php if(in_array(45,$directparent)) : ?>
			
			

				<?php /*if ( has_post_thumbnail( get_the_ID() ) ) : ?>
					<a class="su-post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				<?php endif; */?>

				<li class="su-post-title list-group-item list-group-item-action"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php /*
				<div class="su-post-meta">
					<?php esc_html_e( 'Posted', 'shortcodes-ultimate' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?>
					<?php 
					
					//echo("<pre>");print_r($directparent);echo("</pre>");
					?>
				</div>
				
				<div class="su-post-excerpt">
					<?php the_excerpt(); ?>
				</div>
				*/?>
				<?php /*if ( have_comments() || comments_open() ) : ?>
					<a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 comments', 'shortcodes-ultimate' ), __( '1 comment', 'shortcodes-ultimate' ), '% comments' ); ?></a>
				<?php endif;*/ ?>

			
			<?php endif; ?>
		<?php endwhile; ?>
		</ul>
	<?php else : ?>
		<h4><?php esc_html_e( 'Posts not found', 'shortcodes-ultimate' ); ?></h4>
	<?php endif; ?>

</div>
