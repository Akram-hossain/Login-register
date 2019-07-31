<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once $filepath.'/../lib/Session.php';
    Session::init();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login Register System | PHP</title>
		<link rel="stylesheet" type="text/css" href="inc/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="inc/style.css">
		<script type="text/javascript" src="inc/jquery-min.js"></script>
		<script type="text/javascript" src="inc/bootstrap.min.js"></script>
	</head>

    <?php 
    if (isset($_GET['action']) && $_GET['action'] =="logout") {
        Session::destroy();
    }
    ?>

	<body>
	<section id="nav_part" class="nav_part">
        <div class="container">
            
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="index.php">
                    <h4>Login Register System PHP &amp; PDO</h4>
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <?php 
                            $id = Session::get('id');
                             $userlogin = Session::get('login');
                             if ($userlogin == true) {
                             ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php?id=<?php echo $id; ?>">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=logout">Logout</a>
                        </li>
                   <?php } else{ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>

        </div>
    </section>
