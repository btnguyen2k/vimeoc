<script type="text/javascript">
	function checkvalidate()
	{
		var title= document.getElementById("title").value;
		var description= document.getElementById("description").value;
		var tag= document.getElementById("tag").value;
		var flag=true;

		if(title==""){
			$("#error_valid_title").show();
			flag=false;
		}else{
			$("#error_valid_title").hide();
		}	

		if(description==""){
			$("#error_valid_description").show();
			flag=false;
		}else{
			$("#error_valid_description").hide();
		}	

		if(tag==""){
			$("#error_valid_tag").show();
			flag=false;
		}else{
			$("#error_valid_tag").hide();
		}	
			
		return flag;
	}
</script>

<div id="video_videosetting" class="video_page">
	{include file="{$base_dir_templates}/blocks/video_left_menu.tpl"}
	
	<div id="video_videosetting_body" class="video_page_body">
		<center><h1>{$name}</h1></center><br/>
		
		<form action="{$ctx}/video/videosetting" method="post" onSubmit="return checkvalidate()" name="videosettingform">
			<fieldset>
				<ul>
					<li>
						<span>{$title} </span><br/>						
						<input type="text" name="title" id="title"/>
						<span class="red" id="error_valid_title" style="display: none;">{$titleiInvalid}</span>
					</li>					
					<li>
						<span>{$description}</span><br/>
						<textarea type="text" name="description" id="description"></textarea>
						<span class="red" id="error_valid_description" style="display: none;">{$descriptionInvalid}</span>
					</li>
					<li>
						<span>{$tag}</span><br/>
						<input type="text" name="tag" id="tag"/>
						<span class="red" id="error_valid_tag" style="display: none;">{$tagInvalid}</span>
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
</div>