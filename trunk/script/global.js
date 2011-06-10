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
