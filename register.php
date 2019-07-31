s<?php 
	include 'inc/header.php';
	include 'lib/User.php';
?>
<?php
 $user = new User(); 

 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
 	$userregi = $user->userregistration($_POST);
 }
?>
	<section class="panel panel-default">
		<div class="container">
		<div class="panel-heading">
			<h2>User Registration</h2>
		</div>
			<div class="panel-body">
				<div class="row">
				<div class="offset-3"></div>
				<div class="col-lg-7">
					<?php 
					if (isset($userregi)) {
						echo $userregi;
					}
					?>
					<form action="" method="POST">
						<div class="form-group">
							<label for="name">Your Name</label>
							<input type="text" id="name" name="name" class="form-control">
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" id="username" name="username" class="form-control" >
						</div>
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="text" id="email" name="email" class="form-control" >
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" id="password" name="password" class="form-control">
						</div>
						<button type="submit" name="register" class="btn btn-success">Submit</button>
						<span class="float-right">All Ready Register ? <a href="login.php" class="btn btn-info">LogIn</a></span>
					</form>

				</div>
				<div class="offset-2"></div>
			</div>
		</div>
		</div>
	</section>
<?php include 'inc/footer.php';?>