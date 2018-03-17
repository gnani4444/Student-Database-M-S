<?php 
require_once 'user.php';
if (isset($_SESSION['lg_id']) && !empty($_SESSION['lg_id'])	) {
	# code...
	$user1 = new user($_SESSION['lg_id']);
} else {
	echo "<script>window.open('login.php','_self')</script>";
}
/*echo $user1->getHierarchyName($user1->getEditAccess());
die();*/
if (isset($_SESSION['p'])) {
    unset($_SESSION['p']);
}
if (isset($_SESSION['batch'])) {
    unset($_SESSION['batch']);
} 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Data</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script>

function showUs(vary , h) {
	window.open('view.php?p='+vary+'&batch='+h , '_self');
}
function showUs2(vary , h) {
    window.open('passing_year.php?p='+vary+'&year='+h , '_self');
}
function showUs3(vary , h) {
    window.open('insti_joining_year.php?p='+vary+'&year='+h , '_self');
}
</script>
</head>
<body>
    <?php 
    require_once 'navbar.php';
    ?>
    <br>
    <br>
<div class="container-fluid"></div>
<div class="container-fluid row">
	<div class="col-md-3">
		<select class="form-control" name="product_cat" onchange="sho('txtHint',this.value)" required >
			<option>Select </option>
			<?php
				echo "<option value='".$user1->getEditAccess()."' >".$user1->getHierarchyName($user1->getEditAccess() )."</option>";
			?>
		</select>
		<div id="txtHint">
			
		</div>
		
	</div>
    <div class="col-md-9">
    <br><br>
        <?php include_once "search-form.php"  ?>
    </div>

</div>
<script type="text/javascript">
/*    function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML += this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}
*/
function sho(vary, str) {
    if (str == "") {
        document.getElementById(vary).innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(vary).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
</body>
</html>