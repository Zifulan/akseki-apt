<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
	    <!-- Google tag (gtag.js) -->
        <!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-6H2LSC1ZMK"></script>-->
        <!--<script>-->
        <!--  window.dataLayer = window.dataLayer || [];-->
        <!--  function gtag(){dataLayer.push(arguments);}-->
        <!--  gtag('js', new Date());-->
        
        <!--  gtag('config', 'G-6H2LSC1ZMK');-->
        <!--</script>-->
        
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-6H2LSC1ZMK"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-6H2LSC1ZMK');  // First property
          gtag('config', 'G-V2E02382TY');  // Second property
        </script>
        
		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="profile" href="http://gmpg.org/xfn/11"/>
			
			<?php wp_head(); ?>
			<title>
			<?php 
			if(is_front_page()){
				echo 'ASEAN Plus Three';
			}else{
				echo 'APT ';
				echo wp_title();
			} 
			?>
			</title>
		</head>
		<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>
			<div id="wrapper">
				
				
					
					
					
										
					<nav class="fixed-top navbar navbar-expand-lg navbar-dark bg-primary navbar-hover" id="navbar">
						<div class="container d-flex flex-row">
							
								<a class="navbar-brand d-flex flex-row align-items-center text-secondary mr-auto order-0" href="<?php echo get_option( 'siteurl' );?>">
									
									<?php echo load_logo_svg(); ?>
									<span class="navbar-text d-inline-flex" style="flex-direction:column;" id="navbar-text">
									
										<span>ASEAN&nbsp;</span><span>PLUS&nbsp;</span><span>THREE&nbsp;</span>
									</span>
								</a>							
								<button class="order-1 navbar-toggler" type="button" data-target="#avi-navbar-collapse" data-toggle="collapse">        
									<span class="navbar-toggler-icon text-white"></span>
								</button>
								<button type="button" class="order-2 order-lg-4 btn btn-primary" data-toggle="modal" data-target="#searchModal">
									<span class="dashicons dashicons-search"></span>
								</button>
								
								<?php
								wp_nav_menu( array(
									'theme_location'  => 'primary',
									'depth'           => 3, // 1 = no dropdowns, 2 = with dropdowns.
									'container'       => 'div',
									'container_class' => 'collapse navbar-collapse order-3',
									'container_id'    => 'avi-navbar-collapse',
									'menu_class'      => 'navbar-nav ml-auto navbar-right',
									'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
									'walker'          => new WP_Bootstrap_Navwalker(),
								) );
								?>
								
								
								
						</div>
					</nav>
					
					
<!-- Search Modal -->
<div class="modal fade bd-example-modal-lg" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Search</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo do_shortcode( '[searchandfilter fields="search,category" hierarchical=",1"]' ); ?>
      </div>
      
    </div>
  </div>
</div>