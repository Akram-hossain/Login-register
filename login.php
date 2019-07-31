<?php 
	include 'inc/header.php';
	include 'lib/User.php';
	Session::checklogin();
?>
<?php
 $user = new User(); 

 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
 	$userlogin = $user->userlogin($_POST);
 }
?>
	<section class="panel panel-default">
		<div class="container">
		<div class="panel-heading">
			<h2>User Login</h2>
		</div>
			<div class="panel-body">
				<div class="row">
				<div class="offset-3"></div>
				<div class="col-lg-6">
					<?php 
					if (isset($userlogin)) {
						echo $userlogin;
					}
					?>
					<form action="" method="POST">
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="text" id="email" name="email" class="form-control" >
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" id="password" name="password" class="form-control">
						</div>
						<button type="submit" name="login" class="btn btn-success">Login</button>
						<span class="float-right">Did not Register Yet ? <a href="register.php" class="btn btn-info">SignUp</a></span>
					</form>
				</div>
				<div class="offset-3"></div>
			</div>
		</div>
		</div>
	</section>
<?php include 'inc/footer.php';?>