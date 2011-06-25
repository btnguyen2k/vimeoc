$(document).ready(function(){
	$('#search_form select').change(function(){
		$('#search_form').submit();
	});
	$('.relative_time').each(function(){
			$(this).html(relativeTime($(this).html()));
	});
});