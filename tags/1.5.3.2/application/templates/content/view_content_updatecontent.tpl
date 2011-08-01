<script type="text/javascript">
$(document).ready(function() {
	   checked();
	});
	function validate()
	{
		var title=$("#title").val();
		var alias=$("#alias").val();
		var body=$("#body").val();
		var keywords=$("#keywords").val();
		
		var flag=true;
		
		if(title==""){
			$("#error_valid_title").show();
			flag=false;
		}else{
			$("#error_valid_title").hide();
		}	 

		if(alias==""){
			$("#error_valid_alias").show();
			flag=false;
		}else{
			$("#error_valid_alias").hide();
		}	 

		if(body==""){
			$("#error_valid_body").show();
			flag=false;
		}else{
			$("#error_valid_body").hide();
		}	 
		
		if(keywords==""){
			$("#error_valid_keyword").show();
			flag=false;
		}else{
			$("#error_valid_keyword").hide();
		}	 		
		return flag;
	}

	function checked()
	{
		if($("#publish_").val()==1)
			$("#publish").attr('checked',true);
		else
			$("#unpublish").attr('checked',true);
	}
</script>

<div id="admin_updatecontent" class="page">
	<:include file="<:$base_dir_templates:>/blocks/admin_left_menu.tpl":>
	<div id="admin_updatecontent_body" class="page_body">
		<h1 align="center"><:$title:></h1>
		<form onSubmit="return validate()" name="contentform" action="<:$ctx:>/content/updatecontent/?id=<:$contentId:>" method="post">
			<div>
			<:if $errorMessage eq "":>
		  		 &nbsp;
			<:else:>
		 		 <span class="red" id="errorMessage"><:$errorMessage:></span>
			<:/if:>
			
			<:if $successfullMessage eq "":>
		  		 &nbsp;
			<:else:>
		 		 <span class="green" id="successfullMessage"><:$successfullMessage:></span>
			<:/if:>
				<fieldset>
					<ul>
						<li>
							<:$name:><input name="title" type="text" value="<:$content['title']:>" class="inputs" id="title"  maxlength="255" />
							<span class="red" id="error_valid_title" style="display: none;"><:$titleInvalid:></span>
						</li>
						<li>
							<:$alias:><input id="alias" name="alias" type="text" value="<:$content['alias']:>"/>
							<span class="red" id="error_valid_alias" style="display: none;"><:$aliasInvalid:></span>
						</li>
						<li>
							<:$body:><textarea name="body" id="body" size="40"  ><:$content['body']:></textarea>
							<span class="red" id="error_valid_body" style="display: none;"><:$bodyInvalid:></span>
						</li>
						<li>
							<:$keyword:><textarea  id="keywords" name="keywords" ><:$content['keywords']:></textarea>
							<span class="red" id="error_valid_keyword" style="display: none;"><:$keywordInvalid:></span>
						</li>
						<li>
							<li>
								<input type="radio" id="publish" name="publish" value="1"/>Publish
							</li>
							<li>
								<input type="radio" id="unpublish" name="publish" value="0"/>Unpublish
							</li>
						</li>
						<li>
							<span><:$categoryLable:></span>
							<select id="category" name="category">
							
								<:if $category == "1":>
									<option value="1" selected="selected">System</option>
									<option value="2">User</option>
								<:else:>
									<option value="1">System</option>
									<option value="2" selected="selected">User</option>
								<:/if:>
							</select>
						</li>
						<li>
							<input type="submit" value= "Save"/>
							<input type="hidden" name="contentId" id="contentId" value="<:$contentId:>"/>
							<input type="hidden" name="publish_" id="publish_" value="<:$publish_:>" />
							<input type="hidden" name="url_alias" id="url_alias" value="<:$content['alias']:>" />
						</li>
					</ul>
				</fieldset>
			</div>
		</form>
	</div>
</div>
