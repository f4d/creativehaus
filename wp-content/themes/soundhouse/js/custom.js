
        var jknew = jQuery.noConflict();
		jknew(document).ready(function(){
			jknew('img.captify').captify({
				// all of these options are... optional
				// ---
				// speed of the mouseover effect
				speedOver: 'fast',
				// speed of the mouseout effect
				speedOut: 'normal',
				// how long to delay the hiding of the caption after mouseout (ms)
				hideDelay: 500,	
				// 'fade', 'slide', 'always-on'
				animation: 'slide',		
				// text/html to be placed at the beginning of every caption
				prefix: '',		
				// opacity of the caption on mouse over
				opacity: '0.7',					
				// the name of the CSS class to apply to the caption box
				className: 'caption-bottom',	
				// position of the caption (top or bottom)
				position: 'bottom',
				// caption span % of the image
				spanWidth: '100%'
			});
		});
              	jknew(function() {
    		jknew("#logoslider").jCarouselLite({
						btnNext: ".next",
						 btnPrev: ".prev",
                        visible: 1, 
                         auto: false,
                         speed: 500
        		     }); 
                           });
