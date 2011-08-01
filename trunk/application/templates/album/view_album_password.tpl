<script type="text/javascript">
$(document).ready(function() {
		checkPasswordNull();
	});
	
	function checkPasswordNull()
	{
		if($("#password").val()!="")
		{
			$("#passwordCheck").attr("checked",true);
			$("#password").removeAttr('disabled');
		}
	}
	
	function checkChange()
	{
		var check=$("#passwordCheck").attr("checked");
		if(!check)
		{
			$("#password").val("");
			$("#password").attr("disabled","disabled");
		}
		else
		{
			$("#password").removeAttr('disabled');
		}
	}
	
	function checkPassword()
	{
		var check=$("#passwordCheck").attr("checked");
		var password=$("#password").val();
		if(!check)
		{
			$("#password").val("");
			$("#success_message").hide();
			$("#invalid_password").hide();
		}
		else if(password=="")
		{
			$("#error_valid_password").hide();
			$("#success_message").hide();
		}
		else
		{
			$("#invalid_password").hide();
		}
	}

</script>
<div id="album_password" class="page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<div id="album_albumpassword_body" class="page_body">
		<center><h1><:$albumName|escape:'html':>-<:$name:></h1></center>
		<:if $successMessage eq "":>
  			&nbsp;
		<:else:>
   			<span class="green" id="success_message" ><:$successMessage:></span>
		<:/if:>	
		<span class="red" id="error_valid_password" style="display: none;"><:$errorMessage:></span>
		<span class="red" id="invalid_password" style="display: none;"><:$passwordInvalid:></span>
		<form action="<:$ctx:>/album/albumPassword/?albumId=<:$albumId:>" method="post" name="albumPassword" onSubmit="return checkPassword(this)">
			<fieldset>
				<ul>
					<li>
						<input type="checkbox" id="passwordCheck" name="passwordCheck" onclick="checkChange()"/>
						<span><:$protected:></span><br/>
					</li>
					<li>
						<input type="text" id="password" name="password" disabled="disabled" value="<:$albumPassword:>" />
					</li>
					<li>
						<input type="submit" value="Save"/>
					</li>
					<li>
						<input type="hidden" id="albumId" name="albumId" value="<:$albumId:>" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>