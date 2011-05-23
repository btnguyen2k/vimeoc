<center><h1>{$title}</h1></center>

<div id="user_info" class="user_page">
	{include file="{$base_dir_templates}/blocks/user_left_menu.tpl"}
	
	<div id="user_info_body" class="user_page_body">
		<form>
			<fieldset>
				<ul>
					<li>
						<span>Full name:</span><br/>
						<input type="text" name="fullName"/>
					</li>					
					<li>
						<span>Email:</span><br/>
						<input type="text" name="email"/>
					</li>
					<li>
						<span>Your website</span><br/>
						<input type="text" name="alias"/>
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