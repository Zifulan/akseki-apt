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

<div class="su-posts su-posts-single-post <?php echo esc_attr( $atts['class'] ); ?>">

	<?php if ( $posts->have_posts() ) : ?>
		<?php while ( $posts->have_posts() ) : ?>
			<?php $posts->the_post(); ?>

			<?php if ( ! su_current_user_can_read_post( get_the_ID() ) ) : ?>
				<?php continue; ?>
			<?php endif; ?>

			<div id="su-post-<?php the_ID(); ?>" class="su-post <?php echo esc_attr( $atts['class_single'] ); ?>">
				
				<div class="su-post-content">
					
					<?php
					$theid = get_the_ID();
					if($theid == 4764){
						//if SOM
						$theparent = 280;
					}elseif($theid == 4802){
						//if Other Levels
						$theparent = 295;
					}else{
						//else Ministerial
						$theparent = 43;
					}
					$children = get_terms( array(
									'taxonomy'   => 'category',
									'parent'     => $theparent,
								) );					
					?>
					<?php //print_r($children); ?>
					<?php if(!empty($children)): ?>
					<div class="accordion" id="accordionSOM">
					<?php foreach($children as $child):?>
					<?php $grandchildren = get_terms( array(
									'taxonomy'   => 'category',
									'parent'     => $child->term_id,
								) );
					?>

  <div class="card">
    <div class="card-header" id="heading<?= $child->term_id?>">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $child->term_id?>" aria-expanded="true" aria-controls="collapse<?= $child->term_id?>">
          <?= $child->name?>
        </button>
      </h2>
    </div>

    <div id="collapse<?= $child->term_id?>" class="collapse" aria-labelledby="heading<?= $child->term_id?>" data-parent="#accordionSOM">
      <div class="card-body">
        
		<div class="row">
			<div class="col-3">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<?php $first = TRUE; ?>
					<?php foreach($grandchildren as $grandchild):?>
					<button title="<?=$grandchild->description?>" class="btn btn-outline-primary mb-1 nav-link<?php echo $first==TRUE ? " active" : ""; ?>" id="v-pills-<?=$grandchild->term_id?>-tab" data-toggle="pill" data-target="#v-pills-<?=$grandchild->term_id?>" type="button" role="tab" aria-controls="v-pills-<?=$grandchild->term_id?>" aria-selected="<?php echo $first==TRUE ? "true" : "false"; ?>"><?=$grandchild->name?></button>
					<?php $first = FALSE; ?>
					<?php endforeach;?>
				</div>
			</div>
			<div class="col-9">
				<div class="tab-content" id="v-pills-tabContent">
					<?php $first = TRUE; ?>
					<?php foreach($grandchildren as $grandchild):?>
					<div class="tab-pane fade<?php echo $first==TRUE ? " show active" : ""; ?>" id="v-pills-<?=$grandchild->term_id?>" role="tabpanel" aria-labelledby="v-pills-<?=$grandchild->term_id?>-tab">
						<?php 
						
						$somargs = array('category' => $grandchild->term_id,'post_status' => 'future,publish');
						$somposts = get_posts($somargs);
						
						$prev_year = null;
						$lcp_display_output = '';
						foreach($somposts as $key=>$sompost){
							
							$this_year = get_the_date('Y',$sompost->ID);
							//echo($prev_year);
							//echo($this_year);
							if ($prev_year != $this_year) {	  
							  if (!is_null($prev_year)) {
								 $lcp_display_output .= '</ul><hr/>';		 
							  }
							  $lcp_display_output .= '<strong class="lcp_s_ul'.($sompost->post_status == "future"?" text-secondary":"").'">'.$this_year.'</strong>';
							  $lcp_display_output .= '<ul class="lcp_b_ul">';
							}

							//Show the title and link to the post:
							
							$thetags = get_the_tags($sompost->ID);
							$thetagsarr = wp_list_pluck($thetags,"name");
							if($sompost->post_status == "future"){
								$lcp_display_output .= '<li class="text-secondary"><span class="badge badge-secondary text-white mr-2">upcoming&nbsp;➧</span>'.$sompost->post_title.'</li>';
							}elseif(in_array("hasnocontent",$thetagsarr)){
								$lcp_display_output .= '<li>'.$sompost->post_title.'</li>';
							}else{
								$lcp_display_output .= '<li><a href="'.get_permalink($sompost->ID).'">'.$sompost->post_title.'</a></li>';
							}

							if ($prev_year == $this_year) { 
							$lcp_display_output .= '</ul>';
							}

							$prev_year = $this_year;
						}
						echo($lcp_display_output);
						wp_reset_postdata();
						?>
					</div>
					<?php $first = FALSE; ?>
					<?php endforeach;?>
				</div>
			</div>
		</div>
      </div>
    </div>
  </div>
  
  

					
					<?php endforeach;?>
					</div>
					<?php //else: ?>
					<?php //echo("SOM Level"); ?>
					<?php endif; ?>
				</div>
			</div>

			<?php break; ?>
		<?php endwhile; ?>
	<?php else : ?>
		<h4><?php esc_html_e( 'Posts not found', 'shortcodes-ultimate' ); ?></h4>
	<?php endif; ?>

</div>
