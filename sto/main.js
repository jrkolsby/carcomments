$(document).ready(function() {
	var toggleSubmit = function(state) {
		switch (state)
		{
			case 0:
				$("#shadowbox-wrapper").animate({
					top: "150%"
				}, 400, function() {
					$("#shadowbox-wrapper").fadeOut(0).css({
						top: "-675px",
					});
					$("#shadow").fadeOut();
				});
				break;
			case 1:
				$("#shadowbox-wrapper").fadeIn(0);
				$("#shadow").fadeIn(function() {
					$("#shadowbox-wrapper").animate({
						top: "50%"
					}, 400, function() {
						$("#shadowbox-wrapper .plate .input").focus();
					});
				});
				break;
		}
	}

	$("#submit").click(function() {
		toggleSubmit(1);
	});
	$("#close").click(function() {
		toggleSubmit(0);
	});
	$(".add").click(function() {
		toggleSubmit(1);
		var val = $(this).attr("ref");
		$("#shadowbox-wrapper .plate .input").attr("value", val);
	});
});