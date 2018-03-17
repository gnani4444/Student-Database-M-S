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
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
        <style>
                .card-body div{
                        padding:5px;
                
                        }

                .button {
				    background-color: #4CAF50; /* Green */
				    border: none;
				    color: white;
				    padding: 10px 20px;
				    text-align: center;
				    text-decoration: none;
				    display: inline-block;
				    font-size: 16px;
				    margin: 4px 2px;
				    -webkit-transition-duration: 0.4s; /* Safari */
				    transition-duration: 0.4s;
				    cursor: pointer;
				}
				.button2 {
				    background-color: white; 
				    color: black; 
				    border: 2px solid #008CBA;
				}

				.button2:hover {
				    background-color: #008CBA;
				    color: white;
				}
        </style>
        <script type="text/javascript">
        	function displaycall(p, batch) {
        		$('#txtx').load("view_copy.php?p="+p+"&batch="+batch);
        	}
        </script>
</head>
<body>
<?php
	if (isset($_GET['p']) && !empty($_GET['p'])) {
	     $p = $_GET['p'];
	     $_SESSION['p'] = $p;
	     if ($user1->parentAccess($p)) {
	     	if (isset($_GET['year']) && !empty($_GET['year'])) {
	     		$year = $_GET['year'];
	     		 $_SESSION['year'] = $year;
	     		 $available_year = $user1->getDistinctInstiJoiningYear($year);
	     		//$data = $user1->getDetails_p_batch($p,$batch);
	     		if (!is_array($available_year)  || empty($available_year)) {
		    		echo "<script>alert('No Batch has been is Available')</script>";
			     	/*echo "<script>window.open('index.php','_self')</script>";*/
		    	}
	     	} else {
	     		echo "<script>alert('Please Select the Year')</script>";
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
		<h3><?php $batch_yr = @$user1->getDistinctInstiJoiningYear($year)[0]; echo " Institute Joining Year: ".$batch_yr['start_year'];  ?></h3>
		<?php  
		if (is_array($available_year)  || !empty($available_year)) {
			foreach ($available_year as $value) {
				echo '<button class="button button2" onclick="displaycall('.$_GET["p"].', '.$value["id"].' )"> '.$value['batch_name'].'<br>'.$value['start_year'].' - '.$value['end_year'].'</button>';
			} 
		} ?>
	<br><br>
	</center>
	<div id="txtx"></div>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</body>
</html>