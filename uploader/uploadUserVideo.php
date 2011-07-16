<?php
include 'baseUploader.php';

$uploader = new Uploader();

if($uploader->getLoggedUser() > 0){
	$ret = $uploader->upload($uploader->loadResources('video.upload.path'), $uploader->loadResources('video.upload.ext.support'));
	if(is_numeric($ret)){
		echo $ret;
	}else{
		echo 'Invalid file';
	}
}else{
	echo $uploader->getLoggedUser();
	echo 'Invalid Session.';
}
?>