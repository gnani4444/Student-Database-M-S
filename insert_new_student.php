<?php  
require_once 'user.php';
if (isset($_SESSION['lg_id']) && !empty($_SESSION['lg_id']) ) {
    # code...
    $user1 = new user($_SESSION['lg_id']);
} else {
    echo "<script>window.open('login.php','_self')</script>";
}

if (isset($_POST['btn-new-add'])) {
	if (isset($_POST['student_name']) && !empty($_POST['student_name']) && isset($_POST['student_email']) && !empty($_POST['student_email']) && isset($_POST['student_phone']) && !empty($_POST['student_phone']) && isset($_POST['start_year']) && !empty($_POST['start_year']) && isset($_POST['end_year']) && !empty($_POST['end_year']) && isset($_POST['batch_name']) && !empty($_POST['batch_name']) && isset($_POST['student_roll_no']) && !empty($_POST['student_roll_no']) ) {
		$student_name = $_POST['student_name'];
		$student_email = $_POST['student_email'];
		$student_roll_no = $_POST['student_roll_no'];
		$student_phone = $_POST['student_phone'];
		$start_year = $_POST['start_year'];
		$end_year = $_POST['end_year'];
		$batch_name = $_POST['batch_name'];
		$msg = $user1->insertStudent($student_name, $student_email,$student_roll_no, $student_phone, $start_year, $end_year, $batch_name);
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