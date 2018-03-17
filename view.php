<?php
require_once 'user.php';
if (isset($_SESSION['lg_id']) && !empty($_SESSION['lg_id'])	) {
	# code...
	$user1 = new user($_SESSION['lg_id']);
} else {
	echo "<script>window.open('login.php','_self')</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>View</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
        <style>
                .card-body div{
                        padding:5px;
                
                        }
        </style>
</head>
<body>
<?php
	if (isset($_GET['p']) && !empty($_GET['p'])) {
	     $p = $_GET['p'];
	     $_SESSION['p'] = $p;
	     if ($user1->parentAccess($p)) {
	     	if (isset($_GET['batch']) && !empty($_GET['batch'])) {
	     		$batch = $_GET['batch'];
	     		 $_SESSION['batch'] = $batch;
	     		$data = $user1->getDetails_p_batch($p,$batch);
	     		if (!is_array($data)  || empty($data)) {
		    		echo "<script>alert('No Data is Available')</script>";
			     	/*echo "<script>window.open('index.php','_self')</script>";*/
		    	}
	     	} else {
	     		echo "<script>alert('Please Select the Batch')</script>";
	     		echo "<script>window.open('index.php','_self')</script>";
	     	}
	     	

	     } else {
	     	echo "<script>alert('Access Denied')</script>";
	     	echo "<script>window.open('index.php','_self')</script>";
	     }
	     

	} else {
		echo "<script>window.open('index.php','_self')</script>";
	}
	
?>
<?php require_once 'navbar.php'; ?>
<br><br>
<div class="container">
	<center>
		<h2>
			<?php echo $user1->getHierarchyName($p);   ?>
		</h2>
		<h3><?php $batch_yr = $user1->getBatchList($batch); echo $batch_yr['start_year']." - ".$batch_yr['end_year'];  ?></h3>
	
	<br><br>
	</center>
	<?php
	require_once 'search-form.php';
	?>
	<br><br>
	
	
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Time</th>
      <th scope="col">Status</th>
      <th scope="col">Updated By</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    	if (is_array($data)  && !empty($data)) {
    		foreach ($data as $key => $value) {
    			$pos = $key +1;
                        
    			echo '<tr>
                      <th scope="row">'.$pos.'</th>
                      <td>'.$value["name"].'</td>
                      <td>'.$value["email"].'</td>
                      <td>'.$value["phone"].'</td>
                      <td>'.$value["start_year"].' - '.$value["end_year"].'</td>
                      <td>';
                      if($value['active']){
                                echo 'active';
                        }
                      echo '</td>';
                      echo '<td>'.$user1->getEmail($value["updated_by"]).'</td></tr>';

    		}
    	} else {
    		//echo "<script>alert('No Data is Available')</script>";
	     	//echo "<script>window.open('index.php','_self')</script>";
    	}
    	


    ?>
    
  </tbody>
</table>
</div>



</body>
</html>