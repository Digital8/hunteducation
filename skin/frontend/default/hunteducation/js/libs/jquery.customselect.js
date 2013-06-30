(function($){
 $.fn.extend({
 
 	customSelect : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  var defaults = {
		  customClass: null,
		  mapClass:true,
		  mapStyle:true
	  };
	  var options = $.extend(defaults, options);
	  
	  return this.each(function() {
	  		var $this = $(this);
			var currentSelected = $this.find(':selected');
			var html = currentSelected.html() || '&nbsp;';
			var customSelectInnerSpan = $('<span class="inner" />').append(html);
			var customSelectArrow = $('<span class="arrow" />');
			var customSelectSpan = $('<span class="custom-select" />').append(customSelectInnerSpan).append(customSelectArrow);
			var inputLabel = $this.parent().prev("label");
			$this.after(customSelectSpan);
			
			// label style
			if (currentSelected.hasClass("label")){
				customSelectInnerSpan.addClass("label");
				
				// required label
				if ($this.hasClass("required-entry") || inputLabel.hasClass("required")){
					customSelectInnerSpan.append('<em>•</em>');
				}
			}
			else {
				customSelectInnerSpan.removeClass("label");
			}
			
			// hide label
			inputLabel.addClass("hide");
			
			if(options.customClass)	{ customSelectSpan.addClass(options.customClass); }
			if(options.mapClass)	{ customSelectSpan.addClass($this.attr('class')); }
			if(options.mapStyle)	{ customSelectSpan.attr('style', $this.attr('style')); }
			
			var selectBoxWidth = parseInt($this.outerWidth()) - (parseInt(customSelectSpan.outerWidth()) - parseInt(customSelectSpan.width()) );			
			customSelectSpan.css({display:'inline-block'});
			customSelectInnerSpan.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = customSelectSpan.outerHeight();
			
			// original select box
			$this.css({'-webkit-appearance':'menulist-button',width:customSelectSpan.outerWidth(),position:'absolute', opacity:0,height:selectBoxHeight,fontSize:$this.next().css('font-size')}).change(function(){
				
				customSelectInnerSpan.text($this.find(':selected').text()).parent().addClass('changed');
				
				// label style
				if ($this.find(':selected').hasClass("label")){
					customSelectInnerSpan.addClass("label");
					
					// required label
					if ($this.hasClass("required-entry") || inputLabel.hasClass("required")){
						customSelectInnerSpan.append('<em>•</em>');
					}
				}
				else {
					customSelectInnerSpan.removeClass("label");
				}
				
				setTimeout(function(){customSelectSpan.removeClass('open');},60);
				
			}).bind('mousedown',function(){
				customSelectSpan.toggleClass('open');
			}).focus(function(){
				customSelectSpan.addClass('focus');
			}).blur(function(){
				customSelectSpan.removeClass('focus open');
			});
			
	  });
	  }
	}
 });
})(jQuery);
