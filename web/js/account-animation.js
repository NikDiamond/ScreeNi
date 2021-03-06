$.fn.animateRotate = function(angle, duration, easing, complete) {
  var args = $.speed(duration, easing, complete);
  var step = args.step;
  return this.each(function(i, e) {
    args.complete = $.proxy(args.complete, e);
    args.step = function(now) {
      $.style(e, 'transform', 'rotate(' + now + 'deg)');
      if (step) return step.apply(e, arguments);
    };

    $({deg: 0}).animate({deg: angle}, args);
  });
};
$(document).ready(function() {
	$('.accountWrap').css({opacity: 0}).animate({
		opacity: 1
	}, 1000);
	$('body').delegate(".itemRemoved", "mouseenter", function() {
		$(this).animate({
			opacity: 1,
		}, 200);
	}).delegate(".itemRemoved", "mouseleave", function() {
		$(this).animate({
			opacity: 0.8,
		}, 200);
	}).delegate(".itemWrap", "mouseenter", function() {
		var id = $(this).attr('id');
		$('#itemTop-'+id).stop().animate({
			marginTop: 0,
		}, 100);
		$('#itemBottom-'+id).stop().animate({
			marginTop: '65px',
		}, 100);
	}).delegate(".itemWrap", "mouseleave", function() {
		var id = $(this).attr('id');
		$('#itemTop-'+id).stop().animate({
			marginTop: '-20px',
		}, 100);
		$('#itemBottom-'+id).stop().animate({
			marginTop: '100px',
		}, 100);
	});
});