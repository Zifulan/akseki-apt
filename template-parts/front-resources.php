<div class="container" id="resources">
	<div class="row">
		
	
		
		<div class="col-md-7" id="statistics">
				
			<?php
			//get number of years
			$years = floor((strtotime("today")-strtotime("1997-12-15"))/31556952);
			//get numbers of article in summit/ministrial levels
			$summit = get_category(41);
			$min2 = akseki_get_ministrial_categories();
			$totmincount = 0;
			foreach($min2 as $min){			
				$catObj = get_category_by_slug($min); 
				$catcount = $catObj->category_count;
				$totmincount += $catcount;
			}				
			?>
			<div class="row">
				<div class="btn btn-outline-light st-items st-numbers d-flex justify-content-center col-12 shadow-sm" id="st-years">	
					<?php echo '<strong>'.$years.'</strong>Years of Cooperation'; ?>
				</div>				
				<div class="btn btn-outline-dark st-items st-numbers d-flex justify-content-center col-12 shadow-sm" id="st-summit">	
					<?php echo '<strong>'.$summit->count.' </strong>Summit Level Activities'; ?>
				</div>
				<div class="btn btn-outline-dark st-items st-numbers d-flex justify-content-center col-12 shadow-sm" id="st-ministrial">				
					<?php echo '<strong>'.$totmincount.' </strong>Ministerial Level Activities'; ?>
				</div>
			</div>
			<div class="row">
				<!--div class="col-12 pl-0 pr-0">
					<div class="btn btn-dark st-items justify-content-center font-weight-bold">				
						Framework to promote East Asian Cooperation, with ASEAN as the driving force.
					</div>
				</div-->
				<div class="col-6 pl-0 pr-1 d-flex">			
					<div class="btn btn-outline-dark st-items w-100">			
						<i class="fas fa-chart-line"></i>
						<p><strong>20.8</strong> Foreign direct investment inflow from Plus Three (US$ billion)</p>
					</div>
				</div>
				<div class="col-6 pl-1 pr-0 d-flex">
					<div class="btn btn-outline-dark st-items w-100">	
						<i class="fas fa-users"></i>
						<p><strong>2,103.4</strong> Population in Million</p>
					</div>				
				</div>
				<div class="col-6 pl-0 pr-1 d-flex">				
					<div class="btn btn-outline-dark st-items w-100">	
						<i class="fas fa-shopping-cart"></i>
						<p><strong>556.4</strong> Total ASEAN trade with Plus Three countries (US$ billion)</p>
					</div>
				</div>
				<div class="col-6 pl-1 pr-0 d-flex">
					<div class="btn btn-outline-dark st-items w-100">			
						<i class="fas fa-dollar-sign"></i>
						<p><strong>14.841,7</strong> Gross domestic product (GDP) at current prices (in US$ billion)</p>
					</div>
				</div>
				<div class="col-12 pl-0 pr-0">
					<div class="btn btn-outline-dark st-items">				
						<i class="fas fa-money-bill-wave"></i>
						<p><strong>7.056,1</strong> GDP per capita in US dollars</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5 accordion-container">
			<h2 class="font-weight-bold mt-2 pb-0">Resources</h2>
			<hr class="mt-1 mb-0"/>
			<ul class="accordion" id="front-accordion-resources">
				
				<?php 
				wp_list_categories( array(        
					'exclude' => [1,10,44],
					'title_li' => '',
					'depth' => 4,					
				) );														
				?>
				
			</ul>
			
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(function($) {
		/*list desc instead of title*/
		$('#front-accordion-resources .cat-item > a').each(function(){		
			let replacement = $(this).attr('title');
			$(this).html(replacement);
		});
		$('#front-accordion-resources ul').each(function(){
			$(this).addClass('list-group');
		});
		$('#front-accordion-resources li').each(function(){
			$(this).addClass('list-group-item');
		});
		$('#front-accordion-resources a').each(function(){
			$(this).addClass('text-left');
		});
		
		/*accordion*/		
		$('.accordion-container ul > li:has(> ul)').each(function (idx, ele) {
			$(ele).children('a').attr({"href": ".collapse" + idx, "data-toggle": "collapse"});	
			$(ele).children('a').addClass("have-children");
			texta = ($(ele).children('a:contains("Cooperations")').text());
			if(texta == "Political Cooperations" || texta == "Economic Cooperations" || texta == "Socio-cultural Cooperations"){
				$(ele).children('a').append("<span class='plusminus pmplus'>+</span>&nbsp;");
			}else{
				$(ele).children('a').append("<span class='plusminus pmplus'>-</span>&nbsp;");
			}
			$(ele).children('ul').addClass("show collapse" + idx);
		});
		$('.accordion-container ul > li > ul > li > ul > li').each(function (idx, ele) {
			$(ele).children('ul').removeClass('show');
			$(ele).children('ul').addClass("collapse");
		});
		$('.accordion-container ul > li:not(:has(ul))').each(function (idx, ele) {
			$(ele).children('a').addClass("no-children");
		});
		$("a.have-children").click(function(){
			if ($(this).next('.children').is(':visible')) {
			  //alert("sar");
				$(this).children(".plusminus").text('+');
			}else{
				$(this).children(".plusminus").text('-');
				$(this).children(".plusminus").removeClass('pmplus');
				$(this).children(".plusminus").addClass('pmminus');
			}
			/*if( $(this).next(".children").hasClass('show')){
				$(this).children(".plusminus").text('-');
			}else {
				$(this).children(".plusminus").text('+');
			}*/
		});
		
	});
</script>
