<?php
//require_once '../application/base.php';
include 'baseUploader.php';

// Logging class initialization
//$log = new Logging();
// set path and name of log file (optional)
//$log->lfile('../log/logfile.log');

$uploader = new Uploader();

if($uploader->getLoggedUser() > 0){
	$ret = $uploader->upload($uploader->loadResources('video.upload.path'), $uploader->loadResources('video.upload.ext.support'));
	if(is_numeric($ret)){
		echo $ret;
	}else{
		echo 'Invalid file';
	}
}else{
	echo $uploader->getLoggedUser();
	echo 'Invalid Session.';
}



//if (!empty($_FILES)) {
//	$tempFile = $_FILES['Filedata']['tmp_name'];
//	$fileType = utils::getFileType($tempFile);
//	$targetPath = BASE_DIR . $this->loadResources('video.upload.path');				
//	
//	$targetFile =  str_replace('//','/',$targetPath) . utils::genRandomString(64) . $fileType;
//	
//	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
//	// $fileTypes  = str_replace(';','|',$fileTypes);
//	// $typesArray = split('\|',$fileTypes);
//	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
//	
//	// if (in_array($fileParts['extension'],$typesArray)) {
//		// Uncomment the following line if you want to make the directory if it doesn't exist
//		// mkdir(str_replace('//','/',$targetPath), 0755, true);
//		
//		move_uploaded_file($tempFile,$targetFile);
//		echo str_replace($targetPath,'',$targetFile);
//	// } else {
//	// 	echo 'Invalid file type.';
//	// }		
//}
?>