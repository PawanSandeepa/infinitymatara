<?PHP 
  if(session_status()== PHP_SESSION_NONE){
	session_start();
  }
?>
<?php 
	if (isset($_SESSION['position'])) {
		$position = $_SESSION['position'];

		if($position == "Admin"){
			$conn = mysqli_connect('localhost','root','','infinitycom');
		}else if($position == "Student"){
			$conn = mysqli_connect('localhost','root','','infinitycom');
		}else{
			$conn = mysqli_connect('localhost','root','','infinitycom');
		}

	}else{
		$conn = mysqli_connect('localhost','root','','infinitycom');
	}

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit();
	}

 ?>