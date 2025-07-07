



		<div class="row akseki-detail-style1">
			
			<div class="col-md-12">	
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php get_template_part( 'template-parts/article-header' ); ?>
					<div class="entry-content">
						<?php
						the_content(
							sprintf(
								wp_kses(
									
									__( 'Continue reading<span class="screen-reader-text"> "%s"</span>' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								get_the_title()
							)
						);
						
						?>
					</div><!-- .entry-content -->

				</article><!-- #post-<?php the_ID(); ?> -->
			</div>
			
		</div>
