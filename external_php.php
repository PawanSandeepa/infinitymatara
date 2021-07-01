<?php 
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  } 
?>
<?php require_once('connection.php'); ?>
<?php

	function check_empty($req_field){
		$error=array();
		foreach ($req_field as $value) {
			if(empty(trim($_POST[$value]))){
				$error[]=$value.' is required';
			}
		}
		//$error[]="test";
		return $error;
	}

	function check_length($max_length){
		$error=array();
		foreach ($max_length as $fild => $lenth) {
			if(strlen(trim($_POST[$fild])) > $lenth){
				$error[]=$fild.' must be less than '.$lenth.' characters';
			}
		}
		return $error;
	}

	function print_error($error,$lenth_error){
		if(!empty($error)){
			//echo "<div class=\"error\">";
			foreach ($error as $display) {
				echo $display."<br>";
			}
			//echo "</div>";
		}
		if(!empty($lenth_error)){
			//echo "<div class=\"lerror\">";
			foreach ($lenth_error as $value) {
				echo $value."<br>";
			}
			//echo "</div>";
		
		}
	}



?>