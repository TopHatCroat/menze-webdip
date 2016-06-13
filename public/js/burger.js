$(document).ready(function() {
	console.log($(window).width());
	if($(window).width()<=480) {
		$("#burger").on("click", function() {
			$("#navigationLinks").toggle();
		});
	}
});