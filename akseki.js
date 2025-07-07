jQuery(function($) {
	/* When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size*/
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
		//document.getElementById("navbar").style.padding = "5px 20px";
		//document.getElementById("navbar").style.position = "fixed";
		//document.getElementById("navbar").style.opacity = ".85";
		document.getElementById("logo").style.opacity = "1";
		document.getElementById("logo").style.height = "35px";
		document.getElementById("avi-navbar-collapse").style.fontSize = "1rem";
		document.getElementById('navbar-text').style.flexDirection = "row";
		document.getElementById('navbar-text').style.fontSize = "1rem";
	  } else {
		//document.getElementById("navbar").style.padding = "10px 20px";
		//document.getElementById("navbar").style.position = "relative";
		//document.getElementById("navbar").style.opacity = "1";
		document.getElementById("logo").style.opacity = "1";
		document.getElementById("logo").style.height = "70px";
		document.getElementById("avi-navbar-collapse").style.fontSize = "1.2rem";
		document.getElementById('navbar-text').style.flexDirection = "column";
		document.getElementById('navbar-text').style.fontSize = "1.2rem";
	  }
	}

	/*add class to search modal window for bootstrap styling*/
	$("#searchModal input, #searchModal select").addClass("form-control");
	$("#searchModal input[type='submit']").addClass("btn btn-primary");
	
	/*navbar*/					
	if (matchMedia) {
		const mq = window.matchMedia( "(min-width: 992px)" );
		mq.addListener(WidthChange);
		WidthChange(mq);
	}
	function WidthChange(mq) {
		if (mq.matches) {
			/*for big screens, open on hover*/
			$('#avi-navbar-collapse > ul.navbar-nav li.dropdown').hover(function() {
				$(this).find('> .dropdown-menu').stop(true, true).delay(200).fadeIn(200);
			}, function() {
				$(this).find('> .dropdown-menu').stop(true, true).delay(200).fadeOut(200);
			});
			$('#avi-navbar-collapse > ul.navbar-nav li.dropdown a.dropdown-toggle').click(function() {
				
				window.location.href = this.href;
			});
		}else{
			$('#avi-navbar-collapse ul li ul li a').click(function(e){
				if($(this).attr('href') == "#" || $(this).attr('href') == "" || $(this).hasClass('dropdown-toggle')){
					e.preventDefault();
					e.stopPropagation();
					/*let sibling_ul = $(this).siblings('ul');
					console.log(sibling_ul);
					console.log(this);
					$(this).clone().wrap( "<div class='new'></div>" ).appendTo(sibling_ul);*/
					//$('#avi-navbar-collapse ul li ul li .dropdown-menu').toggle('fast');
					$(this).siblings('ul.dropdown-menu').toggle();
				}
			});
		}
	}
	
	/*popup image in detail post
	
	$(".popup-image").click(function() {
		preventDefault();
		alert('te');
	   $('#imagepreview').attr('src', $('#imageresource').attr('src')); // here asign the image to the modal when the user click the enlarge link
	   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
	});*/

	$( ".popup-image" ).click(function() {
		$imgsrc = $(this).find('> img').attr('src');
		$imgsrc = ($imgsrc.replace(/-\d+?x\d+?\./,'.'));
		$('#imagepreview').attr('src', $imgsrc);
		$('#imagemodal').modal('show');
		$thetitle=$(this).find('> img').attr('alt');
		$('#image-title').html($thetitle);
	});
	
	/*resources submenu in nav to right-align*/
	$resourcesSelector = "ul[aria-labelledby='menu-item-dropdown-304']";
	$($resourcesSelector).addClass("dropdown-menu-right");
	$($resourcesSelector).css("left", "auto");
	
	/*sidebar in detail page*/
	function toggleIcon(e) {		
        $(this)            
            .find(".more-less")
            .toggleClass('dashicons-arrow-down dashicons-arrow-up');
    }
    $('.detail-sidebar').on('hidden.bs.collapse', toggleIcon);
    $('.detail-sidebar').on('shown.bs.collapse', toggleIcon);	
    
      //jQuery smooth scrolling on anchor in the same page
  // Select all links with hashes
  $('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });	
});