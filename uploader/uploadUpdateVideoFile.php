<?php
include 'baseUploader.php';

$uploader = new Uploader();

$logger = new Logging();
$logger->lfile('../log/logfile.log');

$vid = $_POST['vid'];
$userId = $uploader->getLoggedUser();
				
$model_video = $uploader->getModel('model_video');
$res = $model_video->getVideoByVideoIdAndUserId(array($uploader->getLoggedUser(), $vid));
$video = $model_video->getVideoByVideoIdAndUserId(array($userId,$vid));
$videoThumbnail=$video['thumbnails_path'];
$logger->lwrite('Logged user[' . $uploader->getLoggedUser() . '] is uploading a file...');

if($uploader->getLoggedUser() > 0 && $res){
	$ret = $uploader->upload($uploader->loadResources('video.upload.path'),$uploader->loadResources('video.upload.thumbnails'), $uploader->loadResources('video.upload.ext.support'), $uploader->loadResources('video.upload.maxsize'));
	$fileExists = $uploader->isFileExists($uploader->loadResources('video.upload.path'), $ret);
	if(!is_numeric($ret) && $fileExists){
		$pathImage=$uploader->loadResources('image.upload.path');
		$folderImage=$pathImage.$videoThumbnail;
		$folderPathImage=BASE_DIR . $folderImage;
		$checkImage=BASE_DIR . $pathImage;
		$logger->lwrite('BASE_DIR'.BASE_DIR);			
		if(file_exists($folderPathImage) && $folderPathImage!=$checkImage){
			unlink($folderPathImage);
		}
		$model_video->updateVideoFile(array($ret, $vid));		
		$model_video->updateThumbnailById(array(NULL, $vid));
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