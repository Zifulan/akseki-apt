<div class="container" id="resources">
	<div class="row">
		
	
		<div class="col-md-8 accordion-container">
			<ul class="accordion" id="front-accordion-resources">
				
				<?php 
				wp_list_categories( array(        
					'exclude' => [1,10,44],
					'title_li' => '',								
				) );														
				?>
				
			</ul>
			
		</div>
		<div class="col-md-4" id="statistics">
				
				<div class="btn btn-outline-dark st-items">				
					<i class="fas fa-chart-line"></i>
					<p><strong>20.8</strong> Foreign direct investment inflow from Plus Three (US$ billion)</p>
				</div>
			
			
				<div class="btn btn-outline-dark st-items">	
					<i class="fas fa-users"></i>
					<p><strong>2,103.4</strong> Population in Million</p>
				</div>
				
				<div class="btn btn-outline-dark st-items">	
					<i class="fas fa-shopping-cart"></i>
					<p><strong>556.4</strong> Total ASEAN trade with Plus Three countries (US$ billion)</p>
				</div>
				<div class="btn btn-outline-dark st-items">				
					<i class="fas fa-dollar-sign"></i>
					<p><strong>14.841,7</strong> Gross domestic product (GDP) at current prices (in US$ billion)</p>
				</div>
				<div class="btn btn-outline-dark st-items">				
					<i class="fas fa-money-bill-wave"></i>
					<p><strong>7.056,1</strong> GDP per capita in US dollars</p>
				</div>
			

			
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
			$(this).addClass('btn btn-block btn-primary text-left');
		});
		
		/*accordion*/		
		$('.accordion-container ul > li:has(> ul)').each(function (idx, ele) {
			$(ele).children('a').attr({"href": ".collapse" + idx, "data-toggle": "collapse"});	
			$(ele).children('a').addClass("have-children");
			$(ele).children('a').append("<span class='plusminus pmplus'>&#43;</span>&nbsp;");
			$(ele).children('ul').addClass("collapse collapse" + idx);
		});
		$('.accordion-container ul > li:not(:has(ul))').each(function (idx, ele) {
			$(ele).children('a').addClass("no-children");
			$(ele).children('a').append("<span class='plusminus pmgoto'>&nearr;</span>&nbsp;");
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
