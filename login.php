<?php 
require_once 'data.php';
if (isset($_POST['btn-logi']) && isset($_POST['customer_email']) && isset($_POST['customer_pass']) && !empty($_POST['customer_email']) && !empty($_POST['customer_pass'])  ) {
      $email = $_POST['customer_email'];
      $pass = md5($_POST['customer_pass']);
      $obj1 =  new data();
      $login_query1 = $obj1->result("SELECT id from login WHERE email = :email",[':email'=>$email]);
      $number = count($login_query1);

      if (is_array($login_query1) && !empty($login_query1) &&  $number ==1 ) {

      $login_query2 = $obj1->result("SELECT id from login WHERE pswd= :pswd AND  email = :email ",[':pswd'=>$pass , ':email'=>$email]);

          if (is_array($login_query2) && !empty($login_query2) &&  count($login_query2)==1) {
              $id = $login_query2[0]['id'];
              $_SESSION['lg_id'] = $id;
              echo "<script>alert('Logged in Successfully');</script>";
              echo "<script>window.open('index.php','_self')</script>";

          }else{
              echo "<script>alert('Password is incorrect');</script>";
          }
          
      }elseif ($number >1) {
          echo "<script>alert('Multiple Account Exists');</script>";
      }else {
        echo "<script>alert('Account Doesnot Exists');</script>";
      }
}

?>
<!DOCTYPE html>
<html >

<head>
  <!-- <meta charset="UTF-8">
  <link rel="shortcut icon" type="image/x-icon" href="https://production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
  <link rel="mask-icon" type="" href="https://production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
  <title>CodePen - Simple Login Form Template</title> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>


  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <style>
      @import url(https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Open+Sans:400,300,600);
* {
  box-sizing: border-box;
}
body {
  font-family: 'open sans', helvetica, arial, sans;
  background: url(http://farm8.staticflickr.com/7064/6858179818_5d652f531c_h.jpg) no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
.log-form {
  width: 40%;
  min-width: 320px;
  max-width: 475px;
  background: #fff;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -o-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.25);
}
@media (max-width: 40em) {
  .log-form {
    width: 95%;
    position: relative;
    margin: 2.5% auto 0 auto;
    left: 0%;
    -webkit-transform: translate(0%, 0%);
    -moz-transform: translate(0%, 0%);
    -o-transform: translate(0%, 0%);
    -ms-transform: translate(0%, 0%);
    transform: translate(0%, 0%);
  }
}
.log-form form {
  display: block;
  width: 100%;
  padding: 2em;
}
.log-form h2 {
  color: #5d5d5d;
  font-family: 'open sans condensed';
  font-size: 1.35em;
  display: block;
  background: #2a2a2a;
  width: 100%;
  text-transform: uppercase;
  padding: .75em 1em .75em 1.5em;
  box-shadow: inset 0px 1px 1px rgba(255, 255, 255, 0.05);
  border: 1px solid #1d1d1d;
  margin: 0;
  font-weight: 200;
}
.log-form input {
  display: block;
  margin: auto auto;
  width: 100%;
  margin-bottom: 2em;
  padding: .5em 0;
  border: none;
  border-bottom: 1px solid #eaeaea;
  padding-bottom: 1.25em;
  color: #757575;
}
.log-form input:focus {
  outline: none;
}
.log-form .btn {
  display: inline-block;
  background: #1fb5bf;
  border: 1px solid #1ba0a9;
  padding: .5em 2em;
  color: white;
  margin-right: .5em;
  box-shadow: inset 0px 1px 0px rgba(255, 255, 255, 0.2);
  width: 100px;
}
.log-form .btn:hover {
  background: #23cad5;
}
.log-form .btn:active {
  background: #1fb5bf;
  box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.1);
}
.log-form .btn:focus {
  outline: none;
}
.log-form .forgot {
  color: #33d3de;
  line-height: .5em;
  position: relative;
  top: 2.5em;
  text-decoration: none;
  font-size: .75em;
  margin: 0;
  padding: 0;
  float: right;
}
.log-form .forgot:hover {
  color: #1ba0a9;
}

    </style>

  <script>
  window.console = window.console || function(t) {};
</script>

  
  
  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>




<style>
/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn,.signupbtn {float:left;width:50%}

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 30%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 35px;
    top: 15px;
    color: #000;
    font-size: 40px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}
</style>

</head>

<body translate="no" >

  <div class="log-form">
  <h2>Login to your account</h2>
  <form action="login.php" method="POST">
    <input type="text" title="" name="customer_email" placeholder="username" />
    <input type="password" title="username" name="customer_pass" placeholder="password" />
    <button type="submit" class="btn" name="btn-logi">Login</button>
    <a onclick="document.getElementById('id01').style.display='block'" rel="nofollow" rel="noreferrer"class="forgot" href="#">Signup</a>
    <a rel="nofollow" rel="noreferrer"class="forgot" href="#">Forgot Username?</a>
  </form>
</div><!--end log form -->


<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
  <form class="modal-content animate" method="POST" action="<?php echo $act_url; ?>" >
    <div class="container">
    <label><b>Name</b></label>
      <input type="text" placeholder="Enter Name" name="name" required>

      <label><b>Phone Number</b></label>
      <input type="text" placeholder="Enter Phone number" name="phone" required>

      <label><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pswd" required>

      <label><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="pswd_again" required>
      <input type="checkbox" checked="checked"> Remember me
      <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" name="btn-signup" class="signupbtn">Sign Up</button>
      </div>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>




  
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  
  
  

</body>
</html>
 