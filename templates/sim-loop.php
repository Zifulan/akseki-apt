<div class="su-posts su-posts-default-loop">

	<?php if ( $posts->have_posts() ) : ?>
		<ul id="su-post-<?php the_ID(); ?>" class="su-post">
		<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

			

				

				<li class=""><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

				

			

		<?php endwhile; ?>
		</ul>
	<?php else : ?>
		<h4><?php _e( 'Posts not found', 'shortcodes-ultimate' ); ?></h4>
	<?php endif; ?>

</div>
