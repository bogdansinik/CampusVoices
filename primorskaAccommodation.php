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
				<li><a href="primorskaHome.php">Home</a></li>
				<li><a href="primorskaCourses.php">Courses</a></li>
				<li><a href="primorskaAccommodation.php">Accommodation</a></li>
				<li><a href="primorskaFood.php">Food</a></li>
				<li><a href="primorskaProfessors.php">Professors</a></li>
				<li><a href="primorskaFun.php">Fun</a></li>
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
		// Fetch the reviews for the accommodation
        $reviewsQuery = "SELECT * FROM AccommodationReview WHERE accommodation_id = $id";
        $reviewsResult = mysqli_query($conn, $reviewsQuery);
        
        // Calculate the average rating
        $totalStars = 0;
        $reviewCount = mysqli_num_rows($reviewsResult);
        while ($review = mysqli_fetch_assoc($reviewsResult)) {
            $totalStars += $review['stars'];
        }
        $averageRating = ($reviewCount > 0) ? $totalStars / $reviewCount : 0;

        // Generate the HTML for each accommodation
		echo '<div class="offer">';
		echo '<a href="currentAccommodation.php?id=' . $id . '">';
		echo '<img src="' . $images . '" alt="' . $name . '">';
		echo '<p>' . $city . ", " . $address . "<br>" . $description . '<br> Average rating: '.$averageRating.' </p>';
		echo '</div>';
	}
} else {
	// No accommodations found
	echo '<p>No accommodations available at the moment.</p>';
}

// Close the database connection
mysqli_close($conn);
?>


