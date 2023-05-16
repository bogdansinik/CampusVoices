
<!-- <!DOCTYPE html>
<html>
<head>
	<title>Accommodation Offers</title>
    <link rel="stylesheet" type="text/css" href="stylePrimorskaAccommodation.css">
</head>
<body>
	<header>
		<h1>University of Primorska Campus Voices</h1>
		<nav>
			<ul>
				<li><a href="primorskaHome.html">Home</a></li>
				<li><a href="primorskaCourses.html">Courses</a></li>
				<li><a href="primorskaAccommodation.php">Accommodation</a></li>
				<li><a href="primorskaFood.php">Food</a></li>
				<li><a href="primorskaProfessors.html">Professors</a></li>
				<li><a href="primorskaFun.html">Fun</a></li>
				<li><a href="login.php">Login</a></li>
			</ul>
		</nav>
	</header>
	<h1>Accommodation Offers</h1>
	<div class="container">
		<div class="offer">
			<img src="flat1.jpg" alt="Flat 1">
			<p>Flat 1: 1-bedroom apartment located in the city center, fully furnished.</p>
		</div>
		<div class="offer">
			<img src="flat2.jpg" alt="Flat 2">
			<p>Flat 2: 2-bedroom apartment located in the suburbs, with a balcony and parking.</p>
		</div>
		<div class="offer">
			<img src="flat3.jpg" alt="Flat 3">
			<p>Flat 3: Studio apartment located near the university, with a kitchenette and air conditioning.</p>
		</div>
		<div class="offer">
			<img src="flat4.jpg" alt="Flat 4">
			<p>Flat 4: 3-bedroom apartment located in a quiet neighborhood, with a garden and barbecue area.</p>
		</div>
	</div>
	<footer>
		<p>&copy; 2023 University of Primorska Campus Voices</p>
	</footer>
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
	<title>Accommodation Offers</title>
    <link rel="stylesheet" type="text/css" href="stylePrimorskaAccommodation.css">
</head>
<body>
	<header>
		<h1>University of Primorska Campus Voices - Accommodation</h1>
		<nav>
			<ul>
				<li><a href="primorskaHome.html">Home</a></li>
				<li><a href="primorskaCourses.html">Courses</a></li>
				<li><a href="primorskaAccommodation.php">Accommodation</a></li>
				<li><a href="primorskaFood.php">Food</a></li>
				<li><a href="primorskaProfessors.html">Professors</a></li>
				<li><a href="primorskaFun.html">Fun</a></li>
				<li><a href="login.php">Login</a></li>
			</ul>
		</nav>
	</header>
	</body>
</html>

<?php
include "db_conn.php";
// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
$userid = $_SESSION['id'];

// Fetch the accommodations from the database
$query = "SELECT * FROM Accommodation";
$result = mysqli_query($conn, $query);

// Check if there are any accommodations
if (mysqli_num_rows($result) > 0) {
    // Loop through each accommodation and generate the HTML
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
        $city = $row['city'];
        $address = $row['address'];
        $type = $row['type'];
        $images = $row['images'];

        // Generate the HTML for each accommodation
		echo '<div class="offer">';
		echo '<img src="' . $images . '" alt="' . $name . '">';
		echo '<p>' . $address . ': ' . $description . '</p>';
		echo '</div>';
	}
} else {
	// No accommodations found
	echo '<p>No accommodations available at the moment.</p>';
}

// Close the database connection
mysqli_close($conn);
?>


