<?php
include 'baseUploader.php';

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');

$session_name = session_name();
$sid = $_POST[$session_name];
$logger->lwrite("PHPSESSID: " . $sid);
session_regenerate_id();
$suid = $_SESSION['uid'];
$logger->lwrite("suid: " . $suid);



$uid = $_POST['uid'];
$guid = $_POST['guid'];

$model_user = $uploader->getModel('model_user');
$user = $model_user->getUserByUserId(array($uid));
$hashCode = $uploader->createHash($user['email'], $uploader->loadResources('salt'));

if($guid == $hashCode){
	$ret = $uploader->upload($uploader->loadResources('image.upload.path'), $uploader->loadResources('image.upload.ext.support'), $uploader->loadResources('image.upload.maxsize'));
	if(!is_numeric($ret)){
		$model_user = $uploader->getModel('model_user');
		$model_user->updateUserAvatar(array($ret, $uid));
		$target = BASE_DIR . $uploader->loadResources('image.upload.path') . $ret;
		$rimg = new RESIZEIMAGE($target);
		$rimg->resize_limitwh(300, 300, $target);				    
		$rimg->close();
		$logger->lwrite("Update thumbnail for user" . $uid);
		echo $ret;
	}else{
		echo 'Invalid file';
	}
}else{
	echo $uploader->getLoggedUser();
	echo 'Invalid Session.';
}
?>