<?php  
require_once 'user.php';
if (isset($_SESSION['lg_id']) && !empty($_SESSION['lg_id']) ) {
    # code...
    $user1 = new user($_SESSION['lg_id']);
} else {
    echo "<script>window.open('login.php','_self')</script>";
}

if (isset($_POST['btn-add'])) {
	if (isset($_POST['p']) && !empty($_POST['p']) && isset($_POST['student_id']) && !empty($_POST['student_id']) && isset($_POST['start_year']) && !empty($_POST['start_year']) && isset($_POST['end_year']) && !empty($_POST['end_year']) ) {
		$student_id = $_POST['student_id'];
		$relation = $_POST['p'];
		$start_year = $_POST['start_year'];
		$end_year = $_POST['end_year'];
		if (isset($_POST['active'])) {
			$active = 1;
		} else {
			$active = NULL;
		}
		$msg = $user1->updateStudentRelations($student_id, $relation,$start_year, $end_year, $active);
		echo "<script>alert('".$msg."')</script>";
		echo "<script>window.open('".$http_referer."','_self')</script>";
	}else{
		echo "<script>alert('Please fill all fields')</script>";
		echo "<script>window.open('".$http_referer."','_self')</script>";
	}
	
}else{
	echo "<script>window.open('index.php','_self')</script>";
}

?>