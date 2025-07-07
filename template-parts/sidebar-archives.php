

<?php 
	$arc_out = '';
	
	$catsa = get_term_children(7,"category");
	$catsb = get_term_children(45,"category");
	$SA_cats = array_merge($catsa,$catsb);
	
	$SA_query = new WP_Query(array(
		'cat'				=> $SA_cats,
		'orderby'           => 'date',
		'order'             => 'DESC',
		'posts_per_page' =>-1,
		)
	);
	
	
	if( $SA_query->have_posts() ) :
				
		
		
		$arc_arr = [];
		while($SA_query->have_posts()):
			$SA_query->the_post();
			$arc_arr[] = get_the_date('Y');
		endwhile;
		$arc_arr = array_unique($arc_arr);
	endif;
	wp_reset_postdata();
	?>
	
<section>	

	<!--ARCHIVES-->

	<div class="container">				
		<div class="als-container mt-4 mb-0" id="my-als-list">
		<span class="als-prev dashicons dashicons-arrow-left text-primary"></span>
		<div id="archives-inner-content" class="als-viewport">
			<ul class="als-wrapper d-flex">
			<?php 
			$nonce = wp_create_nonce("nonce");    
			foreach($arc_arr as $arc){
				$link_arc = admin_url('admin-ajax.php?action=archiveAjax&year='.$arc.'&nonce='.$nonce);
				if (next($arc_arr)==false){
					$margin = ' style="padding-right:50px;"';
				}else{
					$margin = '';
				}
				echo '<li class="als-item"'.$margin.'><button class="arc_btn px-4 btn text-primary mx-2" data-nonce="' . $nonce . '" data-year="' . $arc . '" href="' . $link_arc . '">'.$arc.'</button></li>';
			}
			?>			
			</ul>
			<span id="grad-left"></span>
			<span id="grad-right"></span>
		</div>
		
		<span class="als-next dashicons dashicons-arrow-right text-primary"></span>
		</div>
		<div class="container p-4">
			<span id="loader" class="bg-white"><img src="<?php echo(get_template_directory_uri()."/img/spinner.gif"); ?>"></span>
			<div id="archives-ajax-content">
				
			</div>
		</div>
		
	</div>

</section>
<script type="text/javascript">
jQuery(document).ready( function() {
   jQuery("#my-als-list").als({
	   scrolling_items: 3,
	   circular: "no",
	   speed: 800,
	   visible_items: "auto",
   });
   jQuery(".arc_btn").click( function(e) {	  
      e.preventDefault();	  
	  jQuery(".arc_btn").removeClass("btn-primary font-weight-bold text-white");
	  jQuery(".arc_btn").addClass("text-primary");
	  jQuery(this).removeClass("text-primary");
	  jQuery(this).addClass("btn-primary font-weight-bold text-white");  
	  year = jQuery(this).attr("data-year");
      nonce = jQuery(this).attr("data-nonce");	  
	  ajaxurl =  "<?php echo(admin_url('admin-ajax.php')); ?>";	  
      jQuery.ajax({
         type : "post",         
         url : ajaxurl,
         data : {action: "archiveAjax", year: year, nonce: nonce},
         beforeSend: function() {
			 jQuery("#archives-ajax-content").fadeOut();
			 jQuery('#loader').show();
		  },
		  complete: function(){
			 jQuery('#loader').hide();
			 jQuery("#archives-ajax-content").fadeIn();
		  },
		 success: function(response) {			
			jQuery("#archives-ajax-content").html(response); 
			/*resArr = response.split("|||");
			jQuery("#archives-ajax-content").html(resArr[0]);  
			imgArr = resArr[1].split(",");
			var item = imgArr[Math.floor(Math.random()*imgArr.length)];
			console.log(item);
			if(!item){
				item = "<?php echo(wp_get_attachment_image_url(1007,"large",false)); ?>";
			}
			
			jQuery("#archives-ajax-content ul").css("background-image"," linear-gradient(to right, rgba(255,255,255,1) 45%, rgba(255,255,255,0) 50%),url("+item+")");
			jQuery("#archives-ajax-content ul").css("background-repeat","no-repeat");
			jQuery("#archives-ajax-content ul").css("background-position","right center");
			jQuery("#archives-ajax-content ul").css("background-size","contain");*/
         }
      })
   })
   //initializing
   jQuery('.arc_btn[data-year="2025"]').trigger('click');
})
</script>
<style>
/*****************************************************
 * generic styling for ALS elements: outer container
 ******************************************************/

.als-container {
	position: relative;
	width: 100%;
	margin: 0px auto;
	z-index: 0;
}
#archives-ajax-content{
    padding-left: 20px;
	padding-right: 20px;
}
#grad-right {
    position: absolute;
    top:0;
    width:2%;
    right: 0;
    bottom: 0;
    content: '';
    display: block;
	background: linear-gradient(to left, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%, rgba(255, 255, 255, 1) 100%);
  }

#grad-left {
    position: absolute;
    top:0;
    left: 0;
    width:2%;
    bottom: 0;
    content: '';
    display: block;
    background: linear-gradient(to right, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%, rgba(255, 255, 255, 1) 100%);
  }
/****************************************
 * viewport styling
 ***************************************/

.als-viewport {
	position: relative;
	overflow: hidden;
	margin: 0px auto;
}

/***************************************************
 * wrapper styling
 **************************************************/

.als-wrapper {
	position: relative;
	/* if you are using a list with <ul> <li> */
	list-style: none;
	border-bottom: #98294b 4px solid;
}

/*************************************
 * item: single list element
 ************************************/

.als-item {
	position: relative;
	display: block;
	text-align: center;
	cursor: pointer;
	float: left;
}

/***********************************************
 * prev, next: buttons styling
 **********************************************/
 
.als-prev, .als-next {
	position: absolute;
	cursor: pointer;
	clear: both;
	z-index: 10;
	font-size:2.5em;
}
.als-prev{
	top:0;
	left:0;
}
.als-next{
	top:0;
	right:0;
}
#loader{
	position: absolute;
margin-left: auto;
margin-right: auto;
left: 0;
right: 0;
text-align: center;
display:none;
}
@media all and (max-width: 1199px) {
	#archives-ajax-content ul{
		background:none!important;
	}
}
@media all and (max-width: 767px) {
	#archives-ajax-content em{
		display:table;
		text-align: left;
	}
}
</style>

