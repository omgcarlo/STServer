<?php
include_once 'dbs.php';
$dbs = new dbs();

    /**
    *   (c) INCC Group  2015-2016
    *   EARLY TRAPPING!
    */
class Mention{
    private $conn;
    public function __construct(){
        $dbs = new dbs();
        $this->conn = $dbs->connect();
    }
    public function insertMention($userId,$referenceTable,$referenceId,$to_userId){
      $sql = "INSERT INTO `mentions`(`userId`, `referenceTable`, `referenceId`, `to_userId`, `status`)
              VALUES ('$userId','$referenceTable',$referenceId,'$to_userId','A')";
      return mysqli_query($this->conn,$sql);
    }
    public function extractUsers($description){
      $capture = "";
      if(strpos($description,"@") >= 0){
        //	convert string
        $new = str_split($description);
        //	FIND THE @ AND username
        for($i = 0; $i < count($new); $i++){
            // capture @ sign
            if($new[$i] == "@"){
              for(; $i < count($new); $i++){
                  $capture .=  preg_replace("/[^a-zA-Z0-9]+/", "", $new[$i]);
                  if(count($new) - 1 != $i){
                      if(is_null($new[$i+1]) || $new[$i+1] == " " || $new[$i+1] == "," || $new[$i+1] == "@"){
                        $capture .= ",";
                        break;
                      }
                    }
              }
            }
        }

    }
    $capture .= ",";
      return explode(",",$capture);
    }
}
?>
