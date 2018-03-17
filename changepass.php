<?php
require_once 'user.php';
if (isset($_SESSION['lg_id']) && !empty($_SESSION['lg_id']) ) {
    # code...
    $user1 = new user($_SESSION['lg_id']);
} else {
    echo "<script>window.open('login.php','_self')</script>";
}
if (isset($_SESSION['lg_id']) && !empty($_SESSION['lg_id']) ) {
	if (isset($_POST['submit-pass']) && !empty($_POST['old_pass'])  && !empty($_POST['new_pass_1'])  && !empty($_POST['new_pass_2']) ) {			
		
		$old_pass = md5($_POST['old_pass']);
		$new_pass_1 = md5($_POST['new_pass_1']);
		$new_pass_2 = md5($_POST['new_pass_2']);
		if ($new_pass_1  == $new_pass_2) {
			$msg = $user1->updatePassword($old_pass, $new_pass_1);
			echo "<script>alert('".$msg."')</script>";
		}else{
			
			echo "<script>alert('Passwords didn\'t match')</script>";
			//echo "<script>window.open('".$http_referer."','_self')</script>";
		}
	}
}else {
	echo "<script>window.open('login.php','_self')</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"> -->
	<style type="text/css">
		.form-group {
			padding: 5px;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
	<?php 
		require_once 'navbar.php';
	?>
	<br><br>
	<center>
		<h3>
			Change Password
		</h3>
	</center>
<div class="row">
		<div class="col-sm-2"></div>
		<div class=" col-md-8 col-sm-10 well">
				<form class="" method="POST" action="changepass.php" enctype="multipart/form-data">
					<div class="form-group">
						<label class="control-label col-sm-4">Old Password: :</label>
						<div class="col-sm-4">
							<input placeholder="Old Password" class="form-control" type="password" name="old_pass" required>	
						</div>		
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<label class="control-label col-sm-4">New Password :</label>
						<div class="col-sm-4">
							<input placeholder="New Password" class="form-control" type="password" name="new_pass_1" required>	
						</div>		
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<label class="control-label col-sm-4">Again Password :</label>
						<div class="col-sm-4">
							<input placeholder="New Password Again" type="password" class="form-control" name="new_pass_2" required>
						</div>
					</div>
					<br>
					<div class="clearfix"></div>
					<div class="text-center ">
						<input type="submit" class="button" name="submit-pass" value="Submit">
					</div>

				</form>
	</div>

</div>

</body>
</html>