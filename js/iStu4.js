/* ================================================================ 
Copyright (c) 2011 Stu Nicholls - iStu.co.uk. All rights reserved.
This script and the associated html may be modified in any 
way to fit your requirements.
=================================================================== */

$(document).ready(function () {
timer=0;

	$('.iStu4 > li > a').mouseover(function (event) {
		if (this == event.target) {
			$(this).parent().toggleClass('clicked').children('ul').fadeToggle();
			$(this).siblings().children().removeClass('clicked').find('ul').fadeOut();
			$(this).parent().siblings().removeClass('clicked').find('ul').fadeOut();
		}
	}).addClass('a-top');
	$('.iStu4 ul > li > a').mouseover(function (event) {
		if (this == event.target) {
			$(this).parent().toggleClass('clicked').children('ul').fadeToggle();
			$(this).siblings().children().removeClass('clicked').find('ul').fadeOut();
			$(this).parent().siblings().removeClass('clicked').find('ul').fadeOut();
		}
	}).addClass('a-sub');
	$('.iStu4 li:not(:has(ul)) a').mouseout(function (event) {
		if (this == event.target) {
			$(this).parent().removeClass('clicked');
			$(this).siblings().children().removeClass('clicked').find('ul').fadeOut();
			$(this).parent().siblings().removeClass('clicked').find('ul').fadeOut();
		}
	}).removeClass();

	$(".iStu4").mouseover(function() {
		clearTimeout(timer);
		});
	$(".iStu4").mouseleave(function() {
			timer = window.setTimeout(function(){
				$('.iStu4 li > a').siblings().children().removeClass('clicked').find('ul').fadeOut();
				$('.iStu4 li > a').parent().siblings().removeClass('clicked').find('ul').fadeOut();
			}, 1000);
		}); 

});
