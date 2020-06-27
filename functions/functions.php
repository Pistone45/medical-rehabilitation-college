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



	} //end adding users



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
			$getUsers = $this->dbCon->prepare("SELECT username, firstname, middlename, lastname, status, date_added, roles_id FROM users " );
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



  public function addStudent($image_Path, $firstname, $lastname, $email, $nationality, $student_no, $password, $dob, $gender){
	  $date = DATE("Y-m-d h:i");
		//check if the Student is already in the system before adding new user
		$checkUser = $this->dbCon->prepare("SELECT student_no from students where student_no=?" );
		$checkUser->bindValue(1, $student_no);
		$checkUser->execute();
		if($checkUser->rowCount() ==1){
			//Student already in the system
			$_SESSION['student_found']= true;
		}else{
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$status = 1;
				$roles_id = 3;
				$addStudent = $this->dbCon->prepare("INSERT INTO students (student_no, firstname,email, lastname,dob,gender,date_added, status, picture, nationality) 
				VALUES (:student_no, :firstname,:email, :lastname,:dob,:gender,:date_added, :status, :picture, :nationality)" );
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
						  ':nationality'=>($nationality)
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
			}
		

	} //end adding Student


	public function getStudents(){
		$getStudents = $this->dbCon->Prepare("SELECT student_no, dob, gender, date_added, nationality, email, status, CONCAT(firstname,' ',lastname) as name 
		FROM students ORDER BY date_added DESC");
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



  public function addTeacher($image_Path, $firstname, $lastname, $email, $nationality, $teacher_id, $password, $dob, $gender, $qualification, $experience){
	  $date = DATE("Y-m-d h:i");
		//check if the Teacher is already in the system before adding new user
		$checkUser = $this->dbCon->prepare("SELECT teacher_id from teachers where teacher_id=?" );
		$checkUser->bindValue(1, $teacher_id);
		$checkUser->execute();
		if($checkUser->rowCount() ==1){
			//Teacher already in the system
			$_SESSION['teacher-found']= true;
		}else{
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$status = 1;
				$roles_id = 2;
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


  public function addAccountant($image_Path, $firstname, $lastname, $email, $nationality, $staff_id, $password, $dob, $gender, $qualification, $experience, $phone){
	  $date = DATE("Y-m-d h:i");
		//check if the Teacher is already in the system before adding new user
		$checkUser = $this->dbCon->prepare("SELECT staff_id from accountants where staff_id=?" );
		$checkUser->bindValue(1, $staff_id);
		$checkUser->execute();
		if($checkUser->rowCount() ==1){
			//Accountant already in the system
			$_SESSION['accountant-found']= true;
		}else{
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$status = 1;
				$roles_id = 4;
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
		$getStudentsBalances = $this->dbCon->Prepare("SELECT students_student_no, balance, remarks, date_recorded, CONCAT(students.firstname,' ',students.lastname) as name
		FROM fees_balances INNER JOIN students ON(fees_balances.students_student_no=students.student_no) ORDER BY date_recorded DESC");
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



} //End of class Accountant