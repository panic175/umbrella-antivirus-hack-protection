idleTime = 0;
jQuery(document).ready(function(){
	jQuerylimit = 5;
	
	if (jQuery.cookie('umbrella_no_popup_please') != '1') {		

		function timerIncrement() {
			idleTime = idleTime + 1;
			if (idleTime > jQuerylimit) { 
				jQuery('.umbrella.subscribe ').show();
				idleTime = 0;
			}
		}
		
		// Fade in subscribe form
		jQuery("#umbrella_subscribe_box").fadeIn();

		// Increment the idle time counter every second.
		var idleInterval = setInterval(timerIncrement, 1000); // 1 second

		// Zero the idle timer on mouse movement.
		jQuery(this).mousemove(function (e) {
			idleTime = 0;
		});
		jQuery(this).keypress(function (e) {
			idleTime = 0;
		});
		
		jQuery.cookie('umbrella_no_popup_please', '1', { expires: 30 });
	} 
});