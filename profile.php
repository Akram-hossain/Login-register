<?php 
	include 'lib/User.php';
	include 'inc/header.php';
	Session::checksession();
?>
<?php 
	if (isset($_GET['id'])) {
		$userid = (int)$_GET['id'];
	}
	$user = new User();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
 	$updateusr = $user->updateuser($userid,$_POST);
 }
?>
	<section class="panel panel-default">
		<div class="container">
			<div class="panel-heading">
				<h2>User Profile <span class="float-right"><a class="btn btn-primary"href="index.php">Back</a></span></h2>
			</div>

			<div class="panel-body">
				<div class="row">
				<div class="offset-2"></div>
				<div class="col-lg-8">

		<?php if (isset($updateusr)) {
			echo $updateusr;
		} ?>
				<?php 
					$userdata = $user->getuserbyid($userid);
					if ($userdata) {
				?>
					<form action="" method="POST">
						<div class="form-group">
							<label for="name">Your Name</label>
							<input type="text" id="name" name="name" class="form-control" value="<?php echo $userdata->name; ?>">
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" id="username" name="username" class="form-control" value="<?php echo $userdata->username; ?>">
						</div>
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="text" id="email" name="email" class="form-control" value="<?php echo $userdata->email; ?>">
						</div>
						<?php 
						$sesionid = Session::get("id");
						if ($sesionid == $userid) {
						 ?>
						 <?php 
						 $sesion = new Session();
							if (isset($_GET['action']) && $_GET['action'] == 'delete' ) {
								$id = (int)$_GET['id'];
								if ($user->delete($id)) {
									$sesion->destroy();
								}
							}
						?>
						<button type="submit" name="update" class="btn btn-success">Update</button>
						<a class="btn btn-info" href="chngepas.php?id=<?php echo $userid; ?>">Password Change</a>
						<a class="btn btn-danger" href="profile.php?action=delete&id=<?php echo $userdata->id; ?>" onClick='return confirm("Are You Sure to Delete Data ?")'>Delete</a>
						<?php } ?>
					</form>
					<?php } ?>
				</div>
				<div class="offset-2"></div>
			</div>
		</div>
		</div>
	</section>
<?php include 'inc/footer.php';?>