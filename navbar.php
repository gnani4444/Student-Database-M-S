<!DOCTYPE html>
<html>
<head>
	<title>Navbar</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

	
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #63a408;">
  <a class="navbar-brand" href="index.php">Gymkhana</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link" href="display.php">Display</a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="changepass.php">Change Password</a>
      </li>
      <?php if ($user1->hasAdminAccess()) { ?>
        <li class="nav-item">
        <a class="nav-link" href="create_responsibility.php">Create Secretary</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="create_login.php">Create Login</a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
    </ul>
    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>-->
    <ul class="pull-right">
        <li class="nav-item">
        <a class="nav-link"><?php echo $user1->getEmailId();  ?> </a>
        </li>
    </ul>
  </div>
</nav>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>
</html>