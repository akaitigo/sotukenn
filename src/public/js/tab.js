
$(document).ready(function () {
	let url = new URL(window.location.href);// URLを取得
	let params = url.searchParams;// URLSearchParamsオブジェクトを取得
	var list = document.getElementById("widget");
	if (params.get('tab') != 2) {
		var newWidget = "<div class='widget-wrapper'> <ul class='tab-wrapper'></ul> <div class='new-widget'></div></div>";
		$(".widget").hide();
		$(".widget3").hide();
		$(".widget:first").before(newWidget);
		$(".widget > div").each(function () {
			$(".tab-wrapper").append("<li class='tab'>" + this.id + "</li>");
			$(this).appendTo(".new-widget",);
		});
		$(".tab").click(function () {
			$(".new-widget > div").hide();
			$('#' + $(this).text()).show();
			$(".tab").removeClass("active-tab");
			$(this).addClass("active-tab");
		});
		$(".tab:first").click();
	} else {
		var newWidget = "<div class='widget-wrapper'> <ul class='tab-wrapper'></ul> <div class='new-widget'></div></div>";
		$(".widget3").hide();
		$(".widget3").before(newWidget);
		$(".widget > div").each(function () {
			$(".tab-wrapper").append("<li class='tab'>" + this.id + "</li>");
			$(this).appendTo(".new-widget",);
		});
		$(".tab").click(function () {
			$(".new-widget > div").hide();
			$('#' + $(this).text()).show();
			$(".tab").removeClass("active-tab");
			$(this).addClass("active-tab");
		});
		$(".tab").click();
	}
});
