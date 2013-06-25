(function($){
	$.getUrlParam = function(name)
	{
		var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		if (r!=null) 
			return unescape(r[2]); 
		return null;
	}
})(jQuery);

$(function(){
	$(".selected").removeClass("selected");
	if($.getUrlParam('constrain'))		
		$("#weibofilter li:last").addClass("selected");
	else
		$("#weibofilter li:first").addClass("selected");
})