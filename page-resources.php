<?php
get_header();
?>
<script type="text/javascript">	
//smooth scrolling
jQuery(function($) {			
	$('.smoothscroll').click(function(){
		$('html, body').animate({
			scrollTop: $( $(this).attr('href') ).offset().top
		}, 500);
		return false;
	});			
});
</script>	
<main id="main" class="site-main">	
	<div class="topic-head mt-4">
		<div class="container">
			<h2>Resources</h2>
		</div>
	</div>
	<div class="container pt-4" id="resourcesnew">
		<div class="row">
			<?php
			//echo do_shortcode('[su_accordion class="b_acc"]');
			$rn_overview_content = '<img src="https://aseanplusthree.asean.org/wp-content/uploads/2022/07/android-chrome-512x512-1.png" style="float:left;height:190px;">
			<p>The ASEAN Plus Three (APT) cooperation process began in December 1997 with the convening of an Informal Summit among the Leaders of ASEAN and China, Japan and the ROK at the sidelines of the 2nd ASEAN Informal Summit in Malaysia. The APT Summit was institutionalised in 1999 when the Leaders issued a Joint Statement on East Asia Cooperation at the 3rd APT Summit in Manila. The Joint Statement for the first time determined the main objectives, principles and further directions of APT countries cooperation. In the Joint Statement, the APT Leaders resolved to strengthen and deepen East Asia cooperation at various levels and in various areas, particularly in economic and social, political and other fields.</p>
			<a href="https://aseanplusthree.asean.org/wp-content/uploads/2024/06/APT-Overview-Paper-12-June-2024.pdf" class="btn btn-secondary mb-2">Download the Overview in PDF&nbsp;<i class="ml-2 fas fa-file-pdf"></i></a>
            <a href="https://aseanplusthree.asean.org/overview-of-asean-plus-three-cooperation/" class="btn btn-secondary mb-2">Overview of ASEAN Plus Three Cooperation&nbsp;&nearr;</a>';
			echo do_shortcode('[su_spoiler title="ASEAN Plus Three Cooperation" open="no" style="carbon" icon="plus" anchor="" class="col-12"]'.$rn_overview_content.'[/su_spoiler]');
			?>
		</div>
		<hr class="wp-block-separator has-css-opacity my-3">
		<div class="row">
			<?php 
			$rn_keydocs_content = '<ul>
										<li>
											<a href="/?p=786">Manila Declaration on the 20<sup>th</sup> Anniversary of ASEAN Plus Three Cooperation, 14 November 2017, Manila</a>
										</li>
										<li>
											<a href="/?p=784">Second Joint Statement on East Asia Cooperation Building on the Foundations of ASEAN Plus Three Cooperation, 20 November 2007, Singapore</a>
										</li>
										<li>
											<a href="/?p=780">Joint Statement on East Asia Cooperation, 28 November 1999, Manila</a>
										</li>
									</ul>';
			$rn_plans_content = do_shortcode('[catlist name="work-plans-and-plans-of-action" catname=yes]');
			$rn_agreements_content = do_shortcode('[catlist name="agreements" catname=yes]');
			$rn_otherdocs_content = do_shortcode('[catlist name="other-documents" catname=yes]');
			echo do_shortcode('[su_spoiler title="Key Documents Guiding the Cooperation" open="no" style="b" icon="plus" anchor="" class="col-12"]'.$rn_keydocs_content.'<hr class="my-2">'.$rn_plans_content.'<hr class="my-2">'.$rn_agreements_content.'<hr class="my-2">'.$rn_otherdocs_content.'[/su_spoiler]');
			?>
		</div>
		<hr class="wp-block-separator has-css-opacity my-3">
		
		<?php
		$levels=get_categories(array('parent'=>7));
		foreach($levels as $level){
			if($level->slug == "summit-level-statements"){
				//$spoilercontent = "summit";
				$spoilercontent = '[catlist id='.$level->term_id.' template=akseki_lcptemplate2 numberposts=-1]';
			/*}elseif($level->slug == "director-general-level"){
				$spoilercontent = "dg";*/
			}elseif($level->slug == "cpr-level-statements-and-declarations"){
				$spoilercontent = '[catlist id='.$level->term_id.' template=akseki_lcptemplate2 numberposts=-1]';
			}else{
				$spoilercontent = akseki_get_level_resources($level->term_id);
				/*$pillars=get_categories(array('parent'=>$level->term_id));
				$sc2 = '';
				foreach($pillars as $pillar){
					$topics=get_categories(array('parent'=>$pillar->term_id));
					$sc4 = '';
					foreach($topics as $topic){
						//handle no listing categories
						$cat_extra = get_term_meta( $topic->term_id, '_catextra', true );
						//print_r($cat_extra);
						$extra_title = '<h5><u>'.$topic->name.'</u></h5>';
						if($cat_extra == "has_no_listing"){
							$sc5 = echo_category_descriptor($topic->term_id).'<em class="float-right"><a href="'.get_category_link($topic->term_id).'">more about '.$topic->name.'&hellip;</a></em>';
						}else{
							$sc5 = '[catlist id='.$topic->term_id.' template=akseki_lcptemplate2 numberposts=-1]';
						}
						$sc4 .= '[su_tab title="<h5>'.$topic->name.'</h5><em>'.$topic->description.'</em>" disabled="no" anchor="" url="" target="blank" class=""]'.$sc5.'[/su_tab]';					}
					$sc3 = '[su_tabs style="default" active="1" vertical="yes" class=""]'.$sc4.'[/su_tabs]';
					$sc2 .= '[su_spoiler title="'.$pillar->name.'" open="no" style="default" icon="plus" anchor=""]'.$sc3.'[/su_spoiler]<hr class="my-2">';
				}
				$spoilercontent = do_shortcode('[su_accordion class="b_acc ml-4 '.$level->slug.'"]'.$sc2.'[/su_accordion]');*/				
			}
			
			echo('<div class="row" id="resources-'.$level->slug.'">');
			echo do_shortcode('[su_spoiler title="'.$level->name.'" open="no" style="wood" icon="plus" anchor="" class="col-12"]'.$spoilercontent.'[/su_spoiler]');
			echo('</div>');
			echo('<hr class="wp-block-separator has-css-opacity my-3">');
		}
		//echo('<pre>');print_r($levels);echo('</pre>');
		?>
		
		<!--div class="row">
		<?php /*
		$rn_otd_content = do_shortcode('[catlist name="other-documents"]');
		echo do_shortcode('[su_spoiler title="Other Documents" open="no" style="wood" icon="plus" anchor="" class="col-12"]'.$rn_otd_content.'[/su_spoiler]');
		*/ ?>
		</div-->		
	</div>
</main>
<style>
#resourcesnew .su-spoiler-title{
	font-size: 1.1rem !important;
}
#resourcesnew .su-spoiler {
    margin-bottom: 0;
}
#resourcesnew .su-spoiler-content>ul{
	margin-bottom:0!important;
}
</style>
<?php
get_footer();
