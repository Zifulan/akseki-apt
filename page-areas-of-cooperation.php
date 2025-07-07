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
<main id="main" class="site-main site-single">
	<div class="container">
		<div class="row akseki-detail-style1">
			<div class="col-md-12">	
				<article id="post-2100" class="post-2100 page type-page status-publish hentry">
					<header class="entry-header">
						<h1 class="entry-title">Areas of Cooperation</h1>	<hr style="border-bottom:1px gray dotted;margin-bottom:1em;">
					</header>
					<div class="entry-content">
						<div class="row">
							<div class="col-12 col-md-7 col-lg-9 d-flex flex-column justify-content-center">
								
								<?php
								//pull content from Overview
								$current_slug = "areas-of-cooperation";
								$regex = '/\<p?\sclass\=[\'|"]tcp_'.$current_slug.'.*?\>.+?\<\/p\>/';
								$overview_content = get_post(3363);
								preg_match_all($regex, $overview_content->post_content, $desc);
								//echo('<pre>');print_r($desc);echo('</pre>');
								if(!empty($desc)){
									foreach($desc[0] as $d){
										$prefix = 'Eight years later, at';
										$d = preg_replace('/' . preg_quote($prefix, '/') . '/', 'At', $d);	
										echo($d);
									}
								}else{
									//fallback text
									echo('<p>With the implementation of the <a href="https://aseanplusthree.asean.org/asean-plus-three-cooperation-work-plan-2007-2017/">APT Cooperation Work Plan (2007-2017)</a> and the <a href="https://aseanplusthree.asean.org/asean-plus-three-cooperation-work-plan-2018-2022/">succeeding Work Plan (2018 –2022)</a>, the APT cooperation has steadily broadened and deepened over the years.</p><p>Under the <a href="https://aseanplusthree.asean.org/asean-plus-three-cooperation-work-plan-2018-2022/">current Work Plan (2018-2022)</a> the APT countries seek to enhance cooperation in a wide range of areas including political and security; transnational crime; trade and investment; finance; tourism; agriculture and forestry; energy; minerals; micro, small and medium-sized enterprises; science, technology and innovation; environment; rural development and poverty alleviation; social welfare; active ageing; youth; women; civil service; labour; culture and arts; information and media; education; disaster management; public health; and connectivity. Significant progress has been made in various areas of APT cooperation.</p>');
								}
								?>								
								
							</div>
							<div class="col-12 col-md-5 col-lg-3">
								<div class="card shadow">
									<div class="card-body">
										<h4>APT Work Plans:</h4>
										<div class="card-text">
											<?php echo do_shortcode('[catlist id=9]'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--hr class="wp-block-separator has-css-opacity">
						<div>
							<h2>APT Mechanisms Matrix</h2>
							<?php //get_template_part("template-parts/sidebar-mechmatrix"); ?>
						</div-->
					</div><!-- .entry-content -->
				</article><!-- #post-2100 -->
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
