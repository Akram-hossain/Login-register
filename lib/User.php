<?php 
include_once 'Session.php';
include 'Database.php';

	class User{
		private $db;
		public function __construct()
		{
			$this->db = new Database();
		}

		public function userregistration($data){
			$name     = $data['name'];
			$username = $data['username'];
			$email    = $data['email'];
			$pass     = $data['password'];
			$password = md5($pass);
			$chk_mail = $this->emailcheck($email);

			if ($name == "" OR $username == "" OR $email == "" OR $password =="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Filed Must not be Empty</div>";
				return $msg;
			}

			if (strlen($username) < 3) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>User Name is too Short</div>";
				return $msg;
			}elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>User Name must contain alphanumeric, underscore,dashes</div>";
				return $msg;
			}

			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Email Address is not valid</div>";
				return $msg;
			}
			if (strlen($pass) < 5) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Password Must be Atlist Five Charecter</div>";
				return $msg;
			}

			if ($chk_mail == true){
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Email Address is Already Exist</div>";
				return $msg;
			}

			$sql = 'INSERT INTO tbl_user(name,username,email,password) VALUES(:name,:username,:email,:password)';
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':name', $name);
			$query->bindValue(':username', $username);
			$query->bindValue(':email', $email);
			$query->bindValue(':password', $password);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Success ! </strong>Thank you, You Have been Registered</div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Sorry There is Problem to Inserting Data</div>";
				return $msg;
			}
		}

		public function emailcheck($email){
			$sql = 'SELECT email from tbl_user WHERE email=:email';
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email', $email);
			$query->execute();
			if ($query->rowCount()> 0 ) {
				return true;
			}else{
				return false;
			}
		}

		public function getloginuser($email,$password){
			$sql = 'SELECT * from tbl_user WHERE email=:email AND password=:password LIMIT 1';
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email', $email);
			$query->bindValue(':password', $password);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}

		public function userlogin($data){
			$email    = $data['email'];
			$pass     = $data['password'];
			$password = md5($pass);
			$chk_mail = $this->emailcheck($email);

			if ($email == "" OR $password =="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Filed Must not be Empty</div>";
				return $msg;
			}

			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Email Address is not valid</div>";
				return $msg;
			}
			if ($chk_mail == false){
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Email Address is not Exist</div>";
				return $msg;
			}

			$result = $this->getloginuser($email,$password);
			if ($result) {
				Session::init();
				Session::set("login", true);
				Session::set("id", $result->id);
				Session::set("name", $result->name);
				Session::set("username", $result->username);
				Session::set("loginmsg", "<div class='alert alert-success'><strong>Success ! </strong>You are loggedin</div>");
				header("Location: index.php");
			}else{
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Data not Found</div>";
				return $msg;
			}

		}
		public function getuserdata(){
			$sql = 'SELECT * from tbl_user ORDER BY id DESC';
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}

		public function getuserbyid($userid){
			$sql = 'SELECT * from tbl_user WHERE id =:id LIMIT 1';
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':id', $userid);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}
		public function updateuser($id,$data){
			$name     = $data['name'];
			$username = $data['username'];
			$email    = $data['email'];
			

			if ($name == "" OR $username == "" OR $email == "") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Filed Must not be Empty</div>";
				return $msg;
			}

			if (strlen($username) < 3) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>User Name is too Short</div>";
				return $msg;
			}elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>User Name must contain alphanumeric, underscore,dashes</div>";
				return $msg;
			}

			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Email Address is not valid</div>";
				return $msg;
			}

			$sql = 'UPDATE tbl_user set name=:name,username=:username,email=:email WHERE id=:id';
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':name', $name);
			$query->bindValue(':username', $username);
			$query->bindValue(':email', $email);
			$query->bindValue(':id', $id);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Success ! </strong>Thank you, Userdata Updated Successfuly</div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Sorry There is Problem a to Updting Userdata</div>";
				return $msg;
			}
		}
		private function checkpassword($old_pass,$id){
			$password = md5($old_pass);
			$sql = 'SELECT password from tbl_user WHERE id=:id AND password=:password ';
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':id', $id);
			$query->bindValue(':password', $password);
			$query->execute();
			if ($query->rowCount()> 0 ) {
				return true;
			}else{
				return false;
			}

		}
		public function updatepass($id,$data){

			$old_pass = $data['old_pass'];
			$new_pass = $data['password'];
			$chk_pass = $this->checkpassword($old_pass,$id);
			if ($old_pass == "" OR $new_pass == "") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Filed Must not be Empty</div>";
				return $msg;
			}

			if ($chk_pass == false) {
			$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Old Password is Not Match</div>";
				return $msg;
			}
			if (strlen($new_pass) < 5) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>New Password Must be Atlist Five Charecter</div>";
				return $msg;
			}

			$password = md5($new_pass);

			$sql = 'UPDATE tbl_user set password=:password WHERE id=:id';
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':password', $password);
			$query->bindValue(':id', $id);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Success ! </strong>Thank you, Password Updated Successfuly</div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Sorry Failed to Update Password</div>";
				return $msg;
			}
		}
		public function delete($id){
			$sql = "DELETE FROM tbl_user WHERE id=:id";
			$query = $this->db->pdo->prepare($sql);
			$query->bindParam(':id',$id);
			return $query->execute();
		}
		
	}
?>