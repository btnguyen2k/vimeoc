<?php
include 'baseUploader.php';

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');

$uid = $_POST['uid'];
$guid = $_POST['guid'];

$model_user = $uploader->getModel('model_user');
$user = $model_user->getUserByUserId(array($uid));
$hashCode = $uploader->createHash($user['email'], $uploader->loadResources('salt'));

if($guid == $hashCode){		
	$ret = $uploader->upload($uploader->loadResources('video.upload.path'), $uploader->loadResources('video.upload.ext.support'), $uploader->loadResources('video.upload.maxsize'));
	if(!is_numeric($ret)){
		$model_video = $uploader->getModel('model_video');
		$model_video->addNewVideo(array($user['id'], $ret));
		$logger->lwrite('Added video to user'.$user['id']);
		echo $ret;
	}else{
		echo 'Invalid file';
	}
}else{
	echo $uploader->getLoggedUser();
	echo 'Invalid Session.';
}
?>