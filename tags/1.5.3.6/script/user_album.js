//function relativeTime(timestamp){
//	if((timestamp != null) && timestamp.length != 10){
//		return timestamp;
//	}
//	var timestampNow = Math.round(new Date().getTime() / 1000);
//	var distance_in_seconds = timestampNow - timestamp;
//	var distance_in_minutes = Math.round(distance_in_seconds / 60);
//	//if(distance_in_minutes == 0){return 'just uploaded';}
//	if(distance_in_minutes <= 1){
//		return '1 minute ago';
//	}
//	if(distance_in_minutes < 45){
//		return distance_in_minutes + ' minutes ago';
//	}
//	if(distance_in_minutes < 90){
//		return '1 hour ago';
//	}
//	if(distance_in_minutes < 1440){
//		return Math.round(distance_in_minutes /60 ) + ' hours ago';
//	}
//	if(distance_in_minutes < 2880){
//		return '1 day ago';
//	}
//	if(distance_in_minutes < 43200){
//		return Math.round(distance_in_minutes / 1440) + ' days ago';
//	}
//	if(distance_in_minutes < 86400){
//		return '1 month ago';
//	}
//	if(distance_in_minutes < 525960){
//		return Math.round(distance_in_minutes / 43200) + '  months ago';
//	}
//	if(distance_in_minutes < 1051199){
//		return '1 year ago';
//	}
//	return 'hơn ' + Math.round(distance_in_minutes/525960) + ' yeas ago';
//}

$(document).ready(function(){
	$('#search_form select').change(function(){
		$('#search_form').submit();
	});
	$('.relative_time').each(function(){
			$(this).html(relativeTime($(this).html()));
	});
});