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
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Welcome to Campus Voices!</h1>
		<header><a href="logout.php">LOGOUT</a></header>
		<div class="photo-grid">

		<?php
		
		if ($role == 'admin'){
			echo '<a href="adminCourses.php"><div class="photo"><img src="primorska.jpg"></div></a>';
		}else{
			echo '<a href="primorskaHome.php"><div class="photo"><img src="primorska.jpg"></div></a>';
		}
		
		?>
			<a href="error.php"><div class="photo"><img src="ljubljana.png"></div></a>
			<a href="error.php"><div class="photo"><img src="maribor.png"></div></a>
			<a href="error.php"><div class="photo"><img src="gorica.jpeg"></div></a>
		</div>
	</div>
</body>
</html>
