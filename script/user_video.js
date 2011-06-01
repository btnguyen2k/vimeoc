$(document).ready(function(){
	$('#search_form select').change(function(){
		$('#search_form').submit();
	});
});