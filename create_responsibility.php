<?php
require_once 'user.php';
if (isset($_SESSION['lg_id']) && !empty($_SESSION['lg_id']) ) {
    # code...
    $user1 = new user($_SESSION['lg_id']);
    if (!$user1->hasAdminAccess()) {
    	echo "<script>alert('Access Denied')</script>";
		echo "<script>window.open('".$http_referer."','_self')</script>"; 	
    }
} else {
    echo "<script>window.open('login.php','_self')</script>";
}
if (isset($_POST['submit-create'])) {
	if (isset($_POST['email']) && !empty($_POST['email'])  && isset($_POST['position']) && !empty($_POST['position'])  && isset($_POST['responsibility']) && !empty($_POST['responsibility'])  && isset($_POST['joining_year']) && !empty($_POST['joining_year'])  && isset($_POST['ending_year']) && !empty($_POST['ending_year']) ) {			
		$email = $_POST['email'];
		$position = $_POST['position'];
		$hierarchy_id = $_POST['responsibility'];
		$joining_year = $_POST['joining_year'];
		$ending_year = $_POST['ending_year'];
		$active = 1;
		if ($student_id = $user1->emailExists($email) ) {
			$msg = $user1->updateResponsibility($student_id, $hierarchy_id, $joining_year, $ending_year, $position, $active);
			echo "<script>alert('".$msg."')</script>";
		} else {
			echo "<script>alert('Student Email Doesn\'t Exixt in the Database, First add the Student to the Database')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}
		
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Responsibility</title>
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
			Create Responsibility/ Secretary
		</h3>
	</center>
<div class="row">
		<div class="col-sm-2"></div>
		<div class=" col-md-8 col-sm-10 well">
				<form class="" method="POST" action="">
					<div class="form-group">
						<label class="control-label col-sm-4">Student Email:</label>
						<div class="col-sm-4">
							<input placeholder="Student Email" class="form-control" type="email" name="email" required>	
						</div>		
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-4">Position :</label>
						<div class="col-sm-4">
							<select class="form-control" name="position" required>
								<option selected disabled>Select the Position</option>
								<?php 
									if ($user1->hasAdminAccess()) {
										$output = $user1->getPosition();
										foreach ($output as $key => $value) {
												echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
											}	
									}
								?>
							</select>	
						</div>		
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Responsibility:</label>
						<div class="col-sm-4">
							<select class="form-control" name="responsibility" required>
								<option selected disabled>Select the Responsibility</option>
								<?php 
									if ($user1->hasAdminAccess()) {
										$output = $user1->getAllNodes();
										foreach ($output as $key => $value) {
												echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
											}	
									}
								?>
							</select>	
						</div>		
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Start Year:</label>
						<div class="col-sm-4">
							<input placeholder="Joining Year" class="form-control" type="text" name="joining_year" required>	
						</div>		
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">End Year :</label>
						<div class="col-sm-4">
							<input placeholder="Ending Year" class="form-control" type="text" name="ending_year" required>	
						</div>		
					</div>
					<br>
					<div class="clearfix"></div>
					<div class="text-center ">
						<input type="submit" class="button" name="submit-create" value="Submit">
					</div>

				</form>
	</div>

</div>
<br><br>
	<center>
		<h3>
			Responsibilities
		</h3>
	</center>
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Position</th>
      <th scope="col">Responsibility</th>
      <th scope="col">Time</th>
      <th scope="col">Updated-by</th>
    </tr>
  </thead>
  <tbody>
    <?php
    	$data = $user1->getResponsibilitiesData();
    	if (is_array($data)  && !empty($data)) {
    		foreach ($data as $key => $value) {
    			$pos = $key +1;
                        
    			echo '<tr>
                      <th scope="row">'.$pos.'</th>
                      <td>'.$value["student_name"].'</td>
                      <td>'.$value["student_email"].'</td>
                      <td>'.$value["position_name"].'</td>
                      <td>'.$value["tree_hierarchy_name"].'</td>
                      <td>'.$value["year_start"].' - '.$value["year_end"].'</td>
                      <td>'.$value["updated_by_email"].'</td>';
                     

    		}
    	} else {
    		//echo "<script>alert('No Data is Available')</script>";
	     	//echo "<script>window.open('index.php','_self')</script>";
    	}
    	


    ?>
    
  </tbody>
</table>

</body>
</html>