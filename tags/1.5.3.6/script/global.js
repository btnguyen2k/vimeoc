var shortcutReg = /^[a-zA-Z]+([a-zA-Z0-9]+)?$/;

function checkEmail(email) {
	var str = "^([a-zA-Z0-9_-]+[\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9_-]+[\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$";
	var re = new RegExp(str);
	if (re.test(email)) {
		return true;
	}
	return false;
}

function checkUrl(url){
	var str="^(((file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp)://)|(www\.))+(([a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6})|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(/[a-zA-Z0-9\&amp;%_\./-~-]*)?$";
	var re=new RegExp(str);
	if (re.test(url)) {
		if(url.indexOf('://')=='-1') $('#associationUrl').val('http://'+url);
			return (true);
	} else {
		return (false);
	}
}

function checkCustomUrl(userUrl, reservedArray){
	for(var i=0; i<reservedArray.length; i++){
		if($.trim(userUrl).toLowerCase() == reservedArray[i].toLowerCase()){
			return false;
		}
	}
	
	return true;
}

function limitAttach(form, file, extArray) {
	allowSubmit = false;
	if (!file) return;
	while (file.indexOf("\\") != -1)
		file = file.slice(file.indexOf("\\") + 1);
		ext = file.slice(file.indexOf(".")).toLowerCase();
		for (var i = 0; i < extArray.length; i++) {
			if (extArray[i] == ext) { allowSubmit = true; break; }
		}
		if (allowSubmit){
			$("#notSupportExt").hide();
			return true;
		}
		else{
			var errorMsg = "Please only upload files that end in types:  " + (extArray.join("  ")) + "<br/>Please select a new " + "file to upload and submit again.";
			$("#notSupportExt").html(errorMsg).show();
		}
			
		return false;
}

function relativeTime(timestamp){
	if((timestamp != null) && timestamp.length != 10){
		return timestamp;
	}
	var timestampNow = Math.round(new Date().getTime() / 1000);
	var distance_in_seconds = timestampNow - timestamp;
	var distance_in_minutes = Math.round(distance_in_seconds / 60);
	//if(distance_in_minutes == 0){return 'just uploaded';}
	if(distance_in_minutes <= 1){
		return '1 minute ago';
	}
	if(distance_in_minutes < 45){
		return distance_in_minutes + ' minutes ago';
	}
	if(distance_in_minutes < 90){
		return '1 hour ago';
	}
	if(distance_in_minutes < 1440){
		return Math.round(distance_in_minutes /60 ) + ' hours ago';
	}
	if(distance_in_minutes < 2880){
		return '1 day ago';
	}
	if(distance_in_minutes < 43200){
		return Math.round(distance_in_minutes / 1440) + ' days ago';
	}
	if(distance_in_minutes < 86400){
		return '1 month ago';
	}
	if(distance_in_minutes < 525960){
		return Math.round(distance_in_minutes / 43200) + '  months ago';
	}
	if(distance_in_minutes < 1051199){
		return '1 year ago';
	}
	return 'more than ' + Math.round(distance_in_minutes/525960) + ' yeas ago';
}
function showFaceboxIframe()
{
	var href = $('a.facebox-iframe').attr('href');
	var $preview = $('<div>');
	$preview.html("<iframe width='500px' height='400px' frameborder='0' src='"+href+"'></iframe>");
	$(document).append($preview);
	$.facebox($preview.html());
	return false;
}

function getFileType(file){
	if(file){
		var lastDot = file.lastIndexOf('.');
		if(lastDot){
			return file.substring(lastDot);
		}
	}
	
	return null;
}

$(document).ready(function(){
	$("input").blur(function(){
		var val = $(this).val();
		val = $.trim(val);
		$(this).val(val);
	});
});