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
try{
    if(isset($_REQUEST['term'])){
        // create prepared statement
        if (isset($_SESSION['batch'])) {
            $batch = $_SESSION['batch'];
        } else {
            $batch = NULL;
        }
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
            echo "<p>No matches found Click Here</p>";
        }
    }  
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. ");
}
 
// Close connection
unset($pdo);
?>