<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<br/><br/>
	<div id="user_video_body" class="page_body">
		<center><h1><:$title:></h1></center><br/>
		<form id="album_password_form" name="album_password_form" action="" method="POST">
			<center>
				<:$input_password_label:><br/><input type="password" id="password" name="password" value=""></input>
				<input type="hidden" id="id" name="id" value="<:$albumId:>"></input>
				<input type="submit" value="Submit"></input><br/>
				<span id="error_message" class="red"><:$errorMessage:></span>
				<span id="info_message" class="green"><:$successMessage:></span>
			</center>
		</form>
	</div>
</div>