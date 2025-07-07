<div class="container" id="about">
	<div class="row">
		<div class="col-md-6">
			<div class="card w-100 h-100 shadow bg-primary text-white">										
				<div class="card-body">
					<h2 class="card-title pt-0 w-100 topic-head">About ASEAN+3</h2>
					<p class="card-text w-100 col-12">ASEAN Plus Three (APT) consist of ten ASEAN Member States and the People’s Republic of China, Japan and the Republic of Korea. The APT Cooperation process began in December 1997 and since than has evolve as the main vehicle to promote East Asian Cooperation towards the long-term goal of building an East Asian Community, with ASEAN as the driving force. The APT has become one of the most comprehensive cooperation frameworks in the region, and APT cooperation continue to be broadened and deepened in a wide range of areas, including political-security, trade and investment, finance, energy, tourism, agriculture and forestry, environment, education, health, culture and arts, etc, among others. The APT also supports the implementation of the ASEAN Community Vision 2025.</p>
					<div class="row mx-3">
					<a href="/about-apt/history" class="btn ab-items btn-primary col-6">	
						<i class="fas fa-archway"></i>
						<p>History</p>
					</a>
					<a href="/about-apt/areas-of-cooperation" class="btn ab-items btn-primary col-6">	
						<i class="fas fa-briefcase"></i>
						<p>Areas of cooperation</p>
					</a>
					</div>
				</div>
			</div>

		</div>
		<div class="col-md-6" id="flags">
			<h3 class="text-center">
				<?php //get_template_part("img/aptlogo3.svg"); ?>
				<span>ASEAN Plus Three Countries</span>
			</h3>
			
			<div class="d-flex justify-content-around w-100 country-flags">
				<?php 
					echo (load_flags_svg("br").
					load_flags_svg("kh").
					load_flags_svg("id").
					load_flags_svg("la").
					load_flags_svg("ml"));
				?>
			</div>
			<div class="d-flex justify-content-around w-100 country-flags">
				<?php 
					echo (load_flags_svg("mm").
					load_flags_svg("ph").
					load_flags_svg("sg").
					load_flags_svg("th").
					load_flags_svg("vn"));
				?>
			</div>
			<div class="w-100 text-center" id="theplus">+</div>
			<div class="d-flex justify-content-around w-100 country-flags">
				<?php 
					echo (load_flags_svg("ch").
					load_flags_svg("jp").
					load_flags_svg("kr"));
				?>
			</div>
		</div>
	</div>
</div>