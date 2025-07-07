<?php get_header(); ?>
<main id="main" class="site-main">
	<div class="container" id="avi-content">
		<header class="page-header">
			<h1 class="page-title">ASEAN Plus Three in the News</h1>
			<hr style="border-bottom:1px gray dotted;margin-bottom:1em;">
		</header>
		<div class="row">
			<div class="col-12 col-md-2">	
				<div class="alm-filter-nav mt-4">			
					<div id="aptn_search" class="input-group">
						<?php //echo do_shortcode( '[searchandfilter fields="search" post_types="aptn_news"]' ); ?>
						<div class="input-group mb-3">
						  <input id="aptnsearchinput" placeholder="Search News&hellip;" type="text" class="form-control">
						  <div class="input-group-append">
							<span class="input-group-text" id="aptnsearchbutton" type="button">&#128269;</span>
							<button hidden id="aptnsearchbuttonhidden" type="button" data-posts-per-page="5" data-post-type="aptn_news" data-repeater="default" data-tag="" data-scroll="false" data-button-label="More&hellip;" data-month="" data-year="" data-search="">&#128269;</button>
						  </div>
						</div>
					</div>
					<hr>
					
					<div id="aptn-sidebar-archives">
						<h4>Archives</h4>				
						<!--select class="custom-select" name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;"-->
						<select onchange="testr(this);" class="custom-select aptn_period" name="archive-dropdown" id="aptn_period">
							<option value="anytime" selected="selected">Any time</option> 
							<?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option', 'show_post_count' => 0, 'post_type' => 'aptn_news', 'echo' => 1 ) ); ?>
						</select>				
					</div>
					<hr>
					<h4>Topics</h4>
				
				  <button id="allbutton" class="btn btn-primary w-100 mb-2" type="button" data-posts-per-page="5" data-post-type="aptn_news" data-repeater="default" data-scroll="false" data-button-label="More&hellip;" data-tag="" data-aptn-parent="-1" data-month="" data-year="" data-search="">All</button>
				  <button class="btn btn-primary w-100 mb-2" type="button" data-posts-per-page="5" data-post-type="aptn_news" data-repeater="default" data-tag="topic_summit" data-scroll="false" data-button-label="More&hellip;" data-aptn-parent="41" data-month="" data-year="" data-search="" data-search="">Summit</button>
				  <button class="btn btn-primary w-100 mb-2" type="button" data-posts-per-page="5" data-post-type="aptn_news" data-repeater="default" data-tag="topic_political" data-scroll="false" data-button-label="More&hellip;" data-aptn-parent="63" data-month="" data-year="" data-search="">Political</button>
				  <button class="btn btn-primary w-100 mb-2" type="button" data-posts-per-page="5" data-post-type="aptn_news" data-repeater="default" data-tag="topic_economic" data-scroll="false" data-button-label="More&hellip;" data-aptn-parent="47" data-month="" data-year="" data-search="">Economic</button>
				  <button class="btn btn-primary w-100 mb-2" type="button" data-posts-per-page="5" data-post-type="aptn_news" data-repeater="default" data-tag="topic_socio-cultural" data-scroll="false" data-button-label="More&hellip;" data-aptn-parent="54" data-month="" data-year="" data-search="">Socio-cultural</button>
					<?php
					$tniArr = ['topic_summit','topic_political','topic_economic','topic_socio-cultural'];
					$tagnotin = [];
					foreach($tniArr as $tni){					
						$tniObj = get_term_by('slug', $tni,'post_tag');
						$tagnotin[] = $tniObj->term_id;
					}
					$tagnotinStr = implode(',',$tagnotin);
					//print_r($tagnotin);  //but tag__not_in doesn't work...
				  ?>
				  <button class="btn btn-primary w-100 mb-2" type="button" data-posts-per-page="5" data-post-type="aptn_news" data-repeater="default" data-tag="topic_other" data-scroll="false" data-button-label="More&hellip;" data-aptn-parent="-2" data-month="" data-year="" data-search="">Other</button>
				<!--datefilter-->
				<button hidden id="hiddendatefilter" type="button"  data-posts-per-page="5" data-post-type="aptn_news" data-repeater="default" data-scroll="false" data-button-label="More&hellip;" data-aptn-parent="-1" data-tag="" data-search="">All</button>
				
				</div>
				<hr>
				<div id="aptn-sidebar-ma">
					
					
					
					<div id="aptn-sidebar-meetings">				
						<?php aptn_fe_front(); ?>
					</div>
					
									
				</div>								
			</div>				
			<div class="col-12 col-md-10">				
				<div id="aptn_main_front">
					<?php echo(do_shortcode('[ajax_load_more container_type="div" post_type="aptn_news" archive=”true”]'));	?>
				</div>
			</div>
		</div>
	</div>	
</main>
<script>

	function testr(sel){
		
			var valueSelected  = sel.value;
			//var topicSelected   = jQuery('.alm-filter-nav button.active').attr('data-tag');
			var getyear = /\d{4}/.test(valueSelected) ? valueSelected.replace(/^[^\d]*(\d{4}).*$/, '$1') : 'yearNoValue';
			var getmonth = /\d{4}/.test(valueSelected) ? valueSelected.replace(/^.+\/(\d\d)\/.+$/, '$1') : 'monthNoValue';
			console.log(getmonth);
			console.log(getyear);
		
			 //jQuery("#hiddendatefilter").attr("data-tag", topicSelected);
			 jQuery("#hiddendatefilter").attr("data-year", getyear);
			 jQuery("#hiddendatefilter").attr("data-month", getmonth);
			 jQuery("#hiddendatefilter").click();
		
	}
	
	//handle the search
	jQuery("#aptnsearchbutton").click(function(event){		
        searchnews();
    }); 
	
	jQuery('#aptnsearchinput').bind("enterKey",function(e){
		searchnews();
	});
	jQuery('#aptnsearchinput').keyup(function(e){
		if(e.keyCode == 13)
		{
			jQuery(this).trigger("enterKey");
		}
	});
	function searchnews(){
		var searchterm = jQuery("#aptnsearchinput").val();
        jQuery("#aptnsearchbuttonhidden").attr("data-search",searchterm);
		jQuery("#aptnsearchbuttonhidden").click();
	}
	
	jQuery(function($){				
		/**
		 * Filter button click event.
		 *
		 * @param {*} event
		 */
		function filterClick(event) {
			event.preventDefault();
		 
			// Exit if button active.
			if (this.classList.contains('active')) {
				return;
			}
		 
			// Get .active element.
			var activeEl = document.querySelector('.alm-filter-nav button.active');
			if (activeEl) {
				activeEl.classList.remove('active');
			}
			
			// Add active class.
			if(this.id == "hiddendatefilter" || this.id == "aptnsearchbuttonhidden"){
				jQuery("#allbutton").addClass("active");
			}else{
				this.classList.add('active');
				jQuery("#aptn_period").val("anytime");
			}
			
			
			
			// Set filter params
			var transition = 'fade';
			var speed = 250;
			var data = this.dataset;
			console.log(this.dataset);
			// Call core Ajax Load More `filter` function.
			// @see https://connekthq.com/plugins/ajax-load-more/docs/public-functions/#filter
			ajaxloadmore.filter(transition, speed, data);
			var topic_select = $(this).data('aptn-parent');
			
			jQuery.ajax({
				type: "post",
				url: "<?php echo admin_url( 'admin-ajax.php' ) ?>",
				
				data: { 
					action:	"aptn_fe_front",
					"parent": topic_select,
					},
				success: function(response){						
					$('#aptn-sidebar-meetings').html(response);
					
				},				
			});
		}
		 
		// Get all filter buttons.
		var filter_buttons = document.querySelectorAll('.alm-filter-nav button');
		if (filter_buttons) {
			// Set initial active item.
			//filter_buttons[0].classList.add('active');
			filter_buttons[1].classList.add('active');
		 
			// Loop buttons.
			[].forEach.call(filter_buttons, function (button) {
				// Add button click event.
				button.addEventListener('click', filterClick);
			});
		}
	});
</script>
<?php get_footer(); ?>