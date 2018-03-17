<?php
require_once 'data.php';
spl_autoload_register(function ($class_name) {
    require_once $class_name . '.php';
});

class responsbility extends data
{
	protected $login_id;
	protected $id;
	protected $student_id;
	protected $hierarchy_id;
	protected $start_year;
	protected $end_year;
	protected $position;
	protected $active;
	function __construct($id)
	{
		$this->login_id = $id;
		parent::__construct();

	}
	public function getResponsibilityId()
	{
		# code...
		if (isset($this->id) && !empty($this->id)) {
			# code...
			return $this->id;

		} else {
			$output = $this->result("SELECT responsibility_id from login WHERE id =:id ",[':id'=> $this->login_id ] );
		     $this->id = $output[0]['id'];
		     return $output[0]['id'];
		}
		
		
	}
	public function getHierarchyId()
	{
		# code...
		if (isset($this->hierarchy_id)  && !empty($this->hierarchy_id) ) {
			return $this->hierarchy_id;
		} else {
		     $output = $this->result("SELECT hierarchy_id from responsibility WHERE id =:id ",[':id'=> $this->getResponsibilityId() ] );
		     $this->hierarchy_id = $output[0]['hierarchy_id'];
		     return $output[0]['hierarchy_id'];
		}
		
	}
	public function getActive()
	{
		# code...
		if (isset($this->active) ) {
			return $this->active;
		} else {
		     $output = $this->result("SELECT active from responsibility WHERE id =:id ",[':id'=> $this->getResponsibilityId() ] );
		     $this->active = $output[0]['active'];
		     return $output[0]['active'];
		}
		
	}
	
	public function getAllDetails()
	{
		# code...
		 $output = $this->result("SELECT * from responsibility WHERE id =:id ",[':id'=> $this->getResponsibilityId() ] );
		 if (is_array($output) && !empty($output) ) {
		 	foreach ($output[0] as $key => $value) {
		 		$this->$key = $value;
		 	}   
		 	return $output[0];
		 } else {
		 	return ;
		 }
		 
		 	
	}

}

/*$obj =  new responsbility(1);
$all = $obj->getAllDetails();
print_r($all);
echo $obj->getActive();*/


class user extends responsbility
{	

	protected $id;

	protected $responsibility_id;

	protected $email;

	protected $edit_access;

	protected $admin_access;

	function __construct($id)
	{
		$this->id = $id;

		parent::__construct($id);

	}
	public function getLoginId()
	{
		# code...
		if (isset($this->id) && !empty($this->id)) {
			# code...
			return $this->id;

		} else {

			return; 
		}
		
		
	}
	public function getResponsibilityId()
	{
		# code...
		if (isset($this->responsibility_id)  && !empty($this->responsibility_id) ) {
			return $this->responsibility_id;
		} else {
		     $output = $this->result("SELECT responsibility_id from login WHERE id =:id ",[':id'=> 1 ] );
		     $this->responsibility_id = $output[0]['responsibility_id'];
		     return $output[0]['responsibility_id'];
		}
		
	}
	public function getEmailId($id = NULL)
	{
		# code...
		if ($id == NULL) {
			if (isset($this->email)  && !empty($this->email) ) {
				return $this->email;
			} else {
			     $output = $this->result("SELECT email from login WHERE id =:id ",[':id'=> $this->getLoginId() ] );
			     $this->email = $output[0]['email'];
			     return $output[0]['email'];
			}
		} else {
			$output = $this->result("SELECT email from login WHERE id =:id ",[':id'=> $id]);
			return $output[0]['email'];
		}
		
	}
	public function getEditAccess()
	{
		# code...
		if (isset($this->edit_access)  && !empty($this->edit_access) ) {
			return $this->edit_access;
		} else {
		     $output = $this->result("SELECT edit_access from login WHERE id =:id ",[':id'=> $this->getLoginId() ] );
		     $this->edit_access = $output[0]['edit_access'];
		     return $output[0]['edit_access'];
		}
		
	}
	public function hasAdminAccess()
	{
		if (isset($this->admin_access)) {
			return $this->admin_access;
		} else {
		     $output = $this->result("SELECT admin_access from login WHERE id =:id ",[':id'=> $this->getLoginId() ] );
		     $this->admin_access = $output[0]['admin_access'];
		     return $output[0]['admin_access'];
		}	
	}
	public function getChild($id)
	{
		if ($this->parentAccess($id)) {
			$output = $this->result("SELECT id, name from tree_hierarchy WHERE parent_id =:id ",[':id'=>$id ] );
			return $output;
		} else {
			return "Access Denied";
		}
		
		
	}
	public function getChildNullFlag($id)
	{
		if ($this->parentAccess($id) ) {
			$output = $this->result("SELECT child from tree_hierarchy WHERE id =:id ",[':id'=>$id ]);
			if (  !empty($output[0]['child']) || count($output) != 1 ) {
				return false;
			} else {
				return true;
			}	
		} else {
			return false;
		}
		
	}
	public function getHierarchyName($id)
	{
		$output = $this->result("SELECT name from tree_hierarchy WHERE id =:id ",[':id'=>$id ] );
		return $output[0]['name'];
	}
	public function parentAccess($id)
	{
		while ($id) {
			if($id == $this->getEditAccess() ){
				return true;
			}
			$output = $this->result("SELECT parent_id from tree_hierarchy WHERE id =:id ",[':id'=>$id ] );
			$id = $output[0]['parent_id']; 
		}
		return false;
	}
	/*public function getBatchList()
	{
		$output = $this->result("SELECT id, start_year, end_year from batch",[] );
		return $output;
	}*/
	public function getDetails_p_batch($p, $batch)
	{
		/*$output = $this->result("SELECT * from relation_students LEFT JOIN students ON `relation_students`.`student_id` = `students`.`id` WHERE tree_hierarchy_id =:id AND student_id=(SELECT id from students WHERE batch= :batch) ",[':batch'=>$batch,':id'=>$p  ] );
		return $output;*/
		if ($this->parentAccess($p)) {
			$output = $this->result("SELECT `relation_students`.*, `students`.name, `students`.roll_no, `students`.phone, `students`.email, `students`.batch  from relation_students INNER JOIN students ON `relation_students`.`student_id` = `students`.`id` WHERE `relation_students`.`tree_hierarchy_id` =:id AND `students`.`batch`= :batch ",[':id'=>$p, ':batch'=>$batch  ] );
			return $output;
		} else {
			return ;
		}
		
		
	}
	public function getBatchList($id = NULL)
	{
		if ($id) {
			$output = $this->result("SELECT id, start_year, end_year, batch_name from batch WHERE id=:id",[':id'=>$id] );
			return $output[0];
		} else {
			$output = $this->result("SELECT id, start_year, end_year, batch_name from batch",[] );
			return $output;
		}
		
		
	}
	public function search($term, $batch=NULL)
	{
		$term = '%'.$term.'%';
		if ($batch) {
			$search_output = $this->result("SELECT * FROM students where batch = :batch AND (email LIKE :email OR name LIKE :name )",[':batch'=>$batch,  ':email'=>$term, ':name'=>$term] );
			return $search_output;
		}else{
			$search_output = $this->result("SELECT * FROM students where email LIKE :email OR name LIKE :name ",[':email'=>$term, ':name'=>$term] );
			return $search_output;
		}
	}

	public function getStudentDetails($id=NULL, $email = NULL)
	{
		if ($id) {
			$output = $this->result("SELECT * from students WHERE id =:id ",[':id'=>$id ] );
			return $output[0];
		}else if($email){
			$output = $this->result("SELECT * from students WHERE email =:email ",[':email'=>$email ] );
		return $output[0];
		}
                return ;
	}
	public function studentRelation($id, $relation)
	{
		if ($id && $relation && $this->parentAccess($relation) ) {
			$output = $this->result("SELECT id from relation_students WHERE student_id =:id AND tree_hierarchy_id= :tree_hierarchy_id ",[':id'=>$id , ':tree_hierarchy_id'=>$relation ] );
			return $output[0]['id'];
		}else{
			return ;
		}
	}
	public function updateStudentRelations($student_id, $relation, $start_year, $end_year, $active)
	{
		if ($student_id && $relation && $start_year && $end_year) {
	
		if ($this->studentRelation($student_id,$relation)) {
			$this->result("UPDATE `relation_students` SET `active` =:active, start_year = :start_year, end_year = :end_year, updated_by = :updated_by  WHERE student_id= :student_id AND tree_hierarchy_id =:relation ",[':active'=>$active, ':start_year'=>$start_year, ':end_year'=>$end_year, ':student_id'=>$student_id, ':relation'=>$relation, ':updated_by'=>$this->getLoginId() ]);
			return "Modified the Previous";
		}else if($this->parentAccess($relation)){
			$this->result("INSERT INTO `relation_students` (`id`, `student_id`, `tree_hierarchy_id`, `start_year`, `end_year`, `active`, `updated_by`) VALUES (NULL, :student_id, :relation, :start_year, :end_year, :active, :updated_by)",[':active'=>$active, ':start_year'=>$start_year, ':end_year'=>$end_year, ':student_id'=>$student_id, ':relation'=>$relation, ':updated_by'=>$this->getLoginId() ]);
			return "Inserted Successfully";
		}else{
			return "Access Denied";
		}

		} else {
			return "Please fill all fields";
		}
		
	}
	public function getBatchId($start_year, $end_year, $batch_name)
	{
		if ($start_year && $end_year && $batch_name) {
			$output = $this->result("SELECT id FROM batch where start_year = :start_year AND end_year =:end_year AND batch_name = :batch_name ",[':start_year'=>$start_year, ':end_year'=>$end_year, ':batch_name'=>$batch_name] );
			if (is_array($output) && !empty($output)) {
				return $output[0]['id'];
			} else {
				$output = $this->result("INSERT INTO batch (start_year, end_year, batch_name) VALUES (:start_year, :end_year, :batch_name) ",[':start_year'=>$start_year, ':end_year'=>$end_year, ':batch_name'=>$batch_name]);
				if (is_array($output)) {
					return $this->getLastInsertId();
				} else {
					echo "alert('Error Inserting the Batch')";
					die();
				}	
			}
		} else {
			echo "alert('Batch Name or Start Year or End Year is Missing')";
			die();
		}
			
	}
	public function insertStudent($student_name = NULL, $student_email=NULL , $student_roll_no=NULL, $student_phone=NULL , $start_year, $end_year, $batch_name)
	{
		$student_batch = $this->getBatchId($start_year, $end_year, $batch_name);
	if ($student_name && $student_email && $student_phone && $student_batch && $student_roll_no) {
			if ($this->getStudentDetails('',$student_email)) {
				$out = $this->result("UPDATE students SET name=:student_name, roll_no=:student_roll_no, phone= :student_phone , batch=:student_batch, updated_by=:updated_by WHERE email=:student_email",[':student_name'=>$student_name, ':student_roll_no'=>$student_roll_no, ':student_email'=>$student_email,':student_phone'=>$student_phone,':student_batch'=>$student_batch ,':updated_by'=>$this->getLoginId()] );
				if (is_array($out)) {
					return "updated Successfully";
				}else{
					return "Failed to update the existing Student in the Database Now";
				}
			}else{
				$out  = $this->result("INSERT into students VALUES (NULL, :student_name ,:student_roll_no, :student_email, :student_phone, :student_batch, :updated_by)",[':student_name'=>$student_name, ':student_roll_no'=>$student_roll_no, ':student_email'=>$student_email,':student_phone'=>$student_phone,':student_batch'=>$student_batch ,':updated_by'=>$this->getLoginId()] );
				if (is_array($out)) {
					return "Inserted new Student into Database Now You can search";
				}else{
					return "Failed inserting new Student into Database Now";
				}
			}
	}else{
		return "Failed to insert the Students";
	}
	}
	public function updatePassword($old=NULL, $new=NULL)
	{
		if ($old && $new) {
			$out = $this->result('SELECT email FROM login WHERE id = :id AND pswd = :password',[':id'=>$this->getLoginId(), ':password'=>$old  ]);
			if (is_array($out) && !empty($out)) {
				$out = $this->result("UPDATE login SET pswd =:pswd WHERE id=:id AND pswd= :password ",[ ':pswd'=>$new, ':id'=>$this->getLoginId(), ':password'=>$old  ]);
				if (is_array($out)) {
					return "Password Changed";
				}else{
					return "Error in changing Password";
				}
			}else{
				return "Password Incorrect";
			}
		}
	}

	public function getDistinctPassingOutYear($id = NULL)
	{
		if ($id) {
			$output = $this->result("SELECT id, start_year, end_year, batch_name from batch WHERE end_year=:id",[':id'=>$id] );
			return $output;
		} else {
			$output = $this->result("SELECT id, start_year, end_year, batch_name from batch GROUP BY end_year",[] );
			return $output;
		}
	}
        public function getDistinctInstiJoiningYear($id = NULL)
	{
		if ($id) {
			$output = $this->result("SELECT id, start_year, end_year, batch_name from batch WHERE start_year=:id",[':id'=>$id] );
			return $output;
		} else {
			$output = $this->result("SELECT id, start_year, end_year, batch_name from batch GROUP BY start_year",[] );
			return $output;
		}
	}
	public function getAccessLeaves()
	{
		$access = $this->getEditAccess();
		if ($access) {
			$root = [];
			$root['id'] = $access;
			$root['name'] = $this->getHierarchyName($access);
 			$stack = [$root];
			$return = [];
			

			while($stack){

				$root = array_pop($stack);
				$output = $this->result("SELECT child FROM tree_hierarchy where id =:id",[':id'=>$root['id']]);
				if (  !empty($output[0]['child']) || count($output) != 1 ) {

					$res = $this->result("SELECT id, name FROM tree_hierarchy WHERE parent_id = :root ORDER BY id DESC ",[':root'=>$root['id']]);
					$stack = array_merge($stack, $res);
				} else {
					$return = array_merge($return, [$root]);
				}	
			}
		} else {
			echo "alert('Access Denied')";
			die();
		}
		return $return;
		

	}
    public function getEmail($id){
        if($id){
            $output = $this->result("SELECT email FROM login WHERE id =:id",[':id'=>$id]);
               	if(!empty($output[0]['email'])){
                    return $output['0']['email'];
                }else{
                   	return NULL;
                }
        }
    }
    public function getPosition($id=NULL)
    {
    	if ($id) {
			$output = $this->result("SELECT * from position WHERE id=:id",[':id'=>$id] );
			return $output[0];
		} else {
			$output = $this->result("SELECT * from position",[] );
			return $output;
		}
    }
    public function getAllNodes()
    {
    	$access = $this->getEditAccess();
		if ($access) {
			$root = [];
			$root['id'] = $access;
			$root['name'] = $this->getHierarchyName($access);
 			$stack = [$root];
			$return = [];
			while($stack){
				$root = array_pop($stack);
				$output = $this->result("SELECT child FROM tree_hierarchy where id =:id",[':id'=>$root['id']]);
				if (  !empty($output[0]['child']) || count($output) != 1 ) {

					$res = $this->result("SELECT id, name FROM tree_hierarchy WHERE parent_id = :root ORDER BY id DESC ",[':root'=>$root['id']]);
					$return = array_merge($return, [$root]);
					$stack = array_merge($stack, $res);
				} else {
					$return = array_merge($return, [$root]);
				}	
			}
		} else {
			echo "alert('Access Denied')";
			die();
		}
		return $return;
		
    }
    public function emailExists($email)
    {
    	if ($email) {
    		$output = $this->result("SELECT id from students WHERE email=:email",[':email'=>$email]);
    		if (is_array($output)  && !empty($output[0]['id']) && count($output)==1  ) {
    			return $output[0]['id'];
    		} else {
    			return NULL;
    		}	
    	} else {
    		return NULL;
    	}
    	
    }
    /**
    * Return the responsibilities of the tree and student
	* table: responsiblity
	* 6 parameters
    */ 
	public function getResponsibilities($student_id=NULL, $hierarchy_id=NULL, $position=NULL)
	{
		$output = $this->result("SELECT id FROM responsibility WHERE student_id=:student_id AND hierarchy_id=:hierarchy_id AND position=:position",[':student_id'=>$student_id, ':hierarchy_id'=>$hierarchy_id, ':position'=>$position] );
		if (is_array($output) && !empty($output)) {
			return $output[0]['id'];
		} else {
			return False;
		}
		
	}


    /**
    * Updating the Responsiblity of Students 
	* table: responsiblity
	* 6 parameters
    */
    public function updateResponsibility($student_id, $hierarchy_id, $year_start, $year_end, $position, $active)
    {
    	if ($student_id && $hierarchy_id && $year_start && $year_end && $position) {
    		if ($id = $this->getResponsibilities($student_id, $hierarchy_id, $position) ) {
    			$output = $this->result("UPDATE `responsibility` SET `year_start` = :year_start, `year_end` = :year_end, `active` = :active, `updated_by` = :updated_by WHERE `responsibility`.`id` = :id ", [':id'=>$id, ':year_start'=>$year_start, ':year_end'=>$year_end,  ':active'=>$active, ':updated_by'=>$this->getLoginId()] );
	    		if (is_array($output)) {
	    			return "Updated the Responsiblity Successfully";
	    		} else {
	    			return "Failed to update the responsibility";
	    		}
    		} else {
	    		$output = $this->result("INSERT INTO `responsibility` (`id`, `student_id`, `hierarchy_id`, `year_start`, `year_end`, `position`, `active`, `updated_by`) VALUES (NULL, :student_id, :hierarchy_id, :year_start, :year_end, :position, :active, :updated_by)", [':student_id'=>$student_id, ':hierarchy_id'=>$hierarchy_id, ':year_start'=>$year_start, ':year_end'=>$year_end, ':position'=>$position, ':active'=>$active, ':updated_by'=>$this->getLoginId()] );
	    		if (is_array($output)) {
	    			return "New Responsiblity Created";
	    		} else {
	    			return "Failed to Create the responsibility";
	    		}
    		}
    	}else{
    		return "Please Fill all fields";
    	}
    }
    public function loginExists($responsibility_id, $hierarchy_id)
    {
    	$output = $this->result("SELECT id FROM login WHERE responsibility_id =:responsibility_id AND edit_access = :hierarchy_id",[':responsibility_id'=>$responsibility_id, ':hierarchy_id'=>$hierarchy_id ]);
    	if (is_array($output) && !empty($output)) {
    		return True;
    	} else {
    		return False;
    	}
    	
    }
    public function loginEmailExists($email)
    {
    	if ($email) {
    		$output = $this->result("SELECT id from login WHERE email = :email",[':email'=>$email]);
    		if (is_array($output) && !empty($output)) {
    			return True;
    		} else {
    			return False;
    		}
    		
    	} else {
    		die("Error in Login Email");
    	}
    	
    }
    public function updateLogin($responsibility_id, $login_email, $hierarchy_id)
    {
    	if ($responsibility_id && $login_email && $hierarchy_id) {
    		if ($this->loginExists($responsibility_id, $hierarchy_id)) {
    			return "Login Exists with the given Student, position, Responsiblity";
    		} else {
    			if ($this->loginEmailExists($login_email)) {
    				return "Login Email Already Exists";
    			} else {
		    		$output = $this->result("INSERT INTO login (responsibility_id, email, edit_access, updated_by) VALUES (:responsibility_id, :email, :edit_access, :updated_by)",[':responsibility_id'=>$responsibility_id, ':email'=>$login_email, ':edit_access'=>$hierarchy_id, ':updated_by'=>$this->getLoginId()  ]);
		    		if (is_array($output)) {
		    			return "New Login Created";
		    		} else {
		    			return "Failed to Create Login";
		    		}
	    		}
    		}
    	} else {
    		return "Some Fields are empty";
    	}
    	
    }
    public function getResponsibilitiesData()
    {
    	if ($this->hasAdminAccess()) {
			$output = $this->result("SELECT `responsibility`.`year_start`,`responsibility`.`year_end`, `students`.name as student_name, `students`.email as student_email, `tree_hierarchy`.`name` as tree_hierarchy_name, `position`.`name` as position_name, `login`.`email` as updated_by_email from responsibility INNER JOIN `students` ON `responsibility`.`student_id` = `students`.`id` INNER JOIN `tree_hierarchy` ON `responsibility`.`hierarchy_id` = `tree_hierarchy`.`id` INNER JOIN `login` ON `responsibility`.`updated_by` = `login`.`id` INNER JOIN `position` ON `responsibility`.`position` = `position`.`id` ",[ ] );
			return $output;
		} else {
			echo "<script>alert('Access Denied')</script>";
			die();
		}
    }
    public function getLoginData()
    {
    	if ($this->hasAdminAccess()) {
			$output = $this->result("SELECT `login`.updated_by, `students`.name as student_name, `login`.`email` as login_email, `tree_hierarchy`.`name` as tree_hierarchy_name , `students`.`email` as student_email FROM `login` INNER JOIN `responsibility` ON `login`.`responsibility_id` = `responsibility`.`id` INNER JOIN students ON `responsibility`.`student_id` = `students`.`id` INNER JOIN `tree_hierarchy` ON `login`.`edit_access` = `tree_hierarchy`.`id` ",[ ] );
			return $output;
		} else {
			echo "<script>alert('Access Denied')</script>";
			die();
		}
    }

}

/*$new = new user(1);
print_r($new->getResponsibilitiesData());*/

class student
{
	protected $id;
	protected $name;
	protected $email;
	protected $phone;
	protected $batch;
	function __construct($id)
	{
		$this->id = $id;
	}
	public function getStudentDetails(array $details = [] )
	{
		$student_details = ['78','name','vg15@iitbbs.ac.in'];
		return $student_details;

	}
	public function getBatchDetails($id)
	{
		$batchDetails =['id'=>1, 'start_year'=>2015, 'end_year'=>2019];
		return $batchDetails;
	}

}

/**
*
*/




?>