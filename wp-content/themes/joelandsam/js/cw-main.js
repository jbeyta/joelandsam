jQuery(document).ready(function($){
	// uncomment below to support placeholders in < IE10
	// $('input, textarea').placeholder();
	// for debugging
	$('pre').each(function(){
		$(this).find('.close-pre').click(function(){
			$(this).toggleClass('open');
			$(this).next('.content').slideToggle();
		});
	});
	
	if( !$("html").hasClass("lt-ie9") ) {
		$(document).foundation();
		console.log("Foundation Js loaded");
	}

	///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	//
	//   _____      __  _                   _                 _ 
	//  / __\ \    / / | |   __ _ ____  _  | |   ___  __ _ __| |
	// | (__ \ \/\/ /  | |__/ _` |_ / || | | |__/ _ \/ _` / _` |
	//  \___| \_/\_/   |____\__,_/__|\_, | |____\___/\__,_\__,_|
	//	                             |__/                       
	//
	///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

	// function cw_lload() {
	// 	$('.lload').each(function(){
	// 		var w_width = $(window).width();
	// 		var offset = $(this).offset();
	// 		var height = $(this).outerHeight();
	// 		var w_height = $(window).height();
	// 		var pos = Math.round(offset.top - $(window).scrollTop());
	// 		var load = w_height - height;
			
	// 		if(w_width <= 640) {
	// 			$(this).removeClass('lloaded');
	// 			$(this).find('.lchild').removeClass('lloaded-child');
	// 			return;
	// 		}

	// 		if(pos <= load) {
	// 			$(this).addClass('lloaded');

	// 			if($(this).hasClass('lchildren')) {
	// 				var lchildren = $(this).find('.lchild'),
	// 				i = 0,
	// 				lload_children = function() {
	// 					$(lchildren[i++]).addClass('lloaded-child');
	// 					if(i < lchildren.length) setTimeout(lload_children, 200);
	// 				}
	// 				lload_children();
	// 			}

	// 		} else {
	// 			$(this).removeClass('lloaded');
	// 			$(this).find('.lchild').removeClass('lloaded-child');
	// 		}
	// 	});
	// }


	///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	//
	//   _____      __    _                    _ _          
	//  / __\ \    / /   /_\  __ __ ___ _ _ __| (_)___ _ _  
	// | (__ \ \/\/ /   / _ \/ _/ _/ _ \ '_/ _` | / _ \ ' \ 
	//  \___| \_/\_/   /_/ \_\__\__\___/_| \__,_|_\___/_||_|
	//                                                      
	//
	///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

	// $('.cwa-section-header').each(function() {
	// 	if($(this).hasClass('open-header')) {
	// 		$(this).next('.cwa-section-content').slideDown(400).addClass('open-tab');
	// 	}
	// });

	// $('.cwa-section-header').click(function(){
		
	// 	if(!$(this).hasClass('open-header')) {
	// 		$('.open-header').removeClass('open-header');
	// 		$(this).addClass('open-header');

	// 	} else if($(this).hasClass('open-header')) {
	// 		$(this).removeClass('open-header');
	// 	}

	// 	$('.cwa-section-content').slideUp(400).removeClass('open-tab');

	// 	if($(this).next('.cwa-section-content').is(':visible')){
	// 		$(this).next('.cwa-section-content').slideUp(400).removeClass('open-tab');
	// 	} else {
	// 		$(this).next('.cwa-section-content').slideDown(400).addClass('open-tab');
	// 	}
	// });

	///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	//
	//  ___ _         _     _  _     _      _   _   
	// | _ ) |___  __| |__ | || |___(_)__ _| |_| |_ 
	// | _ \ / _ \/ _| / / | __ / -_) / _` | ' \  _|
	// |___/_\___/\__|_\_\ |_||_\___|_\__, |_||_\__|
	//                                |___/         
	//
	///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

	// function cw_block_height() {
	// 	$('.eqh-row').each(function(){
	//		var window_w = $(window).width();
	//		var block_h = 0;

	//		if(window_w <= 640) {
	//			$(this).find('.inner').removeAttr('style');
	//			return;
	//		}

	// 		// reset .inner so we can get the actual heights: the style attribute will override the actual height
	// 		$(this).find('.inner').removeAttr('style');

	// 		$(this).find('.inner').each(function(){
	// 			var compare_h = $(this).outerHeight();

	// 			if(compare_h > block_h) {
	// 				block_h = compare_h;
	// 			}
	// 		});

	// 		$(this).find('.inner').css({
	// 			'height': block_h + 'px'
	// 		});
	// 	});

	// 	var eqh_h = 0;
	// 	$('.eqh').each(function(){
	// 		$(this).removeAttr('style');
	// 		var this_h = $(this).outerHeight();

	// 		if(this_h > eqh_h) {
	// 			eqh_h = this_h;
	// 		}
	// 	});

	// 	$('.eqh').css({
	// 		'height': eqh_h + 'px'
	// 	});
	// }
	// cw_block_height();

	// hide captchas (gravity forms)
	$('.gform_wrapper').click(function(event){
		$(this).find('.gf_captcha').slideDown();
		event.stopPropagation();
	});

	$('html').click(function() {
		$('.gf_captcha').slideUp();
	});

	$(window).load(function(){
		$('.cw-slideshow').addClass('loaded');
	});
});