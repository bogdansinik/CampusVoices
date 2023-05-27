<?php

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
$userid = $_SESSION['id'];
$role = $_SESSION['role'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Campus Voices</title>
    <link rel="stylesheet" type="text/css" href="styleWelcomePage.css">
</head>
<body>
	<div class="container">
		<div class="navbar">
		<h1 class="navbar-title">Welcome to Campus Voices</h1>
		<div class="logout-button-container">
		<a href="logout.php" class="logout-button">LOG OUT</a>
		</div>
  </div>

		<div class="grid-container">
			<?php
			
			if ($role == 'admin'){
				echo '<a href="adminCourses.php"><div class="grid-item"><img src="primorska.jpg"></div></a>';
			}else{
				echo '<a href="primorskaHome.php"><div class="grid-item"><img src="primorska.jpg"></div></a>';
			}
			
			?>
			<div class="grid-item">
				<a href="error.php">
					<img src="ljubljana.png">
				</a>
			</div>
			<div class="grid-item" >
				<a href="error.php">
					<img src="maribor.png">
				</a>
			</div>
			<div class="grid-item">
				<a href="error.php">
					<img src="gorica.jpeg">
				</a>
		</div>
  </div>
	</div>
</body>
</html>
