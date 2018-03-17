<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
require_once 'user.php';
if (isset($_SESSION['lg_id']) && !empty($_SESSION['lg_id']) ) {
    # code...
    $user1 = new user($_SESSION['lg_id']);
} else {
    echo "<script>window.open('login.php','_self')</script>";
}

 
// Attempt search query execution

    if(isset($_REQUEST['t'])){
        // create prepared statement
        $t = $_REQUEST['t'];
        if ($t != "No matches found Click Here" && $t != "Edit Personal Details") {
        $arr = explode(" ", $t);
        $student  = $user1->getStudentDetails( '',end($arr) ) ;



        /*$batch = 1;
        $search_output = $user1->search($_REQUEST['term'], $batch);
        if(is_array($search_output) && !empty($search_output) ){
            $count = 0;
            foreach ($search_output as $key => $value) {
                $count++;
                echo "<p>" . $value['name'] . "  ".$value['email']."</p>";
                if ($count == 6) {
                    break;
                }
            }
        } else{
            echo "<p>No matches found</p>";
        }*/  


?>
<br>
<style>
    .row > div{
            padding-top:5px;
            padding-bottom:5px;
    }
    .row {
            margin-right:10px !important;
            margin-left:10px !important;
    }
</style>
<div class="card text-white bg-info mb-3">
  <div class="card-header">Student Details</div>
  <div class="card-body">
    <div class="row">
        <div class="col-sm-4">
            Name: <?php echo $student['name']; ?>
        </div>
        <div class="col-sm-4">
            Email: <?php echo $student['email']; ?>
        </div>
        <div class="col-sm-4">
            Phone: <?php echo $student['phone']; ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-4">
            Roll No: <?php echo $student['roll_no']; ?>
        </div>
        <div class="col-sm-4">
            Batch: <?php 
                $value = $user1->getBatchList($student['batch']);
                echo $value['start_year']."-".$value['end_year'].' '.$value['batch_name'];
            ?>
        </div>
        <div class="col-sm-4">
           Presonal Details Updated By: <?php echo $user1->getEmail($student['updated_by']); ?>
        </div>
    </div>
    <br>
    <div class="result2 text-center"><p><button>Edit Personal Details</button></p></div>
<form action="insert_student.php" method="POST">
    <div class="row">
        
        
        <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>" readonly>
        <div class="col-md-4">
            <?php if (isset($_SESSION['p'])) {
                  echo '<input type="hidden" name="p" value="'.$_SESSION['p'].'" readonly>';
                  echo $user1->getHierarchyName(@$_SESSION['p']);
            } else {
                  $access_leaves = $user1->getAccessLeaves();
                  echo '<div class="input-group">
                          <span class="input-group-btn">
                          <button class="btn btn-success" type="button">Select</button>
                          </span><select name="p" class="form-control" aria-label="Society/Club" required>';
                  foreach ($access_leaves as $key => $value2) {
                          echo '<option  value="'.$value2["id"].'">'.$value2["name"].'</option>';
                  }
                  echo '</select></div>';
                }
              ?>
        </div>
        <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">Start Year</button>
              </span>
              <input type="text" name="start_year" class="form-control" placeholder="Start Year" aria-label="Start Year" required>
            </div>
            <!-- <label>Start Year : </label>
            <input type="text" placeholder="Start year"> -->
        </div>
        <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">End Year</button>
              </span>
              <input type="text" name="end_year" class="form-control" placeholder="End Year" aria-label="End Year" required>
            </div>
            <!-- <label>End Year : </label>
            <input type="text" name="end_year" placeholder="End year"> -->
        </div>
    </div>
    <br>
    <center>
        <input type="checkbox" name="active" value="Active Status"> Active Status
        <!-- <input type="submit" name="add" value="Add to the list"> -->
        <button type="submit" name="btn-add" class="btn btn-success">Add/Update student</button>
    </center>
    
</form>
    <br>
    </div>
</div>

<?php }else{ ?>
 <br>
 <style>
    .row > div{
            padding-top:5px;
            padding-bottom:5px;
    }
    .row {
            margin-right:10px !important;
            margin-left:10px !important;
    }
</style>
<div class="card text-white bg-info mb-3">
  <div class="card-header">Student Details</div>
  <div class="card-body">
<form action="insert_new_student.php" method="POST">
    <div class="row">
        <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">Full Name</button>
              </span>
              <input type="text" name="student_name" class="form-control" placeholder="Full Name" aria-label="Full Name" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">Email Id</button>
              </span>
              <input type="email" name="student_email" class="form-control" placeholder="Institute Email Id" aria-label="Institute Email Id" required>
            </div>
            <!-- <label>Start Year : </label>
            <input type="text" placeholder="Start year"> -->
        </div>
        <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">Roll Number</button>
              </span>
              <input type="text" name="student_roll_no" class="form-control" placeholder="Roll No" aria-label="Roll No" required>
            </div>
            <!-- <label>Start Year : </label>
            <input type="text" placeholder="Start year"> -->
        </div>
        <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">Phone Number</button>
              </span>
              <input type="text" name="student_phone" class="form-control" placeholder="Phone Number" aria-label="Phone Number" required>
            </div>
            <!-- <label>End Year : </label>
            <input type="text" name="end_year" placeholder="End year"> -->
        </div>
        <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">Institute Start Year</button>
              </span>
              <select name="start_year" class="form-control" required>
                  <option selected disabled>Institute Start Year</option>
                  <option>2014</option>
                  <option>2015</option>
                  <option>2016</option>
                  <option>2017</option>
                  <option>2018</option>
              </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">Institute End Year</button>
              </span>
              <select name="end_year" class="form-control" required>
                  <option selected disabled>Select the End Year</option>
                  <option>2017</option>
                  <option>2018</option>
                  <option>2019</option>
                  <option>2020</option>
                  <option>2021</option>
                  <option>2022</option>
              </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" type="button">Batch Name</button>
              </span>
              <select name="batch_name" class="form-control" required>
                  <option selected disabled>Select the Batch Name</option>
                  <option>Btech</option>
                  <option>Btech+Mtech Dual Degree</option>
                  <option>Mtech</option>
                  <option>Msc</option>
                  <option>PhD</option>
                  <option>Repeater</option>
              </select>
            </div>
        </div>
    </div>
    <center>
        
        <br><br>
        <!-- <input type="submit" name="add" value="Add to the list"> -->
        <button type="submit" name="btn-new-add" class="btn btn-success">Add/Update student</button>
    </center>
    
</form>
    <br>
    </div>
</div>

<?php }
}
 ?>