<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
	$dbs = new dbs();
	if (mysqli_connect_errno($conn))
	{
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	class File{
		private $conn;
		public function __construct(){
			 $dbs = new dbs();
	        $this->conn = $dbs->connect();
		}
		public function selectFiles(){
			$sql ="SELECT * FROM file WHERE status = 'A' ORDER BY CreatedDate DESC";
			return $sql;
		}
		public function selectFile($fileId){
			$sql = "SELECT * FROM file WHERE fileId = $fileId ORDER BY CreatedDate DESC";
			return $sql;
		}
		public function insertFile($fileUrl,$ownerId,$type,$description){
			$sql = "INSERT INTO file(fileUrl,ownerId,type,description) VALUES('$fileUrl','$ownerId','$type','$description')";
			return mysqli_query($this->conn,$sql);
		}
		public function deleteFile($fileId){
			$sql = "DELETE FROM file WHERE fileId = $fileId";
			return $sql;
		}
		public function filesDetails(){
			$sql = "SELECT * FROM file JOIN user ON user.schoolId = ownerId WHERE file.status = 'A' ORDER BY CreatedDate DESC";
			return $sql;
		}
		public function fileDetails($fileId){
			$sql = "SELECT * FROM file JOIN user ON user.schoolId = ownerId WHERE file.status = 'A' AND fileId = $fileId ORDER BY CreatedDate DESC";
			return $sql;
		}
		public function getFile($fileId){
			$sql = "SELECT * FROM file where fileId = $fileId";
			return mysqli_query($this->conn,$sql);
		}
		public function getFileId($fileUrl,$ownerId){
			$sql = "SELECT fileId from file where fileUrl = '$fileUrl' and ownerId = '$ownerId'";
			return mysqli_query($this->conn,$sql);
		}
		public function updateFile($fileId,$description){
			$sql = "UPDATE file SET description = '$description' ,status = 'A' WHERE fileId = $fileId";
			return $sql;
		}
	}
?>
