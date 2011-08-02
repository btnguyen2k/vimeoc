<?php
include 'baseUploader.php';

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');

$logger->lwrite('Logged user[' . $uploader->getLoggedUser() . '] is uploading a file...');

if($uploader->getLoggedUser() > 0){
	$ret = $uploader->upload($uploader->loadResources('image.upload.path'), null, $uploader->loadResources('image.upload.ext.support'), $uploader->loadResources('image.upload.maxsize'));
	$fileExists = $uploader->isFileExists($uploader->loadResources('image.upload.path'), $ret);
	$logger->lwrite('Write file result: ' . $fileExists);	
	if(!is_numeric($ret) && ){		
		$model_user = $uploader->getModel('model_user');
		$model_user->updateUserAvatar(array($ret, $uploader->getLoggedUser()));
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
	echo 'Invalid Session.';
}
?>