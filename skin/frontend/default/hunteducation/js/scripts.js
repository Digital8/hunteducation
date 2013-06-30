var $j = jQuery.noConflict();

$j(window).load(function(){
	
	// preloader: complete
	$j("#preloader").each(function(){
		var preloader = $j(this);
		
		$j(".loader .progress", preloader).stop(true).animate({
			height: "0%"
		}, 700, function(){
			preloader.delay(150).fadeOut(150);
			
			$j('html, body').delay(300).animate({scrollTop:0}, 0);
		});
	});
	
});


$j(document).ready(function(){
	
	// preloader: start
	$j("#preloader").each(function(){
		$j(".loader .progress", preloader).animate({
			height: "50%"
		}, 10000);
	});
	
	
	
	
	// modals
	/*
		<div id="modal-id" class="window-overlay">
			<div class="modal">
				<a href="#" class="modal-close">Close</a>
				
				[Modal content]
			</div>
		</div>
	*/
	$j(".window-overlay").each(function(){
		var overlay = $j(this),
			modal = $j(".modal", this);
		
		// fade out when outside of the modal is clicked
		overlay.on("click", function(){
			overlay.stop(true).fadeOut(150);
		});
		
		// prevent closing the modal when the modal itself is clicked
		modal.on("click", function(){
			event.stopPropagation();
		});
		
		// modal close button
		$j(".modal-close", overlay).on("click", function(){
			overlay.stop(true).fadeOut(150);
			
			return false;
		});
	});
	
	// automatically close alert modals
	$j(".window-overlay.alert").each(function(){
		$j(this).stop(true).fadeIn(150).delay(5000).fadeOut(150);
	});
	
	// enable manual modal launch by clicking on a link
	/*
		<a href="#modal-id" class="launch-modal">Launch my modal</a>
	*/
	$j(".launch-modal").live("click", function(){
		// get target
		var href = $j(this).attr("href");
		
		$j(href).fadeIn(150);
		
		return false;
	});
	
	// position modals to be centered within the window
	positionModals();
	
	// recalculate when window is resized
	$j(window).on("resize", function(){
		positionModals();
	});
	
	function positionModals(){
		$j(".window-overlay").each(function(){
			var overlay = $j(this),
				modal = $j(".modal", this),
				visible = overlay.is(":visible");
			
			// vertically center modal within window
			overlay.show();
			
			var top = (modal.height() / 2 * -1) + "px",
				left = (modal.width() / 2 * -1) + "px";
			
			modal.css({
				"margin-top": top,
				"margin-left": left,
			});
			
			if (!visible){
				overlay.hide();
			}
		});
	}
	
	
	
	
	// tab views
	$j(".tab-view").each(function(){
		var tabView = $j(this);
		
		$j(".tabs li a", tabView).on("click", function(){
			var target = $j(this).attr("href"),
				parent = $j(this).closest("li");
			
			// active state on tabs
			$j(".tabs li.active", tabView).removeClass("active");
			parent.addClass("active");
			
			// active state on tab content
			$j(".tab-content li.active").removeClass("active");
			$j(target).addClass("active");
			
			return false;
		});
	});
	
	
	
	
	// tablet and mobile header nav
	$j("#show-nav").on("click", function(){
		$j("#header-nav").fadeToggle(100);
		
		return false;
	});
	
	
	
	
	// in field labels
	$j("label").inFieldLabels();
	
	// fix pre-filled chrome inputs
	if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0){
	    $j(window).load(function(){
	        $j('input:-webkit-autofill').each(function(){
	        	var inputLabel = $j(this).closest("div").prev("label");
	        	inputLabel.css("display","none");
	        });
	    });
	;}
	
	
	
	
	// validation
	$j("input, textarea, select").live("change", function(){
		$j("+ .validation-advice", $j(this)).fadeOut(200);
		$j("+ label + .validation-advice", $j(this)).fadeOut(200);
		$j("+ label + input + label + .validation-advice", $j(this)).fadeOut(200);
	});
	
	
	
	
	// custom select boxes
	$j("select").customSelect();
	
	
	
	
	// flexslider
	$j(".flexslider").flexslider({
		pauseOnHover: true
	});
});
