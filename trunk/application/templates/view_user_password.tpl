<script type="text/javascript">
	function checkpassword(){
		var x = document.getElementById("currentpassword").value;
		var y = document.getElementById("newpassword").value;
		var z = document.getElementById("retypepassword").value
		
		if(x==""){
			alert("Current password not null");
			return false;
		}else if(y==""){
			alert("New password not null");
			return false;
		}else if(z==""){
			alert("Retype password not null");
			return false;
		}else if(y!=z){
			alert("New Password and retype the password must be the same !");
			return false;
		}			
	}
</script>
<div id="user_password" class="user_page">
	{include file="{$base_dir_templates}/blocks/user_left_menu.tpl"}
	
	<div id="user_password_body" class="user_page_body">
		<center><h1>{$title}</h1></center><br/>
			
			{if $FailMessage eq ""}
		  		 &nbsp;
			{else}
		   		<span class="red">{$FailMessage}</span>
			{/if}
			
			{if $successMessage eq ""}
  				 &nbsp;
			{else}
   				<span class="green" align="center">{$successMessage}</span>
			{/if}
			

		<form action="{$ctx}/user/passwordpages/" method="post" onSubmit="return checkpassword(this)">
			<fieldset>
				<ul>
					<li>
						<span>{$currentpassword} </span><br/>						
						<input type="password" name="currentpassword" id="currentpassword"/>
						{if $errorMessage eq ""}
  				 			&nbsp;
						{else}
   							<span class="red">{$errorMessage}</span>
						{/if}	
					</li>					
					<li>
						<span>{$newpassword}</span><br/>
						<input type="password" name="newpassword" id="newpassword"/>
					</li>
					<li>
						<span>{$repassword}</span><br/>
						<input type="password" name="retypepassword" id="retypepassword"/>
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
