<title>Ongsoft</title>
<script  type="text/javascript">
	function checkEmail(){	
		var x = document.getElementById("password").value;
		var y = document.getElementById("rpassword").value;
		var z = document.getElementById("fullname").value;
		var e = document.getElementById("email_address").value;
		var term=$("#agree").attr("checked");
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		var flag=true;

		if(x.length>8){
			$("#error_length_password").show();
			flag=false;
		}else{
			$("#error_length_password").hide();
		}

		if(y.length>8){
			$("#error_length_rpassword").show();
			flag=false;
		}else{
			$("#error_length_rpassword").hide();
		}

		if(x.length>8||x.length<6){
			$("#error_less_password").show();
			flag=false;
		}else{
			$("#error_less_password").hide();
		}

		if(y.length>8||y.length<6){
			$("#error_less_rpassword").show();
			flag=false;
		}else{
			$("#error_less_rpassword").hide();
		}
		
		if(z.length>150){
			$("#error_length_fullname").show();
			flag=false;
		}else{
			$("#error_length_fullname").hide();
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
		
		if(x==""){
			$("#error_valid_password").show();
			flag=false;
		}else{
			$("#error_valid_password").hide();
		}	 

		if(y==""){
			$("#error_valid_rpassword").show();
			flag=false;
		}else{
			$("#error_valid_rpassword").hide();
		}	 

		if(z==""){
			$("#error_valid_fullname").show();
			flag=false;
		}else{
			$("#error_valid_fullname").hide();
		}	 
			
		if(x!=y){
			$("#error_valid_mpassword").show();
			flag=false;
		}else{
			$("#error_valid_mpassword").hide();
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
	    	flag=false;
		}
		return flag;

		
	}
</script>
<h1 align="center"><:$title:></h1>
<form onSubmit="return checkEmail()" name="signupform" action="<:$ctx:>/auth/signup/" method="post">
	<div>
		<:$fullname:><input id="fullname" name="fullname" />
		<span class="red" id="error_valid_fullname" style="display: none;"><:$fullnameInvalid:></span>
		<span class="red" id="error_length_fullname" style="display: none;"><:$fullnamelength:></span>
	</div>
	<div>
		<:$email:> <input name="email" type="text" class="inputs" id="email_address"size="35" maxlength="255">
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
		<span class="red" id="error_length_password" style="display: none;"><:$passwordlength:></span>
		
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
		<span class="red" id="error_length_rpassword" style="display: none;"><:$repasswordlength:></span>
		<span class="red" id="error_less_rpassword" style="display: none;"><:$repasswordless:></span>
	</div>
	<div>	
		<input id="agree" type="checkbox" name="agree"/> <:$understand:><a href="#"><:$term:></a>
		
	</div>
	<div>
	<span class="red" id="error_valid_term" style="display: none;"><:$termInvalid:></span><br/>
		<input type="submit" value="Sign Up" />
		
	</div>	
</form>	