<?php
include 'baseUploader.php';

echo pathinfo(__FILE__, PATHINFO_DIRNAME); 

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');
$logger->lwrite("userid " . $_SESSION['uid']);

$folder = $_REQUEST['folder'];
$logger->lwrite($folder);
$lastSlash = strripos($folder, '/');
$len = strlen($folder);
$folder = substr($folder, $lastSlash+1, $len - $lastSlash+1);

$logger->lwrite($folder);

$arr = split('\|', $folder);
$uid = $arr[1];
$guid = $arr[0];

$model_user = $uploader->getModel('model_user');
$user = $model_user->getUserByUserId(array($uid));
$hashCode = $uploader->createHash($user['email'], $uploader->loadResources('salt'));

$logger->lwrite('Guid='.$guid);
$logger->lwrite('Hash='.$hashCode);

if($guid == $hashCode){	
	
	$ret = $uploader->upload($uploader->loadResources('video.upload.path'), $uploader->loadResources('video.upload.ext.support'), $uploader->loadResources('video.upload.maxsize'));
	if(!is_numeric($ret)){
		$model_video = $uploader->getModel('model_video');
		$model_video->addNewVideo(array($userId, $filename));
		echo $ret;
	}else{
		echo 'Invalid file';
	}
}else{
	echo $uploader->getLoggedUser();
	echo 'Invalid Session.';
}
?>