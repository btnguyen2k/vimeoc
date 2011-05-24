<div id="user_portrait" class="user_page">
	{include file="{$base_dir_templates}/blocks/user_left_menu.tpl"}
	
	<div id="user_portrait_body" class="user_page_body">
		<center><h1>{$title}</h1></center><br/>		
		<form action="{$ctx}/user/portrait/" method="post">
			<fieldset>
				<ul>
					{if $fileName != ''}
					<li>
						<span>{$currentPortrait}</span><br/>
						<img src="images/upload/{$fileName}" width="50" height="50"/>
					</li>
					{/if}
					<li>
						<span>{$uploadNew}</span><br/>
						<input type="file" name="portrait" />
					</li>
					<li>
						<input type="submit" value="Upload" />
					</li>
				</ul>				
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?
	</div>
</div>