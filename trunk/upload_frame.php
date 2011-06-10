<?php 
	$url = basename($_SERVER['SCRIPT_FILENAME']);

	//Get file upload progress information.
	if(isset($_GET['progress_key'])) {
		$key = 'upload_'.$_GET['progress_key'];
		$upload = apc_fetch($key);
		if ($upload) {
	        if ($upload['done'])
	            $percent = 100;
	        else if ($upload['total'] == 0)
	            $percent = 0;
	        else
	            $percent = $upload['current'] / $upload['total'] * 100;
	    }
		
		echo $percent;
		die;
	}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	setTimeout('refreshProgressBar()', 200);
});

function refreshProgressBar(){
	$.get("<?php echo $url; ?>?progress_key=<?php echo $_GET['upId']; ?>&randval="+ Math.random(), 
		function(data){
			if(data != ''){
				$('#progress_container').fadeIn(100);	//fade in progress bar	
				$('#progress_bar').width(data +"%");	//set width of progress bar based on the $status value (set at the top of this page)
				$('#progress_completed').html(parseInt(data) +"%");	//display the % completed within the progress bar				
				parent.document.getElementById('upload_frame').style.display = "";
			}

			if(data != 100){
				setTimeout('refreshProgressBar()', 100);
			}
	});
}
</script>
<style>
#progress_container {
	width: 300px; 
	height: 30px; 
	border: 1px solid #CCCCCC; 
	background-color:#EBEBEB;
	display: block; 
	margin:5px 0px -15px 0px;
}

#progress_bar {
	position: relative; 
	height: 30px; 
	background-color: #F3631C; 
	width: 0%; 
	z-index:10; 
}

#progress_completed {
	font-size:16px; 
	z-index:40; 
	line-height:30px; 
	padding-left:4px; 
	color:#FFFFFF;
}
</style>
<body style="margin:0px">
<!--Progress bar divs-->
<div id="progress_container">
	<div id="progress_bar">
  		 <div id="progress_completed"></div>
	</div>
</div>
<!---->
</body>