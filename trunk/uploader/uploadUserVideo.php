<?php
include 'baseUploader.php';

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');

$logger->lwrite('Logged user[' . $uploader->getLoggedUser() . '] is uploading a file...');

$model_user = $uploader->getModel('model_user');

if($uploader->getLoggedUser() > 0){		
	$user = $model_user->getUserByUserId(array($uploader->getLoggedUser()));
	$ret = $uploader->upload($uploader->loadResources('video.upload.path'), $uploader->loadResources('video.upload.thumbnails'), $uploader->loadResources('video.upload.ext.support'), $uploader->loadResources('video.upload.maxsize'));
	if(!is_numeric($ret)){
		$model_video = $uploader->getModel('model_video');
		$videoId = $model_video->addNewVideo(array($user['id'], $ret));
		$logger->lwrite('Added video['. $videoId .'] to user'.$user['id']);
		echo $videoId;
	}else{
		echo 'invalid-file.error';
	}
}else{
	echo $uploader->getLoggedUser();
	echo 'Invalid Session.';
}
?>