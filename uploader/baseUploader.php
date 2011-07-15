<?php
	session_start();
	
	date_default_timezone_set('UTC');
	
	$configs = parse_ini_file('../application/configs/resources.ini');
	
	//Define our site URL
	define("BASE_PATH", $configs['domain']);
	
	//Define our basepath
	define("CONTEXT", $configs['context']);
	
	define("APP_DIR", '../application');
	
	include_once '../application/utils.php';
	include_once '../application/logging.php';
	include_once '../application/base.php';		
	
	class Uploader extends Application{
		var $resources;
		var $log;
		
		function __construct(){
			$this->log = new Logging();
			$this->log->lfile('../log/logfile.log');		
		}
		
		function upload($folderTarget, $fileTypes=null){
			if (!empty($_FILES)) {
				$tempFile = $_FILES['Filedata']['tmp_name'];				
				$fileType = utils::getFileType($_FILES['Filedata']['name']);
				$targetPath = $_SERVER['DOCUMENT_ROOT'] . $this->loadResources('context') . $folderTarget;				
				$fileName = utils::genRandomString(64);
				$targetFile =  str_replace('//','/',$targetPath) . $fileName . '.' . $fileType[1];
				$fileTypes = $this->loadResources('video.upload.ext.support');
				if(!empty($fileTypes)){
					$typesArray = split(',',$fileTypes);
					if (in_array($fileType[1], $typesArray)) {
						move_uploaded_file($tempFile,$targetFile);
						$this->log->lwrite("Uploaded file: " . $targetFile);
						return $fileName;
					}else{
						$this->log->lwrite("Uploaded unsupport file type: " . $fileType[1]);
						return -1;
					}
				}else{
					move_uploaded_file($tempFile,$targetFile);
					$this->log->lwrite("Uploaded file: " . $targetFile);
					return $fileName;
				}
				// $fileTypes  = str_replace(';','|',$fileTypes);
				// $typesArray = split('\|',$fileTypes);
				// $fileParts  = pathinfo($_FILES['Filedata']['name']);
				
				// if (in_array($fileParts['extension'],$typesArray)) {
					// Uncomment the following line if you want to make the directory if it doesn't exist
					// mkdir(str_replace('//','/',$targetPath), 0755, true);
					
					// move_uploaded_file($tempFile,$targetFile);
					// echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
				// } else {
				// 	echo 'Invalid file type.';
				// }		
			}else{
				$this->log->lwrite('Request upload empty file.');
				return -1;
			}
		}
	}
?>