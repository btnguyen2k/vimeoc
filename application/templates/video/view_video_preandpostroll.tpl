<script type="text/javascript">

	$(document).ready(function() {
	   Checked();
	});


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

	function Checked()
	{
		if($("#getpreroll").val()==1)
			$("#Preroll").attr('checked',true);
		else
			$("#Preroll").attr('checked',false);

		if($("#getpostroll").val()==1)
			$("#Postroll").attr('checked',true);
		else
			$("#Postroll").attr('checked',false);
	}

	
</script>
<div id="video_preandpostroll" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_preandpostroll_body" class="page_body">
		<h1 align="center"><:$video|escape:'html':> - <:$title:></h1><br/>
		<span class="green" align="center"><:$successMessage:></span>
		<form action="<:$ctx:>/video/preandpostroll/?videoId=<:$videoid:>" method="post" name="preandpostrollform">
			<fieldset>
				<ul>
					<li>
						<input type="checkbox" id="Preroll" name="Preroll" value="01"/><:$PreRoll:>
					</li>
					<li>
						<input type="checkbox" id="Postroll" name="Postroll" value="01"/><:$PostRoll:>
					</li>
					<li>
						<input type="hidden" name="videoid" id="videoid" value="<:$videoid:>"/>
						<input type="hidden" name="hpreroll" id="hpreroll" value=""/>
						<input type="hidden" name="hpostroll" id="hpostroll" value=""/>
						<input type="hidden" name="getpreroll" id="getpreroll" value="<:$getpreRoll:>"/>
						<input type="hidden" name="getpostroll" id="getpostroll" value="<:$getpostRoll:>"/>
						<input type="submit" value="Save" onClick="Check_PreandPostRoll()" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
		<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>