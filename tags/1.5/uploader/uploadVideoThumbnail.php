<?php
include 'baseUploader.php';

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');

$folder = $_REQUEST['folder'];
$logger->lwrite($folder);
$lastSlash = strripos($folder, '/');
$len = strlen($folder);
$folder = substr($folder, $lastSlash+1, $len - $lastSlash+1);

$logger->lwrite($folder);

$arr = split('\|', $folder);
$vid = $arr[2];
$uid = $arr[1];
$guid = $arr[0];

$model_video = $uploader->getModel('model_video');
$res = $model_video->getVideoByVideoIdAndUserId(array($uid, $vid));

$model_user = $uploader->getModel('model_user');
$user = $model_user->getUserByUserId(array($uid));
$hashCode = $uploader->createHash($user['email'], $uploader->loadResources('salt'));

$logger->lwrite('Guid='.$guid);
$logger->lwrite('Hash='.$hashCode);

if($guid == $hashCode){
	$logger->lwrite('Functional');
	
	$ret = $uploader->upload($uploader->loadResources('image.upload.path'), $uploader->loadResources('image.upload.ext.support'), $uploader->loadResources('image.upload.maxsize'));
	if(!is_numeric($ret)){
		$model_video = $uploader->getModel('model_video');
		$model_video->updateThumbnailById(array($ret, $vid));
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