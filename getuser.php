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
	<title></title>
</head>
<body>
<?php 
	if (isset($_GET['q'])) {
		$out = $user1->getChild($_GET['q']);
		if (is_array($out) && !empty($out)) {
			$i = rand(10000,99999);
			echo '<br><br><select class="form-control" name="product_cat" onchange="sho('.$i.' , this.value)" required >
			<option disabled selected>Select </option>';
			foreach ($out as $key => $value) {
				echo "<option value='".$value['id']."'>".$value['name']."</option>";
			}
			echo "</select><div id='".$i."' ></div>";
			
		}elseif($user1->getChildNullFlag($_GET['q'])) {
			$out2 = $user1->getDistinctPassingOutYear();
			echo '<br><br><select name="produ" class="form-control" onchange="showUs2('.$_GET["q"].', this.value)" required >
			<option disabled selected>Select the Passing Out Year </option>';
			foreach ($out2 as $key => $value) {
				echo "<option value='".$value['end_year']."'>".$value['end_year']."</option>";
			}
			echo "</select>";

			$out2 = $user1->getBatchList();
			echo 'or <select name="produ" class="form-control" onchange="showUs('.$_GET["q"].', this.value)" required >
			<option disabled selected>Select the Batch </option>';
			foreach ($out2 as $key => $value) {
				echo "<option value='".$value['id']."'>".$value['start_year']."-".$value['end_year'].' '.$value['batch_name']."</option>";
			}
			echo "</select>";
                        
                        $out2 = $user1->getDistinctInstiJoiningYear();
			echo 'or <select name="produ" class="form-control" onchange="showUs3('.$_GET["q"].', this.value)" required >
			<option disabled selected>Select Institute Join Year</option>';
			foreach ($out2 as $key => $value) {
				echo "<option value='".$value['start_year']."'>".$value['start_year']."</option>";
			}
			echo "</select>";
		}
		
	} else {
		echo "<script>window.open('login.php','_self')</script>";	
	}
?>
</body>
</html>