<?php 
	include 'lib/User.php';
	include 'inc/header.php';
	
	Session::checksession();
	$user = new User();
?>

	<section class="panel panel-default">
		<div class="container">
			<div class="panel-heading">
				<?php
					$loginmsg = Session::get("loginmsg");
					if (isset($loginmsg)) {
						echo $loginmsg;
					}
					Session::set("loginmsg", NULL);
				?>
				<h2>User list <span class="float-right">Welcome! <strong>
					<?php 
					$name = Session::get("username"); 
					if (isset($name)) {
						echo $name;
					}
					?>	
					</strong></span></h2>
			</div>
		<div class="panel-body">
			<div class="row">
				<table class="table table-striped">
					<tr>
						<th width="20%">Serial</th>
						<th width="20%">Name of Person</th>
						<th width="20%">Username</th>
						<th width="20%">E-Mail</th>
						<th width="20%">Action</th>
					</tr>
					<?php 
					$user = new User();
					$userdata = $user->getuserdata();
					if ($userdata) {
						$i =0;
						foreach ($userdata as $data) {
							$i++;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $data['name']; ?></td>
						<td><?php echo $data['username']; ?></td>
						<td><?php echo $data['email']; ?></td>
						<td><a class="btn btn-primary" href="profile.php?id=<?php echo $data['id']; ?>">View</a></td>
					</tr>
					<?php 	}
					}else{?>
					<tr>
						<td colspan="5"><h3>Data Not Found</h3></td>
					</tr>
					<?php }?>
				</table>
			</div>
		</div>
		</div>
	</section>
<?php include 'inc/footer.php';?>