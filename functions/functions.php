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
		$getCurrentSettings = $this->dbCon->PREPARE("SELECT settings.id as id, year, semester_id, semester.name as semester_name
		 FROM settings INNER JOIN semester ON(settings.semester_id=semester.id)");
		//$getCurrentSettings->bindParam(1,$status);
		$getCurrentSettings->execute();
		
		if($getCurrentSettings->rowCount()>0){
			$row = $getCurrentSettings->fetch();
			
			return $row;
		}
	}//End of getting Current Settings

	public function addModule($class_id, $module){
		$addModule = $this->dbCon->prepare("INSERT INTO modules (name) 
		VALUES (:name)" );
		$addModule->execute(array(
			':name'=>($module)
			));
		$modules_id = $this->dbCon->lastInsertId();

		$addModuleToClass = $this->dbCon->prepare("INSERT INTO classes_has_modules (classes_id, modules_id) 
		VALUES (:classes_id, :modules_id)" );
		$addModuleToClass->execute(array(
			':classes_id'=>($class_id),
			':modules_id'=>($modules_id)
			));

		 $_SESSION['module_added']=true;
		

	} //end of Adding A Module

  public function addClass($class){
		$addClass = $this->dbCon->prepare("INSERT INTO classes (name) 
		VALUES (:name)" );
		$addClass->execute(array(
				  ':name'=>($class)
				  ));

		$_SESSION['class_added']=true;
		

	} //end of Adding A Class

	public function getClasses(){
		$getClasses = $this->dbCon->PREPARE("SELECT id, name
		 FROM classes");
		//$getClasses->bindParam(1,$status);
		$getClasses->execute();
		
		if($getClasses->rowCount()>0){
			$rows = $getClasses->fetchAll();
			
			return $rows;
		}
	}//End of getting Classes


	public function getModules(){
		$getModules = $this->dbCon->PREPARE("SELECT id, name
		 FROM modules");
		//$getModules->bindParam(1,$status);
		$getModules->execute();
		
		if($getModules->rowCount()>0){
			$rows = $getModules->fetchAll();
			
			return $rows;
		}
	}//End of getting modules


  public function addTimetableEntry($class_id, $modules_id, $time_from, $time_to, $timetable_date){
		$addTimetableEntry = $this->dbCon->prepare("INSERT INTO timetable (time_from, time_to, timetable_date, modules_id, classes_id) 
		VALUES (:time_from, :time_to, :timetable_date, :modules_id, :classes_id)" );
		$addTimetableEntry->execute(array(
				  ':time_from'=>($time_from),
				  ':time_to'=>($time_to),
				  ':timetable_date'=>($timetable_date),
				  ':modules_id'=>($modules_id),
				  ':classes_id'=>($class_id)
				  ));

		$_SESSION['entry_added']=true;
		

	} //end of Adding A timetable entry


	public function getTimetableEntries(){
		$getTimetableEntries = $this->dbCon->PREPARE("SELECT timetable.id as id, time_from, time_to, timetable_date, modules_id, classes_id, classes.name as class, modules.name as module FROM timetable INNER JOIN classes ON(timetable.classes_id=classes.id) INNER JOIN modules ON(timetable.modules_id=modules.id) ");
		//$getTimetableEntries->bindParam(1,$status);
		$getTimetableEntries->execute();
		
		if($getTimetableEntries->rowCount()>0){
			$rows = $getTimetableEntries->fetchAll();
			
			return $rows;
		}
	}//End of getting timetable entries


	public function getTimetableEntriesPerStudent($classes_id){
		$getTimetableEntriesPerStudent = $this->dbCon->PREPARE("SELECT timetable.id as id, time_from, time_to, timetable_date, modules_id, classes_id, classes.name as class, modules.name as module FROM timetable INNER JOIN classes ON(timetable.classes_id=classes.id) INNER JOIN modules ON(timetable.modules_id=modules.id) WHERE timetable.classes_id=? ");
		$getTimetableEntriesPerStudent->bindParam(1,$classes_id);
		$getTimetableEntriesPerStudent->execute();
		
		if($getTimetableEntriesPerStudent->rowCount()>0){
			$rows = $getTimetableEntriesPerStudent->fetchAll();
			
			return $rows;
		}
	}//End of getting timetable entries per student



	public function editTimetableEntry($entry_id, $class_id, $modules_id, $time_from, $time_to, $timetable_date){
		$editTimetableEntry = $this->dbCon->prepare("UPDATE timetable SET time_from=? , time_to=?, modules_id=?, classes_id=?, timetable_date=? WHERE id=?" );
		$editTimetableEntry->bindParam(1,$time_from);
		$editTimetableEntry->bindParam(2,$time_to);
		$editTimetableEntry->bindParam(3,$modules_id);
		$editTimetableEntry->bindParam(4,$class_id);
		$editTimetableEntry->bindParam(5,$timetable_date);
		$editTimetableEntry->bindParam(6,$entry_id);
		$editTimetableEntry->execute();

		$_SESSION['entry_updated']=true;


	}//End of Updating a timetable entry


	public function deleteTimetableEntry($class_id){
		try{
		$deleteTimetableEntry = $this->dbCon->PREPARE("DELETE FROM classes WHERE id=?");
		$deleteTimetableEntry->bindParam(1,$class_id);
		$deleteTimetableEntry->execute();

		$_SESSION['entry_deleted']=true;

		}catch(PDOException $e){
			$_SESSION['failed'] = true;
		}


	}//End of Deleting a timetable entry


  public function addExamCalendarEntry($class_id, $modules_id, $time_from, $time_to, $exam_date){
		$addExamCalendarEntry = $this->dbCon->prepare("INSERT INTO exam_calendar (time_from, time_to, exam_date, modules_id, classes_id) 
		VALUES (:time_from, :time_to, :exam_date, :modules_id, :classes_id)" );
		$addExamCalendarEntry->execute(array(
				  ':time_from'=>($time_from),
				  ':time_to'=>($time_to),
				  ':exam_date'=>($exam_date),
				  ':modules_id'=>($modules_id),
				  ':classes_id'=>($class_id)
				  ));

		$_SESSION['entry_added']=true;
		

	} //end of Adding an exam calendar entry


	public function getExamCalendarEntries(){
		$getExamCalendarEntries = $this->dbCon->PREPARE("SELECT exam_calendar.id as id, time_from, time_to, exam_date, modules_id, classes_id, classes.name as class, modules.name as module FROM exam_calendar INNER JOIN classes ON(exam_calendar.classes_id=classes.id) INNER JOIN modules ON(exam_calendar.modules_id=modules.id) ");
		//$getExamCalendarEntries->bindParam(1,$status);
		$getExamCalendarEntries->execute();
		
		if($getExamCalendarEntries->rowCount()>0){
			$rows = $getExamCalendarEntries->fetchAll();
			
			return $rows;
		}
	}//End of getting exam calendar entries


	public function getExamCalendarEntriesPerStudent($classes_id){
		$getExamCalendarEntriesPerStudent = $this->dbCon->PREPARE("SELECT exam_calendar.id as id, time_from, time_to, exam_date, modules_id, classes_id, classes.name as class, modules.name as module FROM exam_calendar INNER JOIN classes ON(exam_calendar.classes_id=classes.id) INNER JOIN modules ON(exam_calendar.modules_id=modules.id) WHERE exam_calendar.classes_id=? ");
		$getExamCalendarEntriesPerStudent->bindParam(1,$classes_id);
		$getExamCalendarEntriesPerStudent->execute();
		
		if($getExamCalendarEntriesPerStudent->rowCount()>0){
			$rows = $getExamCalendarEntriesPerStudent->fetchAll();
			
			return $rows;
		}
	}//End of getting exam calendar entries per student


	public function getExamCalendarEntriesPerStudentDash($classes_id){
		$getExamCalendarEntriesPerStudentDash = $this->dbCon->PREPARE("SELECT exam_calendar.id as id, time_from, time_to, exam_date, modules_id, classes_id, classes.name as class, modules.name as module FROM exam_calendar INNER JOIN classes ON(exam_calendar.classes_id=classes.id) INNER JOIN modules ON(exam_calendar.modules_id=modules.id) WHERE exam_calendar.classes_id=? ORDER BY exam_calendar.id ASC LIMIT 5 ");
		$getExamCalendarEntriesPerStudentDash->bindParam(1,$classes_id);
		$getExamCalendarEntriesPerStudentDash->execute();
		
		if($getExamCalendarEntriesPerStudentDash->rowCount()>0){
			$rows = $getExamCalendarEntriesPerStudentDash->fetchAll();
			
			return $rows;
		}
	}//End of getting exam calendar entries per student


	public function editExamCalendarEntry($entry_id, $class_id, $modules_id, $time_from, $time_to, $exam_date){
		$editExamCalendarEntry = $this->dbCon->prepare("UPDATE exam_calendar SET time_from=? , time_to=?, modules_id=?, classes_id=?, exam_date=? WHERE id=?" );
		$editExamCalendarEntry->bindParam(1,$time_from);
		$editExamCalendarEntry->bindParam(2,$time_to);
		$editExamCalendarEntry->bindParam(3,$modules_id);
		$editExamCalendarEntry->bindParam(4,$class_id);
		$editExamCalendarEntry->bindParam(5,$exam_date);
		$editExamCalendarEntry->bindParam(6,$entry_id);
		$editExamCalendarEntry->execute();

		$_SESSION['entry_updated']=true;


	}//End of Updating an exam calendar entry


	public function deleteExamCalendarEntry($class_id){
		try{
		$deleteExamCalendarEntry = $this->dbCon->PREPARE("DELETE FROM exam_calendar WHERE id=?");
		$deleteExamCalendarEntry->bindParam(1,$class_id);
		$deleteExamCalendarEntry->execute();

		$_SESSION['entry_deleted']=true;

		}catch(PDOException $e){
			$_SESSION['failed'] = true;
		}


	}//End of Deleting an exam calendar entry


	public function deleteClass($class_id){
		try{
		$deleteClass = $this->dbCon->PREPARE("DELETE FROM classes WHERE id=?");
		$deleteClass->bindParam(1,$class_id);
		$deleteClass->execute();

		$_SESSION['class_deleted']=true;

		}catch(PDOException $e){
			$_SESSION['class_has_students'] = true;
		}


	}//End of Deleting a Class

	public function getModulesPerClass($modules_id){
		$getModulesPerClass = $this->dbCon->PREPARE("SELECT modules.id as id, modules.name as name
		 FROM classes_has_modules INNER JOIN classes ON(classes_has_modules.classes_id=classes.id) INNER JOIN modules ON(classes_has_modules.modules_id=modules.id) WHERE classes_has_modules.classes_id=?");
		$getModulesPerClass->bindParam(1,$modules_id);
		$getModulesPerClass->execute();
		
		if($getModulesPerClass->rowCount()>0){
			$rows = $getModulesPerClass->fetchAll();
			
			return $rows;
		}
	}//End of getting Modules


	public function deleteModule($class_id, $module_id){
		$deleteModule = $this->dbCon->PREPARE("DELETE FROM classes_has_modules WHERE classes_id=? AND modules_id=?");
		$deleteModule->bindParam(1,$class_id);
		$deleteModule->bindParam(2,$module_id);
		$deleteModule->execute();

		$deleteSpecificModule = $this->dbCon->PREPARE("DELETE FROM modules WHERE id=?");
		$deleteSpecificModule->bindParam(1,$module_id);
		$deleteSpecificModule->execute();

		$_SESSION['module_deleted']=true;


	}//End of Deleting Modules

	public function getSemesters(){
		$getSemesters = $this->dbCon->PREPARE("SELECT id, name
		 FROM semester");
		//$getSemesters->bindParam(1,$status);
		$getSemesters->execute();
		
		if($getSemesters->rowCount()>0){
			$rows = $getSemesters->fetchAll();
			
			return $rows;
		}
	}//End of getting Semesters
	

	public function updateCurrentSettings($old_id, $old_year, $old_semester_id, $year, $semester_id){
		$UpdateOldSettings = $this->dbCon->prepare("INSERT INTO settings_old (year, semester_id) 
				VALUES (:year, :semester_id)" );
				$UpdateOldSettings->execute(array(
					  ':year'=>($old_year),
					  ':semester_id'=>($old_semester_id)
					  ));

		$updateCurrentSettings = $this->dbCon->prepare("UPDATE settings SET year=? , semester_id=? WHERE id=?" );
		$updateCurrentSettings->bindParam(1,$year);
		$updateCurrentSettings->bindParam(2,$semester_id);
		$updateCurrentSettings->bindParam(3,$old_id);
		$updateCurrentSettings->execute();

		$_SESSION['settings_updated']=true;


	}//End of Updating Current Settings



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


	public function checkPassword(){	
				$checkPassword = $this->dbCon->prepare("SELECT first_login FROM users WHERE username=?" );
				$checkPassword->bindParam(1, $_SESSION['user']['username']);
				$checkPassword->execute();

				if($checkPassword->rowCount() == 1){
				$row = $checkPassword -> fetch();

				$first_login = trim($row['first_login']);

				if ($first_login == 0) {
					header("location: change-password.php");
				}
				
				

			}
		
	}//End of check Password

	
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


	public function countAllTeachers(){
		//get all teachers
		try{
			$countAllTeachers = $this->dbCon->prepare("SELECT count(id) as teacher FROM teachers");
			$countAllTeachers->execute();
			if($countAllTeachers->rowCount()>0){
				$row = $countAllTeachers->fetch();
				return $row;
			}else{
				return null;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}


	} //end of Counting all teachers


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

	public function changePassword($username, $password){

		try{
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$changePassword = $this->dbCon->prepare("UPDATE users SET password =? WHERE username=?");
			$changePassword->bindparam(1, $hashed_password);
			$changePassword->bindparam(2, $username);
			$changePassword->execute();

			$_SESSION['password_updated'] =true;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}//End of updating a users password

	//Update Password
	public function updatePassword($new_password){
		$password = password_hash($new_password, PASSWORD_DEFAULT)."\n";
		$first_login = 1;
		$updatePassword =$this->dbCon->PREPARE("UPDATE users SET password =? WHERE username=? ");
		$updatePassword->bindParam(1,$password);
		$updatePassword->bindParam(2,$_SESSION['user']['username']);
		$updatePassword->execute();

		$updateFirstLogin =$this->dbCon->PREPARE("UPDATE users SET first_login =? WHERE username=? ");
		$updateFirstLogin->bindParam(1,$first_login);
		$updateFirstLogin->bindParam(2,$_SESSION['user']['username']);
		$updateFirstLogin->execute();


		$_SESSION['password_updated']= true;
				
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


	public function getSpecificStudent($student_no){
		$getSpecificStudent = $this->dbCon->Prepare("SELECT student_no, phone, nationality, dob, gender, date_added, classes.name as class_name, email, status, CONCAT(firstname,' ',lastname) as name
		FROM students INNER JOIN classes ON(students.classes_id=classes.id) WHERE student_no=? ORDER BY date_added DESC");
		$getSpecificStudent->bindparam(1, $student_no);
		$getSpecificStudent->execute();
		
		if($getSpecificStudent->rowCount()>0){
			$row = $getSpecificStudent->fetch();
			return $row;
		}
	} //end of getting specific Student


	public function deleteStudent($id){

		$deleteStudent =$this->dbCon->PREPARE("DELETE FROM students WHERE student_no=?");
		$deleteStudent->bindParam(1,$id);
		$deleteStudent->execute();

		$deleteStudentUser =$this->dbCon->PREPARE("DELETE FROM users WHERE username=?");
		$deleteStudentUser->bindParam(1,$id);
		$deleteStudentUser->execute();

		$_SESSION['student-deleted']=true;
		
	}//End of deleting Student


	public function getStudentClass(){	
				$getStudentClass = $this->dbCon->prepare("SELECT classes_id FROM students WHERE student_no=?" );
				$getStudentClass->bindParam(1, $_SESSION['user']['username']);
				$getStudentClass->execute();

				if($getStudentClass->rowCount()>0){
				$row = $getStudentClass -> fetch();

				return $row;

			}	
	}//End og getting Student Class

	public function getSpecificStudentClass($id){	
				$getStudentClass = $this->dbCon->prepare("SELECT classes_id, name, CONCAT(firstname, ' ', lastname) as student_name FROM students INNER JOIN classes ON(students.classes_id=classes.id) WHERE student_no=?" );
				$getStudentClass->bindParam(1, $id);
				$getStudentClass->execute();

				if($getStudentClass->rowCount()>0){
				$row = $getStudentClass -> fetch();

				return $row;


			}	
	}//End og getting Specific Student Class


	public function adminUpdateGrades($student_no, $grade, $grade_id){
		$adminUpdateGrades = $this->dbCon->PREPARE("UPDATE grades SET grade =? WHERE students_student_no=? AND id=? ");
		$adminUpdateGrades->bindParam(1,$grade);
		$adminUpdateGrades->bindParam(2,$student_no);
		$adminUpdateGrades->bindParam(3,$grade_id);
		$adminUpdateGrades->execute();

		$_SESSION['grade_updated'] = true;
	}



	public function updateStudentClass($class_id, $student_no){
		$updateStudentClass = $this->dbCon->PREPARE("UPDATE students SET classes_id =? WHERE student_no=?");
		$updateStudentClass->bindParam(1,$class_id);
		$updateStudentClass->bindParam(2,$student_no);
		$updateStudentClass->execute();

		$_SESSION['class_updated'] = true;
	}



	public function getAllModulesPerStudent($classes_id){	
				$getAllModulesPerStudent = $this->dbCon->prepare("SELECT modules_id, modules.name as module_name FROM classes_has_modules INNER JOIN modules ON(classes_has_modules.modules_id=modules.id) WHERE classes_id=?" );
				$getAllModulesPerStudent->bindParam(1, $classes_id);
				$getAllModulesPerStudent->execute();

				if($getAllModulesPerStudent->rowCount()>0){
				$rows = $getAllModulesPerStudent -> fetchAll();

				return $rows;

			}	
	}//End og getting all Modules per Student


	public function getAllStudentsGrades($year, $semester_id, $classes_id){
		$status = 1;
		$checkFeesBalance = $this->dbCon->PREPARE("SELECT students_student_no FROM fees_balances WHERE students_student_no=? AND status =? " );

		$checkFeesBalance->bindParam(1, $_SESSION['user']['username']);
		$checkFeesBalance->bindParam(2, $status);
		$checkFeesBalance->execute();

		if($checkFeesBalance->rowCount() >= 1){
			$_SESSION['balance_found'] = true;
		} else{

		$_SESSION['no_balance'] = true;
		$getAllStudentsGrades = $this->dbCon->Prepare("SELECT students.student_no as student_no, grade, comments, date_recorded, classes.name as class_name, modules.name as module_name
		FROM grades INNER JOIN students ON(grades.students_student_no=students.student_no) INNER JOIN classes ON(students.classes_id=classes.id) INNER JOIN modules ON(grades.modules_id=modules.id) WHERE grades.classes_id=? AND grades.year=? AND grades.semester_id =? AND grades.students_student_no =? ORDER BY date_added DESC");
		$getAllStudentsGrades->bindParam(1, $classes_id);
		$getAllStudentsGrades->bindParam(2, $year);
		$getAllStudentsGrades->bindParam(3, $semester_id);
		$getAllStudentsGrades->bindParam(4, $_SESSION['user']['username']);

		$getAllStudentsGrades->execute();
		
		if($getAllStudentsGrades->rowCount()>0){
			$rows = $getAllStudentsGrades->fetchAll();
			return $rows;
		}
		}

	} //end of getting All Students Grades


	public function getAllGrades($year, $modules_id, $class_id, $semester_id){
		$status = 1;
		$_SESSION['no_balance'] = true;
		$getAllGrades = $this->dbCon->Prepare("SELECT grades.id as id, comments, CONCAT(students.firstname,' ',students.lastname) as student_name, year, IF(semester_id = 1,'First Semester', 'Second Semester') as semester, students.student_no as student_no, grade, date_recorded, classes.name as class_name, modules.name as module_name
		FROM grades INNER JOIN students ON(grades.students_student_no=students.student_no) INNER JOIN classes ON(students.classes_id=classes.id) INNER JOIN modules ON(grades.modules_id=modules.id) WHERE grades.classes_id=? AND grades.year=? AND grades.semester_id =? AND grades.modules_id =? ORDER BY date_recorded DESC");
		$getAllGrades->bindParam(1, $class_id);
		$getAllGrades->bindParam(2, $year);
		$getAllGrades->bindParam(3, $semester_id);
		$getAllGrades->bindParam(4, $modules_id);

		$getAllGrades->execute();
		
		if($getAllGrades->rowCount()>0){
			$rows = $getAllGrades->fetchAll();
			return $rows;
		}
	} //end of getting All Students Grades

	public function getFeesBalancePerStudent(){
		$status = 1;
		$getFeesBalancePerStudent = $this->dbCon->Prepare("SELECT COUNT(students_student_no) as student_no, balance, remarks, date_recorded, status FROM fees_balances WHERE status =? AND students_student_no =? ");
		$getFeesBalancePerStudent->bindParam(1,$status);
		$getFeesBalancePerStudent->bindParam(2,$_SESSION['user']['username']);
		$getFeesBalancePerStudent->execute();
		
		if($getFeesBalancePerStudent->rowCount()>0){
			$row = $getFeesBalancePerStudent->fetch();
			return $row;
		}
	} //end of getting Students with Fees Balances



		public function getAllFeesBalancesPerStudent(){
		$getAllFeesBalancesPerStudent = $this->dbCon->Prepare("SELECT students_student_no, fees_balances.status as status, balance, remarks, date_recorded, CONCAT(students.firstname,' ',students.lastname) as name
		FROM fees_balances INNER JOIN students ON(fees_balances.students_student_no=students.student_no) WHERE fees_balances.students_student_no =? ORDER BY date_recorded DESC");
		$getAllFeesBalancesPerStudent->bindParam(1,$_SESSION['user']['username']);
		$getAllFeesBalancesPerStudent->execute();
		
		if($getAllFeesBalancesPerStudent->rowCount()>0){
			$rows = $getAllFeesBalancesPerStudent->fetchAll();
			return $rows;
		}
	} //end of getting Students with Fees Balances


	public function getUnreadNotificationPerStudent(){
		$status = 0;
		$getUnreadNotificationPerStudent = $this->dbCon->Prepare("SELECT id, notification, date_sent, username, status
		FROM notifications WHERE students_student_no =? AND status =? ORDER BY date_sent DESC");
		$getUnreadNotificationPerStudent->bindParam(1, $_SESSION['user']['username']);
		$getUnreadNotificationPerStudent->bindParam(2, $status);
		$getUnreadNotificationPerStudent->execute();
		
		if($getUnreadNotificationPerStudent->rowCount()>0){
			$rows = $getUnreadNotificationPerStudent->fetchAll();
			return $rows;
		}
	} //End of getting Notifications


	public function getNotificationPerStudent(){
		$getNotificationPerStudent = $this->dbCon->Prepare("SELECT id, notification, date_sent, username, status
		FROM notifications WHERE students_student_no =? ORDER BY date_sent DESC");
		$getNotificationPerStudent->bindParam(1, $_SESSION['user']['username']);
		$getNotificationPerStudent->execute();
		
		if($getNotificationPerStudent->rowCount()>0){
			$rows = $getNotificationPerStudent->fetchAll();
			return $rows;
		}
	} //End of getting Notifications Per Student



	public function getMessagesPerStudent(){
		$getMessagesPerStudent = $this->dbCon->Prepare("SELECT id, subject, message, date_sent, username, status
		FROM messages WHERE students_student_no =? ORDER BY date_sent DESC");
		$getMessagesPerStudent->bindParam(1, $_SESSION['user']['username']);
		$getMessagesPerStudent->execute();
		
		if($getMessagesPerStudent->rowCount()>0){
			$rows = $getMessagesPerStudent->fetchAll();
			return $rows;
		}
	} //End of getting Messages per Student


	public function getUnreadMessagesPerStudent(){
		$status = 0;
		$getUnreadMessagesPerStudent = $this->dbCon->Prepare("SELECT id, subject, message, date_sent, username, status
		FROM messages WHERE students_student_no =? AND status =? ORDER BY date_sent DESC");
		$getUnreadMessagesPerStudent->bindParam(1, $_SESSION['user']['username']);
		$getUnreadMessagesPerStudent->bindParam(2, $status);
		$getUnreadMessagesPerStudent->execute();
		
		if($getUnreadMessagesPerStudent->rowCount()>0){
			$rows = $getUnreadMessagesPerStudent->fetchAll();
			return $rows;
		}
	} //End of getting Unread Messages per Student


	public function countAllUnreadMessages(){
		$status = 0;
		$countAllUnreadMessages = $this->dbCon->Prepare("SELECT COUNT(message) as message FROM messages WHERE status =? AND students_student_no =? ");
		$countAllUnreadMessages->bindParam(1,$status);
		$countAllUnreadMessages->bindParam(2,$_SESSION['user']['username']);
		$countAllUnreadMessages->execute();
		
		if($countAllUnreadMessages->rowCount()>0){
			$row = $countAllUnreadMessages->fetch();
			return $row;
		}
	} //End of counting all unread Messages per student


	public function markMessageRead($id){
		$status =1;// Read Status
		$markMessageRead = $this->dbCon->PREPARE("UPDATE messages SET status =? WHERE id=? AND students_student_no =? ");
		$markMessageRead->bindParam(1,$status);
		$markMessageRead->bindParam(2,$id);
		$markMessageRead->bindParam(3,$_SESSION['user']['username']);
		$markMessageRead->execute();

		$_SESSION['message_read'] = true;
	} //End of marking a message as read


	public function countAllUnreadNotifications(){
		$status = 0;
		$countAllUnreadNotifications = $this->dbCon->Prepare("SELECT COUNT(notification) as noti FROM notifications WHERE status =? AND students_student_no =? ");
		$countAllUnreadNotifications->bindParam(1,$status);
		$countAllUnreadNotifications->bindParam(2,$_SESSION['user']['username']);
		$countAllUnreadNotifications->execute();
		
		if($countAllUnreadNotifications->rowCount()>0){
			$row = $countAllUnreadNotifications->fetch();
			return $row;
		}
	} //End of counting all unread notifications per student



	public function markNotificationRead($id){
		$status =1;// Read Status
		$markNotificationRead = $this->dbCon->PREPARE("UPDATE notifications SET status =? WHERE id=? AND students_student_no =? ");
		$markNotificationRead->bindParam(1,$status);
		$markNotificationRead->bindParam(2,$id);
		$markNotificationRead->bindParam(3,$_SESSION['user']['username']);
		$markNotificationRead->execute();

		$_SESSION['notification_read'] = true;
	} //End of marking a message as read




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



  public function addAnnouncement($title, $description){
  	$date = DATE("Y-m-d h:i");
				$addAnnouncement = $this->dbCon->prepare("INSERT INTO announcements (title, description, date_added, username) 
				VALUES (:title, :description, :date_added, :username)" );
				$addAnnouncement->execute(array(
						  ':title'=>($title),
						  ':description'=>($description),
						  ':date_added'=>($date),
						  ':username'=>($_SESSION['user']['username'])
						  ));



		  $_SESSION['announcement_added']=true;
		

	} //end of Adding Announcements


  public function addTeamMember($name, $position, $description, $picture){
  	$date = DATE("Y-m-d h:i");
				$addTeamMember = $this->dbCon->prepare("INSERT INTO team (name, position, description, picture, date_added) 
				VALUES (:name, :position, :description, :picture, :date_added)" );
				$addTeamMember->execute(array(
						  ':name'=>($name),
						  ':position'=>($position),
						  ':description'=>($description),
						  ':picture'=>($picture),
						  ':date_added'=>($date)
						  ));



		  $_SESSION['member_added']=true;
		

	} //end of Adding Employee/Team member



	public function getTeamMember(){
		$getTeamMember = $this->dbCon->Prepare("SELECT id, name, position, description, date_added, picture
		FROM team ORDER BY date_added DESC");
		$getTeamMember->execute();
		
		if($getTeamMember->rowCount()>0){
			$rows = $getTeamMember->fetchAll();
			return $rows;
		}
	} //End of getting Team Members


	  public function editTeamMember($id, $name, $position, $description){	
				$editTeamMember = $this->dbCon->prepare("UPDATE team SET name=? , position=?, description=? WHERE id=?" );
				$editTeamMember->bindParam(1,$name);
				$editTeamMember->bindParam(2,$position);
				$editTeamMember->bindParam(3,$description);
				$editTeamMember->bindParam(4,$id);
				$editTeamMember->execute();

		  $_SESSION['member_edited']=true;

	}// End of Editing a Team Member


	public function deleteMember($id, $picture){
			unlink($picture);	
				$deleteMember = $this->dbCon->prepare("DELETE FROM team WHERE id=?" );
				$deleteMember->bindParam(1,$id);
				$deleteMember->execute();

		  $_SESSION['member_deleted']=true;

	}// End of Deleting a Member


	  public function editAnnouncement($id, $title, $description){	
				$editAnnouncement = $this->dbCon->prepare("UPDATE announcements SET title=? ,description=? WHERE id=?" );
				$editAnnouncement->bindParam(1,$title);
				$editAnnouncement->bindParam(2,$description);
				$editAnnouncement->bindParam(3,$id);
				$editAnnouncement->execute();

		  $_SESSION['announcement_edited']=true;

	}// End of Editing an Announcement


	public function deleteAnnouncement($id){	
				$deleteAnnouncement = $this->dbCon->prepare("DELETE FROM announcements WHERE id=?" );
				$deleteAnnouncement->bindParam(1,$id);
				$deleteAnnouncement->execute();

		  $_SESSION['announcement_deleted']=true;

	}// End of Deleting an Announcement



	public function getAnnouncements(){
		$getAnnouncements = $this->dbCon->Prepare("SELECT id, title, description, date_added, username 
		FROM announcements ORDER BY date_added DESC");
		$getAnnouncements->execute();
		
		if($getAnnouncements->rowCount()>0){
			$rows = $getAnnouncements->fetchAll();
			return $rows;
		}
	} //End of getting Announcements



	public function sendNotification($notification, $student_no){
  	$date = DATE("Y-m-d h:i");

	    if(count($student_no)>0){
 			foreach($student_no as $students_student_no){

		 	$sendNotification = $this->dbCon->prepare("INSERT INTO notifications (notification, students_student_no, date_sent, username) 
			VALUES (:notification, :students_student_no, :date_sent, :username)" );
			$sendNotification->execute(array(
					  ':notification'=>($notification),
					  ':students_student_no'=>($students_student_no),
					  ':date_sent'=>($date),
					  ':username'=>($_SESSION['user']['username'])
					  ));

		  	$_SESSION['notification_sent']=true;
		            
		     	   }
		      }else {
		        $_SESSION['failed'] = true;
		      }
		

	} //End of Sending Notifications


	public function getAllNotifications(){
		$getAllNotifications = $this->dbCon->Prepare("SELECT DISTINCT(notification) id, notification, date_sent, username 
		FROM notifications ORDER BY date_sent DESC");
		$getAllNotifications->execute();
		
		if($getAllNotifications->rowCount()>0){
			$rows = $getAllNotifications->fetchAll();
			return $rows;
		}
	} //End of getting Notifications


	public function deleteNotification($notification){	
				$deleteNotification = $this->dbCon->prepare("DELETE FROM notifications WHERE notification=?" );
				$deleteNotification->bindParam(1,$notification);
				$deleteNotification->execute();

		  $_SESSION['notification_deleted']=true;

	}// End of Deleting a Notification


	public function sendMessage($subject, $message, $student_no){
  	$date = DATE("Y-m-d h:i");

		 	$sendMessage = $this->dbCon->prepare("INSERT INTO messages (subject, message, students_student_no, date_sent, username) 
			VALUES (:subject, :message, :students_student_no, :date_sent, :username)" );
			$sendMessage->execute(array(
					  ':subject'=>($subject),
					  ':message'=>($message),
					  ':students_student_no'=>($student_no),
					  ':date_sent'=>($date),
					  ':username'=>($_SESSION['user']['username'])
					  ));

		  	$_SESSION['message_sent']=true;
		            

	} //End of Sending a Message


	public function getAllMessages(){
		$getAllMessages = $this->dbCon->Prepare("SELECT students_student_no as student_no, id, subject, message, date_sent, username, status
		FROM messages ORDER BY date_sent DESC");
		//$getAllMessages->bindParam(1, $_SESSION['user']['username']);
		$getAllMessages->execute();
		
		if($getAllMessages->rowCount()>0){
			$rows = $getAllMessages->fetchAll();
			return $rows;
		}
	} //End of getting All Messages



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
		$getStudentsBalances = $this->dbCon->Prepare("SELECT fees_balances.id as id, students_student_no, balance, remarks, date_recorded, CONCAT(students.firstname,' ',students.lastname) as name, classes.name as class
		FROM fees_balances INNER JOIN students ON(fees_balances.students_student_no=students.student_no) INNER JOIN classes ON(students.classes_id=classes.id) WHERE fees_balances.status =? ORDER BY date_recorded DESC");
		$getStudentsBalances->bindParam(1,$status);
		$getStudentsBalances->execute();
		
		if($getStudentsBalances->rowCount()>0){
			$rows = $getStudentsBalances->fetchAll();
			return $rows;
		}
	} //end of getting Students with Fees Balances



	public function countAllStudentFeesBalances(){
		$status = 1;
		$countAllStudentFeesBalances = $this->dbCon->Prepare("SELECT COUNT(students_student_no) as student_no FROM fees_balances WHERE status =? ");
		$countAllStudentFeesBalances->bindParam(1,$status);
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


	public function addBalanceInstallment($amount, $fees_id){
		$addBalanceInstallment = $this->dbCon->Prepare("UPDATE fees_balances SET balance = balance - $amount WHERE id =? ");
		$addBalanceInstallment->bindParam(1, $fees_id);
		$addBalanceInstallment->execute();

		$_SESSION['imstallment_added'] = true;
		
	} //End of adding installment to Fees Balance


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



  public function recordGrade($grade, $student_no, $class_id, $year, $semester_id, $modules_id, $comment){
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

				$iterator = new MultipleIterator();
				$iterator->attachIterator(new ArrayIterator($student_no));
				$iterator->attachIterator(new ArrayIterator($grade));
				$iterator->attachIterator(new ArrayIterator($comment));
				foreach ($iterator as $current) {
				    $student = $current[0];
				    $grades  = $current[1];
				    $comments  = $current[2];

					$recordGrade = $this->dbCon->prepare("INSERT INTO grades (students_student_no, classes_id, grade, year, semester_id, date_recorded, modules_id, comments) 
					VALUES (:students_student_no, :classes_id, :grade, :year, :semester_id, :date_recorded, :modules_id, :comments)" );
					$recordGrade->execute(array(
							  ':students_student_no'=>($student),
							  ':classes_id'=>($class_id),
							  ':grade'=>($grades),
							  ':year'=>($year),
							  ':semester_id'=>($semester_id),
							  ':date_recorded'=>($date),
							  ':modules_id'=>($modules_id),
							  ':comments'=>($comments)
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


	public function getMaterialsPerClassModule($classes_id, $modules_id, $year, $semester_id){
		$getMaterialsPerClassModule = $this->dbCon->Prepare("SELECT title, material, modules.name as module_name, classes.name as class_name, year, semester_id, date_added FROM materials INNER JOIN modules ON(materials.modules_id=modules.id) INNER JOIN classes ON(materials.classes_id=classes.id) WHERE classes_id=? AND modules_id=? AND materials.year=? AND materials.semester_id=? ORDER BY date_added DESC");
		$getMaterialsPerClassModule->bindParam(1, $classes_id);
		$getMaterialsPerClassModule->bindParam(2, $modules_id);
		$getMaterialsPerClassModule->bindParam(3, $year);
		$getMaterialsPerClassModule->bindParam(4, $semester_id);
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
