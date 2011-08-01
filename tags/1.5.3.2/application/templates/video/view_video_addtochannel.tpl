<script type="text/javascript">
	$(document).ready(function() {
		   loadCheckedChannel();
		});

	function checkClick()
	{	
		var str = "";
	    $(':checkbox:checked').each(function(){
	      str += $(this).val();
	      str+=",";
	    });
	    str = str.substring(0, str.length-1);
	    $("#channelId").val(str);	

	    
	    var stru = "";
	    $(':checkbox:').each(function(){
	      stru += $(this).val();
	      stru+=",";
	    });
	    stru = stru.substring(0, stru.length-1);
	    $("#channelUncheck").val(stru);
	}

	function loadCheckedChannel()
	{
		var checkedChannelIds = $("#checkedChannels").val();
		var ids = checkedChannelIds.split(',');
		for(var i=0; i<ids.length; i++){
			$("#channel_"+ids[i]).attr("checked","checked");
		}
	}
</script>
<div id="video_addtochannel" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_addtochannel_body" class="page_body">	
		<h1 align="center"><:$video|escape:'html':> - <:$add:></h1><br/>
		<span class="green" align="center"><:$successMessage:></span>
		<span class="red" align="center"><:$errorMessage:></span>		
		<:if $channel|@count == 0:>
		Cannot find any channel. Please <a href="<:$ctx:>/channel/createnewchannel/">add</a> some.
		<:else:>
		<form action="<:$ctx:>/video/addtochannel/?videoId=<:$videoId:>" method="post" name="addtochannelform">
			<fieldset>
				<ul>
					<li>
						<:section name=a loop=$channel:>
						<input type="checkbox" name="channel" id="channel_<:$channel[a].id:>" value="<:$channel[a].id:>"/>
						<:$channel[a].channel_name:><br/>
						<:/section:>
						<:section name=a loop=$otherChannel:>
						<input type="checkbox" name="channel" id="channel_<:$otherChannel[a].id:>" value="<:$otherChannel[a].id:>"/>
						<:$otherChannel[a].channel_name:><br/>
						<:/section:>
						<input type="hidden" name="videoId" value="<:$videoId:>">
						<input type="hidden" name="channelId" id="channelId" value=""/>
						<input type="hidden" name="channelUncheck" id="channelUncheck" value="" />
						<input type="hidden" id="checkedChannels" value="<:$checkedChannels:>"/>
					</li>
					<li>
						<input type="submit" name="save" value="Save" onClick="checkClick()" />
					</li>
				</ul>
			</fieldset>
		</form>		
		<:/if:>
	</div>
		<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>

