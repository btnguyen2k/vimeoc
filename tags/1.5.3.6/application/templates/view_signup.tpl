<link rel="stylesheet" type="text/css" href="/script/facebox/facebox.css" />
<script language="javascript" src="/script/jquery.min.js"></script>
<script language="javascript" src="/script/facebox/facebox.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('a.facebox-iframe').click(function(link){
			showFaceboxIframe();
			return false;
		});
	});
	function checkEmail(){
		var x = document.getElementById("password").value;
		var y = document.getElementById("rpassword").value;
		var z = document.getElementById("fullname").value;
		var e = document.getElementById("email_address").value;
		var term=$("#agree").attr("checked");
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		var flag=true;

		if(x==""){
			$("#error_valid_password").show();
			$("#error_less_password").hide();
			flag=false;
		}
		else if(x.length<5){
			$("#error_less_password").show();
			$("#error_valid_password").hide();
			flag=false;
		}else{
			$("#error_valid_password").hide();
			$("#error_less_password").hide();
		}

		if(y==""){
			$("#error_valid_rpassword").show();
			$("#error_less_rpassword").hide();
			flag=false;
		}
		else if(x!=y){
			$("#error_valid_mpassword").show();
			$("#error_valid_rpassword").hide();
			flag=false;
		}else{
			$("#error_valid_rpassword").hide();
			$("#error_less_rpassword").hide();
			$("#error_valid_mpassword").hide();

		}

		if(z==""){
			$("#error_valid_fullname").show();
			flag=false;
		}
		else if(z.length>150)
		{
			$("#error_length_fullname").show();
			flag=false;
		}else{
			$("#error_valid_fullname").hide();
		}

		if(e.length>50){
			$("#error_length_email").show();
			flag=false;
		}else{
			$("#error_length_email").hide();
		}

		if(x==""&&y==""&&z==""&&e==""){
			$("#error_existed_email").hide();
			flag=false;
		}


		if(!term){
			$("#error_valid_term").show();
			flag=false;
		}else{
			$("#error_valid_term").hide();
		}

	    if(pattern.test(e)){
	    	$("#error_valid_email").hide();
	    }else{
	    	$("#error_valid_email").show();
	    	$("#error_existed_email").hide();
	    	flag=false;
		}
	    $("#error_existed_email").hide();
		return flag;
	}
</script>
<h1 align="center"><:$title:></h1>
<form onSubmit="return checkEmail()" name="signupform" action="<:$ctx:>/auth/signup/" method="post">
	<div>
		<:$fullname:><input id="fullname" name="fullname" value="<:$fullname_|escape:'html':>"/>
		<span class="red" id="error_valid_fullname" style="display: none;"><:$fullnameInvalid:></span>
		<span class="red" id="error_length_fullname" style="display: none;"><:$fullnamelength:></span>
	</div>
	<div>
		<:$email:> <input name="email" type="text" class="inputs" id="email_address"size="35" maxlength="255" value="<:$username_|escape:'html':>">
		<span class="red" id="error_valid_email" style="display: none;"><:$emailInvalid:></span>
		<:if $errorMessage eq "":>
  			 &nbsp;
		<:else:>
   			<span class="red" id="error_existed_email"><:$username:> <:$errorMessage:></span>
		<:/if:>
	</div>
	<div>
		<span class="red" id="error_length_email" style="display: none;"><:$emaillength:></span>
	</div>
	<div>
		<:$password:><input id="password" type="password" name="password" />
		<span class="red" id="error_valid_password" style="display: none;"><:$passwordInvalid:></span>

	</div>
	<div>
		<span class="red" id="error_less_password" style="display: none;"><:$passwordless:></span>
	</div>
	<div>
		<:$rpassword:><input id="rpassword" type="password" name="rpassword" />
		<span class="red" id="error_valid_rpassword" style="display: none;"><:$retypepasswordInvalid:></span>
	</div>
	<div>
		<span class="red" id="error_valid_mpassword" style="display: none;"><:$mathpasswordInvalid:></span>
	</div>
	<div>
		<span class="red" id="error_less_rpassword" style="display: none;"><:$repasswordless:></span>
	</div>
	<div>
		<input id="agree" type="checkbox" name="agree"/> <:$understand:><a href="<:$ctx:>/content/term-and-condition" class="facebox-iframe"><:$term:></a>

	</div>
	<div>
	<span class="red" id="error_valid_term" style="display: none;"><:$termInvalid:></span><br/>
		<input type="submit" value="Sign Up"  />
	</div>
</form>