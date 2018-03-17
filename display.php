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
	<title>Display</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
<?php 
include_once 'navbar.php';
$return  = $user1->getAccessLeaves();
$batch_list = $user1->getBatchList();
foreach ($return as $key => $value) {
	foreach ($batch_list as $key2 => $value2) {
		$data = $user1->getDetails_p_batch($value['id'], $value2['id']);
		if (is_array($data)  && !empty($data)) {

		?>
<div class="container">
	<center>
		<h3>
			<?php echo $user1->getHierarchyName($value['id']);   ?>
		</h3>
		<h4><?php $batch_yr = $user1->getBatchList($value2['id']); echo $batch_yr['start_year']." - ".$batch_yr['end_year'];  ?></h4>	
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
    	
    	


    ?>
    
  </tbody>
</table>
</div>
<br>
<br>
<?php  
		}
	}
}
?>

</center>
</div>
</body>
</html>