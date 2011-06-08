<script type="text/javascript">
	function checkpassword(){
		var cpass = document.getElementById("currentpassword").value;
		var npass = document.getElementById("newpassword").value;
		var rpass = document.getElementById("retypepassword").value
		var flag=true;

		if(cpass==""){
			$("#error_valid_cpassword").show();
			$("#error_password_wrong").hide();			
			flag=false;
		}else{
			$("#error_valid_cpassword").hide();
		}

		if(npass==""){
			$("#error_valid_npassword").show();
			flag=false;
		}else{
			$("#error_valid_npassword").hide();
		}
		
		if(rpass==""){
			$("#error_valid_rpassword").show();
			flag=false;
		}else{
			$("#error_valid_rpassword").hide();
		}

		if(npass!=rpass){
			$("#error_valid_mpassword").show();
			flag=false;
		}else{
			$("#error_valid_mpassword").hide();
		}

		
		return flag;			
	}
</script>
<div id="user_password" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	
	<div id="user_password_body" class="user_page_body">
		<center><h1><:$title:></h1></center><br/>
			
			<:if $FailMessage eq "":>
		  		 &nbsp;
			<:else:>
		   		<span class="red"><:$FailMessage:></span>
			<:/if:>
			
			<:if $successMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$successMessage:></span>
			<:/if:>
			

		<form action="<:$ctx:>/user/passwordpages/" method="post" onSubmit="return checkpassword(this)">
			<fieldset>
				<ul>
					<li>
						<span><:$currentpassword:> </span><br/>						
						<input type="password" name="currentpassword" id="currentpassword"/>
						<span class="red" id="error_valid_cpassword" style="display: none;"><:$cpassword:></span>
						<:if $errorMessage eq "":>
  				 			&nbsp;
						<:else:>
   							<span class="red" id="error_password_wrong"><:$errorMessage:></span>
						<:/if:>	
					</li>					
					<li>
						<span><:$newpassword:></span><br/>
						<input type="password" name="newpassword" id="newpassword"/>
						<span class="red" id="error_valid_npassword" style="display: none;"><:$cpassword:></span>
					</li>
					<li>
						<span><:$repassword:></span><br/>
						<input type="password" name="retypepassword" id="retypepassword"/>
						<span class="red" id="error_valid_rpassword" style="display: none;"><:$cpassword:></span><br/>
						<span class="red" id="error_valid_mpassword" style="display: none;"><:$mpassword:></span>
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
				</ul>
			</fieldset>
		</form>
	
	</div>
	<div id="user_info_help" class="user_page_help">
			Help?
	</div>
</div>
