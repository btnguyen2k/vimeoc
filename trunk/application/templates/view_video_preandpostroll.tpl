<script type="text/javascript">
	
	function Check_PreandPostRoll()
	{
		var pre_roll=$("#Preroll").attr("checked")
		var post_roll=$("#Postroll").attr("checked")
		if(pre_roll)
			$("#hpreroll").val("01");
		else
			$("#hpreroll").val("00");

		
		if(post_roll)
			$("#hpostroll").val("01");
		else
			$("#hpostroll").val("00");
		
	}

</script>
<h1 align="center"><:$video:><:$title:></h1>
<div id="video_preandpostroll" class="video_page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_preandpostroll_body" class="video_page_body">	
		<div>
			<br/>
			<:if $successMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$successMessage:></span>
			<:/if:>
		</div>
		<form action="<:$ctx:>/video/preandpostroll" method="post" name="preandpostrollform">
			<fieldset>
				<ul>
					<div>
						<input type="checkbox" id="Preroll" name="Preroll" value="01"/><:$PreRoll:>
					</div>
					
					<div>
						<input type="checkbox" id="Postroll" name="Postroll" value="01"/><:$PostRoll:>
					</div>
					
					<div>
						<input type="submit" value="Save" onClick="Check_PreandPostRoll()" />
					</div>
					<div> 
						<input type="hidden" name="videoid" id="videoid" value="<:$videoid:>"/>
						<input type="hidden" name="hpreroll" id="hpreroll" value=""/>
						<input type="hidden" name="hpostroll" id="hpostroll" value=""/>
					</div>
				</ul>
			</fieldset>
		</form>
	</div>
</div>