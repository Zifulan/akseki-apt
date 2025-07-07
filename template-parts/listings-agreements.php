<?php
$the_cats = get_the_category();
$catslugs = wp_list_pluck($the_cats,'slug');

if($args['curcatslug']=="other-documents" and !in_array("other-documents",$catslugs)):
	//do nothing
else:
    
    if(has_post_thumbnail()){
    	$thumb = '<img src="'.get_the_post_thumbnail_url( get_the_id(), "medium_large" ).'" class="" alt="'.get_the_title().'"/>';			
    }else{
    	$thumb = wp_get_attachment_image(1007,"medium", "", array( "class" => "card-img-top" ));
    }
?>
<style>
	.meta-location{float:left;}
	.meta-date{float:right;}
	.psm{
		border-top: grey 1px dotted;
		padding-top: 0.5em;
	}
</style>
<div id="post-<?=get_the_id();?>" class="card col-12 col-sm-6 col-md-4 col-lg-3 p-0 my-2">
	<div class="card-header">
		<small class=""><?=akseki_get_the_meta(get_the_id());?></small>
	</div>
	<?=$thumb;?>
	<div class="card-body">
		<?php
			$SM = akseki_get_sm(get_the_id());
			if(!empty($SM)){
				$h5 = $SM;
				$p = '<p class="psm">'.get_the_title().'</p>';
			}else{
				$h5 = get_the_title();
				$p = '';
			}
		?>
		<h5 class="card-title"><?=$h5;?></h5>
		<?=$p;?>
		<small class="text-muted text-muted text-right d-block font-italic">
			<a href="<?=get_permalink();?>">read more&hellip;</a>
		</small>
	</div>
	<div class="card-footer">
		<small class="text-muted">
			<?php 
			$the_cats = get_the_category();
			$ministrial_cats = akseki_get_ministrial_categories();
			
			$catid=0;
			if ( in_category(41) ) {
				$catext = 'Summit Level Statements';
				$catid = 41;
			}elseif(akseki_post_is_in_a_subcategory(43)){
				
				foreach($ministrial_cats as $cat){
					$catobj = get_term_by('slug',$cat,'category');
					if(in_category($catobj->term_id)){
						$catid = $catobj->term_id;
						$catext = 'Ministrial Level &Gt; '.$catobj->name;
					}
				}
				
			}else{
				$catext = 'other';
			}
			if($catid!==0){
				echo('<a href="'.get_category_link($catid).'" title="'.$catext.'">'.$catext.'</a>');
			}else{
				echo($catext);
			}			
			?>
		</small>
	</div>
</div>

<?php
endif;
?>