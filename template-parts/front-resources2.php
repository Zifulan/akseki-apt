<?php
function gcc2($catid){
	$categories=get_categories(
		array( 'parent' => $catid )
	);
	$ret = '<ul>';
	foreach ($categories as $c) {
		$ret .= '<li><a title="'.$c->description.'" href="'.get_category_link($c->term_id).'">'.$c->cat_name.'</a></li>';
	}
	$ret .= '</ul>';
	return $ret;
}
?>
<div class="container" id="resources2">

	<button id="headingR2One" data-toggle="collapse" data-target="#collapseR2One" aria-expanded="true" aria-controls="collapseR2One" class="mb-2 btn btn-secondary w-100 text-left accordion-button"><h3 class="mb-0"><?= get_category(40)->description; ?></h3></button>
	<div id="collapseR2One" class="collapse show row" aria-labelledby="headingR2One">
		<div class="col-12 col-lg-4 r2-items">
			<h4><?=get_cat_name(9)?></h4>
			<?php echo do_shortcode('[catlist id=9]'); ?>
		</div>
		<div class="col-12 col-lg-4 r2-items">
			<h4><?=get_cat_name(8)?></h4>
			<?php echo do_shortcode('[catlist id=8]'); ?>
		</div>
		<div class="col-12 col-lg-4 r2-items">
			<h4><?=get_cat_name(45)?></h4>
			<?php echo do_shortcode('[catlist id=45]'); ?>
		</div>
	</div>
	<button id="headingR2Two" data-toggle="collapse" data-target="#collapseR2Two" aria-expanded="true" aria-controls="collapseR2Two" class="mb-2 btn btn-secondary w-100 text-left accordion-button"><h3 class="mb-0">Mechanisms</h3></button>
	<div id="collapseR2Two" class="collapse show" aria-labelledby="headingR2Two">
	    <?php get_template_part("template-parts/sidebar-mechanisms"); ?>
	    <?php /*
	    <div class="row"><!--summit & ministerial-->
    		<div class="col r2-items">
    			<h4><?=get_cat_name(41)?></h4>
    			<?php echo do_shortcode('[catlist id=41 numberposts=5]'); ?>
    			<em><a href="<?=get_category_link(41);?>" class="float-right px-2" style="text-decoration:underline;">more Summit Level Statements&hellip;</a></em>
    		</div>
    		<div class="col">
    			<div class="container">
    			<div class="row">
    				<h4 class="w-100"><?=get_cat_name(43)?></h4>
    				<div class="col r2-items">
    					<h5><?=get_cat_name(63)?></h5>
    					<?php echo(gcc2(63));?>
    				</div>
    				<div class="col r2-items">
    					<h5><?=get_cat_name(47)?></h5>
    					<?php echo(gcc2(47));?>
    				</div>
    				<div class="col r2-items">
    					<h5><?=get_cat_name(54)?></h5>
    					<?php echo(gcc2(54));?>
    				</div>
    			</div>
    			</div>
    		</div>
    	</div>
    	<div class="row"><!--cpr & som-->
			<div class="col r2-items">
				<?php $cprnchild = array(275,276); ?>
				<h4><?=get_cat_name($cprnchild[0])?></h4>
				<ul>
				<?php foreach($cprnchild as $c): ?>
					<li>
						<a href="<?=get_category_link($c);?>" class="" title="<?=strip_tags(term_description($c))?>"><?=get_cat_name($c)?></a>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
			<div class="col">
    			<div class="container">
    			<div class="row">
					<?php
					$thesomcat = 280;
					$somchildren = get_categories(array( 'parent' => $thesomcat));
					//print_r($somchildren);
					echo('<h4 class="w-100">'.get_cat_name($thesomcat).'</h4>');
					foreach($somchildren as $somchild){
						echo('<div class="col r2-items">
								<h5>'.$somchild->name.'</h5>'.
								gcc2($somchild->term_id).'
							</div>');
					}
					?>
    			</div>
    			</div>
    		</div>
		</div>
		<div class="row"><!--other documents & other levels-->
			<div class="col">
				<?php
				$theothcat = 45;
				$othchildren = get_categories(array( 'parent' => $theothcat));
				?>
				<h4><?=get_cat_name($theothcat)?></h4>
				<div class="d-flex align-content-around flex-wrap mb-2">
				<?php
					foreach($othchildren as $othchild){
						echo('<a title="'.$othchild->description.'" href="'.get_category_link($othchild->term_id).'" class="btn btn-primary flex-fill mt-1 mr-1">'.$othchild->name.'</a>');
					}
				?>
				</div>
				<?php echo do_shortcode('[catlist id='.$theothcat.' child_categories=false]'); ?>
			</div>
			<div class="col">
				<div class="container">
    			<div class="row">
					<?php
					$theotlcat = 295;
					$otlchildren = get_categories(array( 'parent' => $theotlcat));
					//print_r($somchildren);
					echo('<h4 class="w-100">'.get_cat_name($theotlcat).'</h4>');
					foreach($otlchildren as $otlchild){
						echo('<div class="col r2-items">
								<h5>'.$otlchild->name.'</h5>'.
								gcc2($otlchild->term_id).'
							</div>');
					}
					?>
    			</div>
    			</div>
			</div>
		</div>
		*/ ?>
	</div>
	<!--a href="<?=get_category_link(45);?>" class="mb-2 btn btn-secondary w-100 text-left"><h3 class="mb-0"><?=get_cat_name(45)?>&nbsp;&nearr;</h3></a-->
</div>

