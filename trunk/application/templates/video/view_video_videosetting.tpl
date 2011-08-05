<script type="text/javascript">
	function checkvalidate()
	{
		var title= document.getElementById("title").value;

		var flag=true;

		if(title==""){
			$("#error_valid_title").show();
			flag=false;
		}else{
			$("#error_valid_title").hide();
		}	
			
		return flag;
	}
</script>

<div id="video_videosetting" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_videosetting_body" class="page_body">
		<center><h1><:$title_|escape:'html':> - <:$title:></h1></center>
			<:if $errorMessage eq "":>
		  		 &nbsp;
			<:else:>
		   		<span class="red"><:$errorMessage:></span>
			<:/if:>
			
			<:if $successMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$successMessage:></span>
			<:/if:>
		
		<form action="<:$ctx:>/video/videosetting/?videoId=<:$hiddenvideo:>" method="post" onSubmit="return checkvalidate()" name="videosettingform">
			<fieldset>
				<ul>
					<li>
						<span><:$name:> <:$title_|escape:'html':></span><br/>						
						<input type="text" name="title" id="title" value="<:$title_:>"/>
						<span class="red" id="error_valid_title" style="display: none;"><:$titleiInvalid:></span>
					</li>					
					<li>
						<span><:$description:></span><br/>
						<textarea type="text" name="description" id="description" ><:$description_:></textarea>
					</li>
					<li>
						<span><:$tag:></span><br/>
						<input type="text" name="tag" id="tag" size=40 value="<:$tag_:>"/>
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
					<li>
						<input type="hidden" name="tcid" value="<:$tcid:>" />
						<input type="hidden" name="videoid" value="<:$hiddenvideo:>"/>
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>