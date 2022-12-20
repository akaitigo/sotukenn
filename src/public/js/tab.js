$(document).ready(function(){
	var newWidget="<div class='widget-wrapper'> <ul class='tab-wrapper'></ul> <div class='new-widget'></div></div>";
	$(".widget").hide();
	$(".widget:first").before(newWidget);
	$(".widget > div").each(function(){
		$(".tab-wrapper").append("<li class='tab'>"+this.id+"</li>");
		$(this).appendTo(".new-widget");
	});
	$(".tab").click(function(){
		$(".new-widget > div").hide();
		$('#'+$(this).text()).show();
		$(".tab").removeClass("active-tab");
		$(this).addClass("active-tab");
	});
	$(".tab:first").click();

  
  
  
});
