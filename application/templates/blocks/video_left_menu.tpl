<div id="menu">
	<ul class="portrait">
		<li>
			<a href="<:$ctx:>/">
			<:if $userAvatar != null:>
				<img class="userAvatar" src="<:$ctx:>/images/upload/<:$userAvatar:>" width="50" height="50"/>
			<:else:>
				<img class="userAvatar" src="<:$ctx:>/images/avatar.png" width="50" height="50"/>
			<:/if:>
			</a>
            <p>
            <:$smarty.session.fullname|escape:'html':>
            </p>
		</li>
	</ul>
	<:if $authorized == true && $owner == true:>
	<ul>
		<li>
			<a href="<:$ctx:>/video/videosetting/?videoId=<:$videoId:>"><:$videobasicinfo:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/thumbnail/?videoId=<:$videoId:>"><:$videothumbnail:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/updateVideoFile/?videoId=<:$videoId:>"><:$videovideofile:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/preandpostroll/?videoId=<:$videoId:>"><:$videopreandpost:></a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/video/customUrl/?videoId=<:$videoId:>"><:$videocustomurl:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/addtopage/?videoId=<:$videoId:>"><:$videoaddto:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/videodelete/?videoId=<:$videoId:>">Delete</a>
		</li>
		<li>
			<a href="<:$ctx:>/video/addtochannel/?videoId=<:$videoId:>"><:$videoaddtochannel:></a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/user/video/"><:$videobacktovideo:></a>
		</li>
	</ul>
	<:/if:>
	<:if $authorized == false:>
	<ul>
		<li><a href="<:$ctx:>/"><:$messages['left.menu.home']:></a>
	</ul>
	<:/if:>
	<:if $proxy eq true:>
	<ul>
		<li><a href="<:$ctx:>/admin/switchBackToAdmin"><:$messages['left.menu.switchback']:></a>
	</ul>
	<:elseif $smarty.session.admin:>
	<ul>
		<li><a href="<:$ctx:>/admin"><:$messages['left.menu.admin']:></a>
	</ul>
	<:/if:>
	<ul>
	<li>
		<a href="<:$ctx:>/auth/logout"><:$menuLogout:></a>
	</li>
</div>