<script type="text/javascript">
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


</script>
<div id="admin_createcontent" class="page">
	<:include file="<:$base_dir_templates:>/blocks/admin_left_menu.tpl":>
	<div id="admin_createcontent_body" class="page_body">
		<h1 align="center"><:$title:></h1>
<form onSubmit="return validate()" name="contentform" action="<:$ctx:>/admin/createnewcontent/" method="post">
	<div>
	<:if $errorMessage eq "":>
  		 &nbsp;
	<:else:>
 		 <span class="red"><:$errorMessage:></span>
	<:/if:>
	
	<:if $messageSuccessful eq "":>
  		 &nbsp;
	<:else:>
 		 <span class="red"><:$messageSuccessful:></span>
	<:/if:>
		<fieldset>
			<ul>
				<li>
					<:$name:><input name="title" type="text" value="" class="inputs" id="title"  maxlength="255" />
					<span class="red" id="error_valid_title" style="display: none;"><:$titleInvalid:></span>
				</li>
				<li>
					<:$alias:><input id="alias" name="alias" type="text"s/>
					<span class="red" id="error_valid_alias" style="display: none;"><:$aliasInvalid:></span>
				</li>
				<li>
					<:$body:><textarea name="body" id="body" size="40"></textarea>
					<span class="red" id="error_valid_body" style="display: none;"><:$bodyInvalid:></span>
				</li>
				<li>
					<:$keyword:><textarea  id="keywords" name="keywords" ></textarea>
					<span class="red" id="error_valid_keyword" style="display: none;"><:$keywordInvalid:></span>
				</li>
				<li>
					<li>
						<input type="radio" id="publish" name="publish" value="1" checked="checked"/>Publish
					</li>
					<li>
						<input type="radio" id="unpublish" name="publish" value="0"/>Unpublish
					</li>
				</li>			
				<li>
					<input type="submit" value= "Save"/>
				</li>
			</ul>
		</fieldset>
	</div>
</form>
