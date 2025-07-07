

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>');
		}
		the_title( sprintf( '<h4 class="entry-title"><span class="badge badge-secondary btn-secondary">'.akseki_get_shortname(get_the_title(),get_the_id()).'</span><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
		?>
	</header><!-- .entry-header -->
	<div class="row">
		<?php if(has_post_thumbnail()) : ?>
		<div class="col-sm-auto text-center">
			<?php echo the_post_thumbnail( 'thumbnail', ['class' => 'img-fluid rounded'] ); ?>
		</div>
		<?php endif; ?>
		<div class="entry-content col">
			
			<?php the_excerpt(); ?>
			<p class="akseki-meta"><?php echo akseki_get_the_meta(get_the_ID()); ?></p>
			<?php
				$categories = get_the_category();
				$separator = ' ';
				$output = '';
				if ( ! empty( $categories ) ) {
					echo '<p class="mb-0 text-center text-sm-left">';
					foreach( $categories as $category ) {
						$output .= '<a class="akseki-category-badge badge badge-pill badge-primary" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
					}
					echo trim( $output, $separator );
					echo '</p>';
				}
				?>
		</div><!-- .entry-content -->
	</div>
	<!--footer class="entry-footer">
		
	</footer-->
</article><!-- #post-<?php the_ID(); ?> -->
