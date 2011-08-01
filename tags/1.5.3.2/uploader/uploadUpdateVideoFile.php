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
	$ret = $uploader->upload($uploader->loadResources('video.upload.path'),$uploader->loadResources('video.upload.thumbnails'), $uploader->loadResources('video.upload.ext.support'), $uploader->loadResources('video.upload.maxsize'));
	if(!is_numeric($ret)){
		$model_video->updateVideoFile(array($ret, $vid));
		$logger->lwrite('Update video file of video'.$vid);
		echo $ret;
	}else{		
		//echo 'Invalid file';
		$logger->lwrite('Invalid file');
		echo $_FILES['Filedata']['name'];
	}
}else{
	echo 'Invalid Session.';
}
?>