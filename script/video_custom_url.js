function checkVideoCustomUrl(form){
	var regex = /^[a-z0-9]{0,32}$/;
	var alias = $(form).find("#url_alias").val();		

	var flag = regex.test(alias);

	if(!flag){
		$("#error_valid_alias").show();
		return false;
	}else{
		$("#error_valid_alias").hide();
		return true;
	}
}