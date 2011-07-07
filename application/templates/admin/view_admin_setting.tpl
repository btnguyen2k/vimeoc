<script type="text/javascript">
$(document).ready(function() {
	   checked();
	});

 function checked()
 {
	 if($("#valueLogin").val()==1)
	 {
		 $("#login1").attr('checked',true);
	 }
	 else
	 {
		 $("#login").attr('checked',true);
	 }

	 if($("#valueSignup").val()==1)
	 {
		 $("#signup1").attr('checked',true);
	 }
	 else
	 {
		 $("#signup").attr('checked',true);
	 }
	 
 }
</script>
<div id="admin_setting" class="page">
	<:include file="<:$base_dir_templates:>/blocks/admin_left_menu.tpl":>
	<div id="admin_setting_body" class="page_body">
		<center><h1><:$title:></h1></center><br/>
		<form name="Settingform" action="<:$ctx:>/admin/Configuration/" method="post">
			<div>
				<fieldset>
					<ul>
						<li>
							<:$signupTitle:>

							<li>
								<input type="radio" id="signup1" name="signup" value="1"/>Enable
							</li>
							<li>
								<input type="radio" id="signup" name="signup" value="0"/>Disable
							</li>
						</li>
						<li>
							<:$loginTitle:>
							<li>
								<input type="radio" id="login1" name="login" value="1"/>Enable
							</li>
							<li>
								<input type="radio" id="login" name="login" value="0"/>Disable
							</li>
						</li>
						<li>
							<input type="submit" value="Save"/>
						</li>
						<li>
						<input type="hidden" id="valueLogin" name="valueLogin" value="<:$login:>"/>
						<input type="hidden" id="valueSignup" name="valueSignup" value="<:$signup:>"/>
					</ul>
				</fieldset>
			</div>
		</form>
	</div>
</div>
