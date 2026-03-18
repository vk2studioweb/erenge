(function($) {
	$.fn.JQPositioningVK2 = function() {
		for(var i = 0; i < $(this).length; i++){

			var div_width = $(this[i]).outerWidth(),
			div_height = $(this[i]).outerHeight(),
			size_subtraction = 0,
			size_division = 0,
			style = '';
			styleDiv = $(this[i]).attr('style'),
			imgWidth = $(this[i]).find('img').width(),
			imgHeight = $(this[i]).find('img').height();

			if(styleDiv == null || styleDiv == 'position: relative;'){
				$(this[i]).attr('style', 'position: relative;');
			} else{
				$(this[i]).attr('style', styleDiv + ' position: relative;');
			}

			if(imgWidth <= 0){ 
				imgWidth = $(this[i]).find('img').width();
				imgHeight = $(this[i]).find('img').height();
			}
			if(imgHeight <= 0){ 
				imgWidth = $(this[i]).find('img').width();
				imgHeight = $(this[i]).find('img').height();
			}

			
			$(this[i]).find('img').css({'width': div_width, 'height': 'auto'});
			if(div_height >= $(this[i]).find('img').height()){
				$(this[i]).find('img').css({'width': 'auto', 'height': div_height});
			}
			
			style = $(this[i]).find('img').attr('style');
			
			if($(this[i]).find('img').width() > div_width){
				var imgWidth = $(this[i]).find('img').width();
				size_subtraction = imgWidth - div_width;
				
				if(size_subtraction >= 0) {
					size_division = size_subtraction/2;
					style = style+' position:absolute; top:0; left:-'+size_division+'px;';
					$(this[i]).find('img').attr('style', style);
				} else {
					size_division = (size_subtraction/2)*-1;
					style = style+' position:absolute; top:0; left:'+size_division+'px;';
					$(this[i]).find('img').attr('style', style);
				}
			} else if($(this[i]).find('img').height() > div_height){
				var imgHeight = $(this[i]).find('img').height();
				size_subtraction = imgHeight - div_height;
				if(size_subtraction >= 0) {
					size_division = size_subtraction/2;
					style = style+' position:absolute; left:0; top:-'+size_division+'px;';
					$(this[i]).find('img').attr('style', style);
				} else {
					size_division = (size_subtraction/2)*-1;
					style = style+' position:absolute; left:0; top:'+size_division+'px;';
					$(this[i]).find('img').attr('style', style);
				}
			}
		}
	};
})(jQuery);
