<?php
ob_start();
session_start();
error_reporting(E_ALL);
if(file_exists("connection.php")){
	include_once ('connection.php');
}else{
	include_once ('connection.php');
}

date_default_timezone_set("Africa/Harare");

class Settings{
	private $dbCon;

//private $username;

	public function __construct(){

		try{

		$this->dbCon = new Connection();

		$this->dbCon = $this->dbCon->dbConnection();
		$this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e){
			echo "Lost connection to the database";
		}
	}

	public function getCurrentSettings(){
		$getCurrentSettings = $this->dbCon->PREPARE("SELECT year, semester_id
		 FROM settings INNER JOIN semester ON(settings.semester_id=semester.id)");
		$getCurrentSettings->bindParam(1,$status);
		$getCurrentSettings->execute();
		
		if($getCurrentSettings->rowCount()>0){
			$row = $getCurrentSettings->fetch();
			
			return $row;
		}
	}
	



} //End of class settings



class User{
	private $dbCon;

//private $username;

	public function __construct(){

		try{

		$this->dbCon = new Connection();

		$this->dbCon = $this->dbCon->dbConnection();
		$this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e){
			echo "Lost connection to the database";
		}
	}

	public function login($username, $password){

		if(!empty($username) && !empty($password)) {
			
		//$status = 2;// inactive status
		$login_query = $this->dbCon->PREPARE("SELECT username, firstname,middlename,lastname, password, roles_id, status FROM users WHERE username=?" );

				$login_query->bindParam(1, $username);
				$login_query->execute();

				if($login_query->rowCount() ==1){
					
				$row = $login_query -> fetch();
				$hash_pass =trim($row['password']);
				$roles_id =$row['roles_id'];
				$status =trim($row['status']);
				//verify password
				if (password_verify($password, $hash_pass) && $status == 1) {
					
					// Success!
					$_SESSION['user'] = $row;
					if ($roles_id == 1) { //admin
						header("Location: admin/index.php");

					} elseif ($roles_id == 2) { //teacher
						header("Location: teacher/index.php");

					}elseif ($roles_id == 3) { //student
						header("Location: student/index.php");

					}elseif ($roles_id == 4) { //student
						header("Location: accountant/index.php");
					}else{
						$_SESSION['invalidRole']=true;
					}
					
					//die();
				}else {
					
					 $_SESSION['invalidUser']=true;
				}


				}else{

                    $_SESSION['invalidUser']=true;

				}

		}
	} //end of login authentication


	
	public function getUserProfile(){	
				$getUserProfile = $this->dbCon->prepare("SELECT username,firstname,middlename,lastname, picture FROM users WHERE username=?" );
				$getUserProfile->bindParam(1, $_SESSION['user']['username']);
				$getUserProfile->execute();

				if($getUserProfile->rowCount() ==1){
				$row = $getUserProfile -> fetch();

				return $row;
				//verify password

			}	
	}



	public function getAllClasses(){	
				$getAllClasses = $this->dbCon->prepare("SELECT id, name FROM classes" );
				//$getAllClasses->bindParam(1, $_SESSION['user']['username']);
				$getAllClasses->execute();

				if($getAllClasses->rowCount()>0){
				$rows = $getAllClasses -> fetchAll();

				return $rows;

			}	
	}//End og getting all Classes



  public function addUser($username,$firstname,$middlename, $lastname, $role,$password,$status){
	  $date = DATE("Y-m-d h:i");
		//check if the user is already in the system before adding new user
		$checkUser = $this->dbCon->prepare("SELECT username from users where username=?" );
		$checkUser->bindValue(1, $username);
		$checkUser->execute();
		if($checkUser->rowCount() ==1){
			//user already in the system
			$_SESSION['user_found']= true;
		}else{
				$addUser = $this->dbCon->prepare("INSERT INTO users (username, password, firstname,middlename, lastname,user_status_id,roles_id,date_added) 
				VALUES (:username, :password, :firstname,:middlename, :lastname,:user_status_id,:roles_role_id,:date_added)" );
				$addUser->execute(array(
						  ':username'=>($username),
						  ':password'=>($password),
						  ':firstname'=>($firstname),
						  ':middlename'=>($middlename),
						  ':lastname'=>($lastname),
						  ':user_status_id'=>('1'),
						  ':roles_role_id'=>($role),
						  ':date_added'=>($date)
						  ));		

		  $_SESSION['user-added']=true;
			}
		

	} //end adding users

//edit user
	  public function editUser($username,$firstname,$middlename, $lastname, $role,$phone,$email,$status,$UID){
				//echo $username; die();	
				$editUser = $this->dbCon->prepare("UPDATE users SET firstname,middlename,lastname?,email=?,phone=?,role=?,status=? WHERE username=?" );
				$editUser->bindParam(1,$firstname);
				$editUser->bindParam(2,$middlename);
				$editUser->bindParam(3,$lastname);
				$editUser->bindParam(4,$email);
				$editUser->bindParam(5,$phone);
				$editUser->bindParam(6,$role);
				$editUser->bindParam(7,$status);
				$editUser->bindParam(8,$UID);
				$editUser->execute();
				if($role == 10 || $role==200){ //add him/her to layers table
					$status = 1; //active					
					$officer_code =substr($firstname,0,1).substr($lastname,0,1);
				
					$editlawyer = $this->dbCon->prepare("UPDATE lawyer SET firstname=?,middlename=?, lastname=?, status=?,phone=?,email=?,role=? 
					WHERE id=?");
					$editlawyer->bindParam(1,$firstname);
					$editlawyer->bindParam(2,$middlename);
					$editlawyer->bindParam(3,$lastname);
					$editlawyer->bindParam(4,$status);
					$editlawyer->bindParam(5,$phone);
					$editlawyer->bindParam(6,$email);
					$editlawyer->bindParam(7,$role);
					$editlawyer->bindParam(8,$UID);
					$editlawyer->execute();
				}

		  $_SESSION['user-edited']=true;



	} //end Editing users



	public function getUsers(){
		//get all users
		try{
			$getUsers = $this->dbCon->prepare("SELECT username, firstname, middlename,lastname, email, phone from users WHERE username != ?" );
			$getUsers->bindParam(1,$_SESSION['user']['username']);
			$getUsers->execute();
			if($getUsers->rowCount()>0){
				$row = $getUsers->fetchAll();
				return $row;
			}else{
				return null;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}


	} //end of getting users
	

	public function countAllUsers(){
		//get all users
		try{
			$countAllUsers = $this->dbCon->prepare("SELECT count(id) as user_id FROM users");
			$countAllUsers->execute();
			if($countAllUsers->rowCount()>0){
				$row = $countAllUsers->fetch();
				return $row;
			}else{
				return null;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}


	} //end of Counting all users


	public function countAllStudents(){
		//get all users
		try{
			$countAllStudents = $this->dbCon->prepare("SELECT count(student_no) as student_no FROM students");
			$countAllStudents->execute();
			if($countAllStudents->rowCount()>0){
				$row = $countAllStudents->fetch();
				return $row;
			}else{
				return null;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}


	} //end of Counting all Students


		public function getAllUsers(){
		//get all users
		try{
			$getUsers = $this->dbCon->prepare("SELECT username, firstname, middlename, lastname, status, date_added, roles.name as role_name FROM users INNER JOIN roles ON 
				(users.roles_id=roles.id) " );
			$getUsers->execute();
			if($getUsers->rowCount()>0){
				$rows = $getUsers->fetchAll();
				return $rows;
			}else{
				return null;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}


	} //end of getting users
	//get specfic user
	public function getSpecificUser($username){
		
		try{
			$getSpecificUser = $this->dbCon->prepare("SELECT username, password,firstname, middlename,lastname, email, phone, role, roles.name as role_name,
			status, IF(status=1, 'Active','Not Active') as status_name FROM users INNER JOIN roles ON (users.role=roles.id)WHERE username = ?" );
			$getSpecificUser->bindParam(1,$username);
			$getSpecificUser->execute();
			if($getSpecificUser->rowCount()>0){
				$row = $getSpecificUser->fetch();
				return $row;
			}else{
				return null;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}


	} //end of getting users
	

	public function getSingleUser($username){
		//get one users
		try{
			$getUsers = $this->dbCon->prepare("SELECT id, username, fname, lname, email, phone, users.role_id AS role_id, roles.name AS role from users INNER JOIN roles ON (roles.role_id = users.role_id) WHERE username = ?" );
			$getUsers->bindParam(1, $username);
			$getUsers->execute();
			if($getUsers->rowCount()>0){
				$row = $getUsers->fetch();
				return $row;
			}else{
				return null;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}


	} //end of getting single user

	//Update Password
	public function updatePassword($username, $password){

		try{
			$updatepassword = $this->dbCon->prepare("UPDATE users SET password =? WHERE username=?");
			$updatepassword->bindparam(1, $password);
			$updatepassword->bindparam(2, $username);
			$updatepassword->execute();

			$_SESSION['password_updated'] =true;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}//End of Updating password


	public function enableUser($id){

		try{
			$status = 1;
			$enableUser = $this->dbCon->prepare("UPDATE users SET status =? WHERE username=?");
			$enableUser->bindparam(1, $status);
			$enableUser->bindparam(2, $id);
			$enableUser->execute();

			$_SESSION['user_enabled'] =true;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}//End of enabling user
	

	public function disableUser($id){

		try{
			$status = 2;
			$disableUser = $this->dbCon->prepare("UPDATE users SET status =? WHERE username=?");
			$disableUser->bindparam(1, $status);
			$disableUser->bindparam(2, $id);
			$disableUser->execute();

			$_SESSION['user_disabled'] =true;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}//End of Disabling user




} //End of Class Users


class Students{
	private $dbCon;

//private $username;

	public function __construct(){

		try{

		$this->dbCon = new Connection();

		$this->dbCon = $this->dbCon->dbConnection();
		$this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e){
			echo "Lost connection to the database";
		}
	}



  public function addStudent($image_Path, $firstname, $lastname, $email, $nationality, $phone, $dob, $gender, $class_id){
	  $date = DATE("Y-m-d h:i");
		//Increment the Student Number Before Inserting in the DB
		$checkUser = $this->dbCon->prepare("SELECT COUNT(student_no) as student_no FROM students" );
		//$checkUser->bindValue(1, $student_no);
		$checkUser->execute();
		if($checkUser->rowCount() > 0){
			//Increment Student NO
			$row = $checkUser->fetch();
					
			$count = $row['student_no'] + 1;
			$student_no = "MRC/S/".$count;
			
			$hashed_password = password_hash($student_no, PASSWORD_DEFAULT);
				$status = 1; //Active/Activated
				$roles_id = 3; //Student
				$addStudent = $this->dbCon->prepare("INSERT INTO students (student_no, firstname,email, lastname,dob,gender,date_added, status, picture, nationality, classes_id, phone) 
				VALUES (:student_no, :firstname,:email, :lastname,:dob,:gender,:date_added, :status, :picture, :nationality, :classes_id, :phone)" );
				$addStudent->execute(array(
						  ':student_no'=>($student_no),
						  ':firstname'=>($firstname),
						  ':email'=>($email),
						  ':lastname'=>($lastname),
						  ':dob'=>($dob),
						  ':gender'=>($gender),
						  ':date_added'=>($date),
						  ':status'=>($status),
						  ':picture'=>($image_Path),
						  ':nationality'=>($nationality),
						  ':classes_id'=>($class_id),
						  ':phone'=>($phone)
						  ));



			$addStudentToUsers = $this->dbCon->prepare("INSERT INTO users (username, firstname, lastname, status, password, date_added, roles_id, picture) 
				VALUES (:username, :firstname,:lastname, :status, :password, :date_added, :roles_id, :picture)" );
				$addStudentToUsers->execute(array(
						  ':username'=>($student_no),
						  ':firstname'=>($firstname),
						  ':lastname'=>($lastname),
						  ':status'=>($status),
						  ':password'=>($hashed_password),
						  ':date_added'=>($date),
						  ':roles_id'=>($roles_id),
						  ':picture'=>($image_Path)
						  ));


		  $_SESSION['student-added']=true;
		}else{

			$_SESSION['failed']= true;
				
			}
		

	} //End adding Student


	public function getStudents(){
		$getStudents = $this->dbCon->Prepare("SELECT student_no, dob, gender, date_added, classes.name as class_name, email, status, CONCAT(firstname,' ',lastname) as name 
		FROM students INNER JOIN classes ON(students.classes_id=classes.id) ORDER BY date_added DESC");
		$getStudents->execute();
		
		if($getStudents->rowCount()>0){
			$rows = $getStudents->fetchAll();
			return $rows;
		}
	} //end of getting Students


	public function deleteStudent($id){

		$deleteStudent =$this->dbCon->PREPARE("DELETE FROM students WHERE student_no=?");
		$deleteStudent->bindParam(1,$id);
		$deleteStudent->execute();

		$deleteStudentUser =$this->dbCon->PREPARE("DELETE FROM users WHERE username=?");
		$deleteStudentUser->bindParam(1,$id);
		$deleteStudentUser->execute();

		$_SESSION['student-deleted']=true;
		
	}//End of deleting Student




} //End of class Students



class Staff{
	private $dbCon;

//private $username;

	public function __construct(){

		try{

		$this->dbCon = new Connection();

		$this->dbCon = $this->dbCon->dbConnection();
		$this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e){
			echo "Lost connection to the database";
		}
	}



  public function addTeacher($image_Path, $firstname, $lastname, $email, $nationality, $teacher_id, $dob, $gender, $qualification, $experience){
	  $date = DATE("Y-m-d h:i");
		//check if the Teacher is already in the system before adding new user
		$checkUser = $this->dbCon->prepare("SELECT teacher_id from teachers where teacher_id=?" );
		$checkUser->bindValue(1, $teacher_id);
		$checkUser->execute();
		if($checkUser->rowCount() ==1){
			//Teacher already in the system
			$_SESSION['teacher-found']= true;
		}else{
				$hashed_password = password_hash($teacher_id, PASSWORD_DEFAULT);
				$status = 1; //Active
				$roles_id = 2; //Teacher
				$addTeacher = $this->dbCon->prepare("INSERT INTO teachers (teacher_id, firstname,email, lastname,dob,gender,date_added, qualification, picture, nationality, experience) 
				VALUES (:teacher_id, :firstname,:email, :lastname,:dob,:gender,:date_added, :qualification, :picture, :nationality, :experience)" );
				$addTeacher->execute(array(
						  ':teacher_id'=>($teacher_id),
						  ':firstname'=>($firstname),
						  ':email'=>($email),
						  ':lastname'=>($lastname),
						  ':dob'=>($dob),
						  ':gender'=>($gender),
						  ':date_added'=>($date),
						  ':qualification'=>($qualification),
						  ':picture'=>($image_Path),
						  ':nationality'=>($nationality),
						  ':experience'=>($experience)
						  ));



			$addTeacherToUsers = $this->dbCon->prepare("INSERT INTO users (username, firstname, lastname, status, password, date_added, roles_id, picture) 
				VALUES (:username, :firstname,:lastname, :status, :password, :date_added, :roles_id, :picture)" );
				$addTeacherToUsers->execute(array(
						  ':username'=>($teacher_id),
						  ':firstname'=>($firstname),
						  ':lastname'=>($lastname),
						  ':status'=>($status),
						  ':password'=>($hashed_password),
						  ':date_added'=>($date),
						  ':roles_id'=>($roles_id),
						  ':picture'=>($image_Path)
						  ));


		  $_SESSION['teacher-added']=true;
			}
		

	} //end adding Teacher


  public function addAccountant($image_Path, $firstname, $lastname, $email, $nationality, $staff_id, $dob, $gender, $qualification, $experience, $phone){
	  $date = DATE("Y-m-d h:i");
		//check if the Teacher is already in the system before adding new user
		$checkUser = $this->dbCon->prepare("SELECT staff_id from accountants where staff_id=?" );
		$checkUser->bindValue(1, $staff_id);
		$checkUser->execute();
		if($checkUser->rowCount() ==1){
			//Accountant already in the system
			$_SESSION['accountant-found']= true;
		}else{
				$hashed_password = password_hash($staff_id, PASSWORD_DEFAULT);
				$status = 1; //Active
				$roles_id = 4; //Accountant
				$addAccountant = $this->dbCon->prepare("INSERT INTO accountants (staff_id, firstname,email, lastname,dob,gender,date_added, qualification, picture, nationality, experience, phone) 
				VALUES (:staff_id, :firstname,:email, :lastname,:dob,:gender,:date_added, :qualification, :picture, :nationality, :experience, :phone)" );
				$addAccountant->execute(array(
						  ':staff_id'=>($staff_id),
						  ':firstname'=>($firstname),
						  ':email'=>($email),
						  ':lastname'=>($lastname),
						  ':dob'=>($dob),
						  ':gender'=>($gender),
						  ':date_added'=>($date),
						  ':qualification'=>($qualification),
						  ':picture'=>($image_Path),
						  ':nationality'=>($nationality),
						  ':experience'=>($experience),
						  ':phone'=>($phone)
						  ));



			$addAccountantToUsers = $this->dbCon->prepare("INSERT INTO users (username, firstname, lastname, status, password, date_added, roles_id, picture) 
				VALUES (:username, :firstname,:lastname, :status, :password, :date_added, :roles_id, :picture)" );
				$addAccountantToUsers->execute(array(
						  ':username'=>($staff_id),
						  ':firstname'=>($firstname),
						  ':lastname'=>($lastname),
						  ':status'=>($status),
						  ':password'=>($hashed_password),
						  ':date_added'=>($date),
						  ':roles_id'=>($roles_id),
						  ':picture'=>($image_Path)
						  ));


		  $_SESSION['accountant-added']=true;
			}
		

	} //end adding Teacher



	public function getTeachers(){
		$getTeachers = $this->dbCon->Prepare("SELECT teacher_id, id, dob, gender, date_added, nationality, qualification, experience, email, CONCAT(firstname,' ',lastname) as name 
		FROM teachers ORDER BY date_added DESC");
		$getTeachers->execute();
		
		if($getTeachers->rowCount()>0){
			$rows = $getTeachers->fetchAll();
			return $rows;
		}
	} //end of getting Teachers


	public function getAccountants(){
		$getAccountants = $this->dbCon->Prepare("SELECT staff_id, dob, gender, date_added, nationality, qualification, experience, email, CONCAT(firstname,' ',lastname) as name 
		FROM accountants ORDER BY date_added DESC");
		$getAccountants->execute();
		
		if($getAccountants->rowCount()>0){
			$rows = $getAccountants->fetchAll();
			return $rows;
		}
	} //end of getting Accountants


	public function deleteTeacher($id){

		$deleteTeacher =$this->dbCon->PREPARE("DELETE FROM teachers WHERE teacher_id=?");
		$deleteTeacher->bindParam(1,$id);
		$deleteTeacher->execute();

		$deleteTeacherUser =$this->dbCon->PREPARE("DELETE FROM users WHERE username=?");
		$deleteTeacherUser->bindParam(1,$id);
		$deleteTeacherUser->execute();

		$_SESSION['teacher-deleted']=true;
		
	}//End of deleting Student



	public function getAllClassModules($class_id){
		$getAllClassModules = $this->dbCon->Prepare("SELECT classes_has_modules.classes_id as classes_id, modules.name as module_name, classes_has_modules.modules_id as modules_id
		FROM classes_has_modules INNER JOIN classes ON(classes_has_modules.classes_id=classes.id) INNER JOIN modules ON(classes_has_modules.modules_id=modules.id) WHERE classes.id =? ");
		$getAllClassModules->bindParam(1, $class_id);
		$getAllClassModules->execute();
		
		if($getAllClassModules->rowCount()>0){
			$rows = $getAllClassModules->fetchAll();
			return $rows;
		}
	} //End of getting Modules Per Class



} //End of class Staff


class Accountant{
	private $dbCon;

//private $username;

	public function __construct(){

		try{

		$this->dbCon = new Connection();

		$this->dbCon = $this->dbCon->dbConnection();
		$this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e){
			echo "Lost connection to the database";
		}
	}


  public function RecordFeesBalance($balance, $student_no, $remarks){
  	$date = DATE("Y-m-d h:i");
				$RecordFeesBalance = $this->dbCon->prepare("INSERT INTO fees_balances (students_student_no, balance,remarks, date_recorded) 
				VALUES (:students_student_no, :balance, :remarks, :date_recorded)" );
				$RecordFeesBalance->execute(array(
						  ':students_student_no'=>($student_no),
						  ':balance'=>($balance),
						  ':remarks'=>($remarks),
						  ':date_recorded'=>($date)
						  ));



		  $_SESSION['balance-recorded']=true;
		

	} //end of Recording Fees Balance


	public function getStudentsBalances(){
		$status = 1; //Fees balance not resolved
		$getStudentsBalances = $this->dbCon->Prepare("SELECT students_student_no, balance, remarks, date_recorded, CONCAT(students.firstname,' ',students.lastname) as name
		FROM fees_balances INNER JOIN students ON(fees_balances.students_student_no=students.student_no) WHERE fees_balances.status =? ORDER BY date_recorded DESC");
		$getStudentsBalances->bindParam(1,$status);
		$getStudentsBalances->execute();
		
		if($getStudentsBalances->rowCount()>0){
			$rows = $getStudentsBalances->fetchAll();
			return $rows;
		}
	} //end of getting Students with Fees Balances



	public function countAllStudentFeesBalances(){
		$countAllStudentFeesBalances = $this->dbCon->Prepare("SELECT COUNT(students_student_no) as student_no FROM fees_balances");
		$countAllStudentFeesBalances->execute();
		
		if($countAllStudentFeesBalances->rowCount()>0){
			$row = $countAllStudentFeesBalances->fetch();
			return $row;
		}
	} //end of getting Students with Fees Balances



	public function resolveFeesBalance($student_no){
		$status = 0; //Fees Resolved
		$resolveFeesBalance = $this->dbCon->Prepare("UPDATE fees_balances SET status =? WHERE students_student_no =? ");
		$resolveFeesBalance->bindParam(1, $status);
		$resolveFeesBalance->bindParam(2, $student_no);
		$resolveFeesBalance->execute();

		$_SESSION['fees_resolved'] = true;
		
	} //End of Resolving Fees Balance


} //End of class Accountant



class Teacher{
	private $dbCon;

//private $username;

	public function __construct(){

		try{

		$this->dbCon = new Connection();

		$this->dbCon = $this->dbCon->dbConnection();
		$this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e){
			echo "Lost connection to the database";
		}
	}


	public function getStudentsPerClass($class_id){
		$getStudentsPerClass = $this->dbCon->Prepare("SELECT student_no, dob, gender, date_added, classes.name as class_name, email, status, CONCAT(firstname,' ',lastname) as name 
		FROM students INNER JOIN classes ON(students.classes_id=classes.id) WHERE students.classes_id=? ORDER BY date_added DESC");
		$getStudentsPerClass->bindParam(1, $class_id);
		$getStudentsPerClass->execute();
		
		if($getStudentsPerClass->rowCount()>0){
			$rows = $getStudentsPerClass->fetchAll();
			return $rows;
		}
	} //end of getting Students Per Class



  public function recordGrade($grade, $student_no, $class_id, $year, $semester_id, $modules_id){
  	$date = DATE("Y-m-d h:i");
  		$checkGrades = $this->dbCon->PREPARE("SELECT modules_id, classes_id, year,semester_id
		FROM grades 
		WHERE modules_id=? AND classes_id=? AND year=? AND semester_id=?" );
		$checkGrades->bindValue(1, $modules_id);
		$checkGrades->bindValue(2, $class_id);
		$checkGrades->bindValue(3, $year);
		$checkGrades->bindValue(4, $semester_id);		
		$checkGrades->execute();
		if($checkGrades->rowCount()>0){

			$_SESSION['grade_present']=true;
			//echo "<script>alert('You have already Recorded Grades for this Class and Module');</script>";
		}else{

  				if(count($grade)>0){
				foreach(array_combine($student_no, $grade) as $student => $grades){	

				$recordGrade = $this->dbCon->prepare("INSERT INTO grades (students_student_no, classes_id, grade, year, semester_id, date_recorded, modules_id) 
				VALUES (:students_student_no, :classes_id, :grade, :year, :semester_id, :date_recorded, :modules_id)" );
				$recordGrade->execute(array(
						  ':students_student_no'=>($student),
						  ':classes_id'=>($class_id),
						  ':grade'=>($grades),
						  ':year'=>($year),
						  ':semester_id'=>($semester_id),
						  ':date_recorded'=>($date),
						  ':modules_id'=>($modules_id)
						  ));



		  $_SESSION['grade_recorded']=true;
					
				}
				
			}

		}

	} //end of Recording Student Grade



  public function addMaterial($title, $material, $modules_id, $classes_id, $year, $semester_id){
  	$date = DATE("Y-m-d h:i");
  		$checkLearningMaterial = $this->dbCon->PREPARE("SELECT modules_id, classes_id, year,semester_id
		FROM materials 
		WHERE modules_id=? AND classes_id=? AND year=? AND semester_id=?" );
		$checkLearningMaterial->bindValue(1, $modules_id);
		$checkLearningMaterial->bindValue(2, $classes_id);
		$checkLearningMaterial->bindValue(3, $year);
		$checkLearningMaterial->bindValue(4, $semester_id);		
		$checkLearningMaterial->execute();
		if($checkLearningMaterial->rowCount()>0){

			$_SESSION['material_present']=true;
			//echo "<script>alert('You have already Added Material for this Class and Module');</script>";
		}else{	

				$addMaterial = $this->dbCon->prepare("INSERT INTO materials (title, material, modules_id, classes_id, year, semester_id, date_added) 
				VALUES (:title, :material, :modules_id, :classes_id, :year, :semester_id, :date_added)" );
				$addMaterial->execute(array(
						  ':title'=>($title),
						  ':material'=>($material),
						  ':modules_id'=>($modules_id),
						  ':classes_id'=>($classes_id),
						  ':year'=>($year),
						  ':semester_id'=>($semester_id),
						  ':date_added'=>($date)
						  ));



		  $_SESSION['material_added']=true;
					

		}

	} //End of Adding Material


	public function getMaterialsPerClassModule($classes_id, $modules_id){
		$getMaterialsPerClassModule = $this->dbCon->Prepare("SELECT title, material, modules.name as module_name, classes.name as class_name, year, semester_id, date_added FROM materials INNER JOIN modules ON(materials.modules_id=modules.id) INNER JOIN classes ON(materials.classes_id=classes.id) WHERE classes_id=? AND modules_id=? ORDER BY date_added DESC");
		$getMaterialsPerClassModule->bindParam(1, $classes_id);
		$getMaterialsPerClassModule->bindParam(2, $modules_id);

		$getMaterialsPerClassModule->execute();
		
		if($getMaterialsPerClassModule->rowCount()>0){
			$rows = $getMaterialsPerClassModule->fetchAll();
			return $rows;
		}
	} //End of getting Materials Per Class Per Module



	public function getModuleName($modules_id){
		$getModuleName = $this->dbCon->Prepare("SELECT name 
		FROM modules WHERE id=? ");
		$getModuleName->bindParam(1, $modules_id);
		$getModuleName->execute();
		
		if($getModuleName->rowCount()>0){
			$row = $getModuleName->fetch();
			return $row;
		}
	} //End of getting Module Name

	public function getClassName($class_id){
		$getClassName = $this->dbCon->Prepare("SELECT name 
		FROM classes WHERE id=? ");
		$getClassName->bindParam(1, $class_id);
		$getClassName->execute();
		
		if($getClassName->rowCount()>0){
			$row = $getClassName->fetch();
			return $row;
		}
	} //End of getting Module Name



	public function getStudentsGradesPerClass($class_id, $modules_id){
		$getStudentsGradesPerClass = $this->dbCon->Prepare("SELECT students.student_no as student_no, grade, date_recorded, classes.name as class_name, CONCAT(students.firstname,' ',students.lastname) as name 
		FROM grades INNER JOIN students ON(grades.students_student_no=students.student_no) INNER JOIN classes ON(students.classes_id=classes.id) INNER JOIN modules ON(grades.modules_id=modules.id) WHERE grades.classes_id=? AND grades.modules_id=? ORDER BY date_added DESC");
		$getStudentsGradesPerClass->bindParam(1, $class_id);
		$getStudentsGradesPerClass->bindParam(2, $modules_id);

		$getStudentsGradesPerClass->execute();
		
		if($getStudentsGradesPerClass->rowCount()>0){
			$rows = $getStudentsGradesPerClass->fetchAll();
			return $rows;
		}
	} //end of getting Students Per Class Per Module


	public function getSpecificTeacher(){
		$getSpecificTeacher = $this->dbCon->Prepare("SELECT teacher_id, firstname, middlename, lastname, dob, phone, email, qualification, experience, picture, gender, nationality
		FROM teachers WHERE teacher_id =? ");
		$getSpecificTeacher->bindParam(1, $_SESSION['user']['username']);
		$getSpecificTeacher->execute();
		
		if($getSpecificTeacher->rowCount()>0){
			$row = $getSpecificTeacher->fetch();
			return $row;
		}
	} //End of getting Specific Teacher


	  public function editTeacher($firstname, $middlename, $lastname, $dob, $phone, $picture){
				//echo $username; die();	
				$editTeacher = $this->dbCon->prepare("UPDATE teachers SET firstname,middlename,lastname?,email=?,phone=?,dob=?,picture=? WHERE teacher_id=?" );
				$editTeacher->bindParam(1,$firstname);
				$editTeacher->bindParam(2,$middlename);
				$editTeacher->bindParam(3,$lastname);
				$editTeacher->bindParam(4,$email);
				$editTeacher->bindParam(5,$phone);
				$editTeacher->bindParam(6,$dob);
				$editTeacher->bindParam(7,$picture);
				$editTeacher->bindParam(8,$_SESSION['user']['username']);
				$editTeacher->execute();

		  $_SESSION['teacher_edited']=true;



	} //End Editing a Teacher




} //End of class Teacher
