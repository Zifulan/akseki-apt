<?php
	$content = get_the_content();
	$pattern = '/<div class="wp-block-file">(.*?)<\/div>/';
    if(preg_match($pattern, $content, $matches)){
		$docdl = $matches[1];
		$docrest = str_replace($docdl, "", $content);
	}else{
		$docdl = "";
		$docrest = $content;
	}
	
?>


	
		<div class="row akseki-detail-style1">
			
			<div class="col-md-8">	
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php //echo the_post_thumbnail( 'large' ); ?>
				<p class="akseki-meta"><?php echo akseki_get_the_meta(get_the_ID());?></p>
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
						//echo($docrest);
						
						?>
					</div><!-- .entry-content -->
					<style>
						#post-<?php the_ID(); ?> .wp-block-file{
							visibility:hidden;
						}
					</style>
				</article><!-- #post-<?php the_ID(); ?> -->
			</div>
			
			<div class="col-md-4 sidebar-left order-md-first">
				<div class="sidebar-left-item">
					<a href="#" class="popup-image sidebar-left-item">
						<?php echo the_post_thumbnail( 'medium_large' ); ?>
					</a>
				</div>
				<?php
					if(!empty($docdl)){
						echo('<div class="sidebar-left-item docdl"><button class="btn btn-primary text-right"><i class="fas fa-download mr-2"></i>'.$docdl.'</button></div>');						
					}
				?>
				
				<?php
				$categories = get_the_category();
				$separator = ' ';
				$output = '';
				if ( ! empty( $categories ) ) {
					echo '<div class="sidebar-left-item">';
					foreach( $categories as $category ) {
						$output .= '<a class="badge badge-pill badge-primary" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
					}
					echo trim( $output, $separator );
					echo '</div>';
				}
				?>

								<?php
					/*echo('<pre>');
					print_r($categories);
					echo('</pre>');*/
					//list of categories slug where this list will appear
					$appear = ['apt-foreign-ministers-meeting','ammtc3','aem3','afmgm3','m-atm3','amaf3','amem3','amme3-emm','ammswd3','ammy3','accsm3','almm3','amca3','amri3','aptemm','ahmm3'];
					$a_output = '';
					//related by same category
					foreach($categories as $cat){
						//echo $cat->slug;
						if(in_array($cat->slug, $appear)){
							$a_output .= '<div class="sidebar-left-item same-category detail-sidebar">';						
							$a_output .= do_shortcode('[catlist id='.$cat->term_id.' category_description=yes template=akseki_short-title catname=yes date=yes display_id=yes]');
							$a_output .= '</div>';
						}
					}
					//related by same year
					foreach($categories as $cat){
						//echo $cat->slug;
						if(in_array($cat->slug, $appear)){
							$a_output .= '<div class="sidebar-left-item same-year detail-sidebar">';							
							$a_output .= do_shortcode('[catlist conditional_title="Year '.get_the_date("Y").'" year='.get_the_date("Y").' template=akseki_same-year name="'.implode(",",$appear).'"]');
							$a_output .= '</div>';
						}
					}
					echo $a_output;
				?>
			</div>
			
		</div>
	

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0"><?php echo get_the_title(); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="imagepreview" class="img-fluid">
      </div>
      <!--div class="modal-footer">
        <p>text</p>
      </div-->
    </div>
  </div>
</div>

