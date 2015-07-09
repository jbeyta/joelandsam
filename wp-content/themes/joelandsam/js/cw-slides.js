///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//
//   _____      __  ___ _ _    _        
//  / __\ \    / / / __| (_)__| |___ ___
// | (__ \ \/\/ /  \__ \ | / _` / -_|_-<
//  \___| \_/\_/   |___/_|_\__,_\___/__/
//                                      
//
///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

var slides_count = $('.cw-slider li').length;
if(slides_count > 1) {
	$('.cw-slider').bxSlider({
		controls: true,
		pager: false,
		auto: true,
		pause: 5000,
		adaptiveHeight: false,
		autoStart: true,
		onSlideBefore: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
			// console.log(currentSlideHtmlObject);
			$('.active-slide').removeClass('active-slide');
			$('.cw-slider > li').eq(currentSlideHtmlObject + 1).addClass('active-slide');

			var color = $('.active-slide').data('bgcolor');

			// cw_slide_text_color(color);
		},
		onSliderLoad: function () {
			$('.cw-slider > li').eq(1).addClass('active-slide')

			var color = $('.active-slide').data('bgcolor');

			// cw_slide_text_color(color);
		}
	});
} else {
	setTimeout(function(){
		$('.cw-slider li').addClass('active-slide');
	}, 500);
}

function cw_slide_text_color(color) {
	if(color === '#ffffff') {
		$('.slide-caption').css({
			'color': color
		});
		$('.slide-title').css({
			'color': color
		});
		$('.slide-title .subtitle').css({
			'color': color
		});
	} else {
		$('.slide-caption').css({
			'color': '#ffffff'
		});
		$('.slide-title').css({
			'color': color
		});
		$('.slide-title .subtitle').css({
			'color': '#ffffff'
		});
	}

	$('.cw-slideshow').css({
		'background-color': color
	});
}