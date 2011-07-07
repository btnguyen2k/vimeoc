<script  type="text/javascript">		
function validate()
{	
	var x = document.getElementById("password").value;
	var e = document.getElementById("email_address").value;
	
	var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	var flag=true;

	
	
    if(pattern.test(e)){     
    	$("#error_valid_email").hide();
    }else{   
    	$("#error_valid_email").show();
    	flag=false;
	}
	if(x==""){
		$("#error_password_invalid").show();
		flag=false;
	}else{
		$("#error_password_invalid").hide();
	}	 
	return flag;
}
</script>
<h1 align="center"><:$title:></h1>
<:if $errorMessage eq "":>
   &nbsp;
<:else:>
   <span class="red"><:$errorMessage:></span>
<:/if:>
<form onSubmit="return validate()" name="signupform" action="<:$ctx:>/admin/login/" method="post">
	<div>
		<ul>
			<li>
				<:$Id:><input name="email" type="text" value="<:$username:>" class="inputs" id="email_address" size="35" maxlength="255">
				<span class="red" id="error_valid_email" style="display: none;"><:$emailInvalid:></span>
			</li>
			<li>
				<:$Password:><input id="password" name="password" type="password" />
				<span class="red" id="error_password_invalid" style="display: none;"><:$passwordInvalid:></span>
			</li>
			<li>
				<input type="submit" value= "Login"/>
			</li>
		</ul>
	</div>
</form>