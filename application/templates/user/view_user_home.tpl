<link href="<:$ctx:>/css/user_home.css" rel="stylesheet" type="text/css">
<link href="<:$ctx:>/css/user_video.css" rel="stylesheet" type="text/css">
<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	<div id="user_home_body" class="page_body">
		<h1 align="center"><:$messages['user.home.welcome']:></h1><br/>
		<div id="video_album_count">
			<span><a href="<:$ctx:>/user/video"><:$video_count:></a> <:$messages['user.home.video']:></span><span style="margin: 0 0 0 30px">
				  <a href="<:$ctx:>/user/album"><:$album_count:></a> <:$messages['user.home.album']:></span>
		</div>
		<div id="video_list">
			<div style="float: left; margin: 0 0 0 30px">
				<:$messages['user.home.yourrecent']:> (<a href="<:$ctx:>/user/video"><:$messages['user.home.seeall']:></a>)
				<div>
					<:foreach from=$recent_videos key=k item=v:>
						<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
						<:$v['video_title']|escape:'html':><br/><br/>
					<:/foreach:>
				</div>
			</div>
		</div>
	</div>
</div>