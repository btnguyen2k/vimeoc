<?php
	$id = $_POST['PHPSESSID'];
	session_id($id);

	session_start();
	
	date_default_timezone_set('UTC');
	
	$configs = parse_ini_file('../application/configs/resources.ini');
	
	//Define our site URL
	define("BASE_PATH", $configs['domain']);
	
	//Define our basepath
	define("CONTEXT", $configs['context']);
	
	define("APP_DIR", '../application');
	define("BASE_DIR", '../');
	
	include_once '../application/utils.php';
	include_once '../application/logging.php';
	include_once '../application/base.php';		
	
	/**
	 * 
	 * Uploader class handles the file uploading
	 * @author Tri
	 *
	 */
	class Uploader extends Application{
		var $resources;
		var $log;
		
		function __construct(){
			$this->log = new Logging();
			$this->log->lfile('../log/logfile.log');		
		}
		
		function upload($folderTarget, $folderThumbnails, $fileTypes=null, $maxSize=5){
			$this->log->lwrite($folderTarget);
			$this->log->lwrite($fileTypes);
			$this->log->lwrite($maxSize);
			if (!empty($_FILES)) {
				$tempFile = $_FILES['Filedata']['tmp_name'];				
				$fileType = utils::getFileType($_FILES['Filedata']['name']);
				$targetPath = $_SERVER['DOCUMENT_ROOT'] . $this->loadResources('context') . $folderTarget;
				do{
					$folderName = utils::genRandomString(64);
					$fileName = $folderName . '.' . $fileType[1];
				}while(file_exists($folderTarget . $fileName));
				if($folderThumbnails!=null)
					mkdir(BASE_DIR.$folderThumbnails.$folderName, 0700);
				$targetFile =  str_replace('//','/',$targetPath) . $fileName;
				$sizeLimit = $maxSize*1024*1024;
				$fileSize = $_FILES['Filedata']['size'];
				
				$this->log->lwrite('Request upload file: ' . $fileType[0] . ' - size: ' . $fileSize);
				
				if($fileSize > $sizeLimit){
					$this->log->lwrite("File size " . $fileSize . " is greater than maximum size " . $sizeLimit);
					return -1;
				}
				
				if(!empty($fileTypes)){
					$fileTypes  = str_replace('*.','',$fileTypes);
					$fileTypes  = str_replace(';','|',$fileTypes);
					$typesArray = split('\|',$fileTypes);
					
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
			}else{
				$this->log->lwrite('Request upload empty file.');
				return -1;
			}
		}
	}
?>