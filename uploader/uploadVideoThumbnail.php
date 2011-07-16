<?php
include 'baseUploader.php';

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');
$logger->lwrite("userid " . $_SESSION['uid']);

if($uploader->getLoggedUser() > 0){
	$logger->lwrite('Functional');
	
	$ret = $uploader->upload($uploader->loadResources('image.upload.path'), $uploader->loadResources('image.upload.ext.support'), $uploader->loadResources('image.upload.maxsize'));
	if(!is_numeric($ret)){
		$model_video = $uploader->getModel('model_video');
		$model_video->updateThumbnailById(array($filename, $userId));
		echo $ret;
	}else{
		echo 'Invalid file';
	}
}else{
	echo $uploader->getLoggedUser();
	echo 'Invalid Session.';
}
?>