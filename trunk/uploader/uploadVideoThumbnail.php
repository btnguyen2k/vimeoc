<?php
include 'baseUploader.php';

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');

$vid = $_POST['vid'];

$model_video = $uploader->getModel('model_video');
$res = $model_video->getVideoByVideoIdAndUserId(array($uploader->getLoggedUser(), $vid));

$logger->lwrite('Logged user[' . $uploader->getLoggedUser() . '] is uploading a file...');

if($uploader->getLoggedUser() > 0 && $res){	
	$ret = $uploader->upload($uploader->loadResources('image.upload.path'), $uploader->loadResources('image.upload.ext.support'), $uploader->loadResources('image.upload.maxsize'));
	if(!is_numeric($ret)){
		$model_video->updateThumbnailById(array($ret, $vid));
		$target = BASE_DIR . $uploader->loadResources('image.upload.path') . $ret;
		$rimg = new RESIZEIMAGE($target);
		$rimg->resize_limitwh(300, 300, $target);				    
		$rimg->close();
		$logger->lwrite("Update thumbnail for video" . $vid);
		echo $ret;
	}else{
		echo 'Invalid file';
	}
}else{
	echo $uploader->getLoggedUser();
	echo 'Invalid Session.';
}
?>