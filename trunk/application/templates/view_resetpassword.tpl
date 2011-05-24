<title>Reset Password</title>
<h1 align="center">{$title}</h1>
<form " name="resetpasswordform" action="{$ctx}/auth/resetpassword/" method="post">
	<div>
		{$password}<input id="password" type="password" name='password'/>
		<input type="hidden" name="email" value="{$email}"/>
	</div>
	<div>
		<input id="save" type="submit" value="Save"/>
	</div>
</form>