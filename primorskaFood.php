<!-- <!DOCTYPE html>
<html>
<head>
	<title>Food</title>
	<link rel="stylesheet" type="text/css" href="stylePrimorskaFood.css">
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
	<div class="container">
		<h1>Food</h1>
		<div class="restaurants">
			<div class="restaurant">
				<img src="restaurant1.jpg" alt="Atrij">
				<div class="info">
					<h2>Atrij</h2>
					<p>Atrij is local pizzeria/restaurant. It offers a lot of options to students such as pizza, steaks, soups, salads etc.</p>
					<div class="rating">
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="value">4.9</span>
					</div>
				</div>
			</div>
			<div class="restaurant">
				<img src="restaurant2.jpg" alt="Villa Domus">
				<div class="info">
					<h2>Villa Domus</h2>
					<p>Villa Domus is a restaurant located in the student dormitory with same name. It offers more than 10 menus for students. All menus consist of soup, salad and main dish.</p>
					<div class="rating">
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="value">4.0</span>
					</div>
				</div>
			</div>
			<div class="restaurant">
				<img src="restaurant3.jpg" alt="Restaurant 3">
				<div class="info">
					<h2>Fast Food Magic</h2>
					<p>Fast Food Magic is low budget option for student. It offers very good grill options and kebab.</p>
					<div class="rating">
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="star">&#9733;</span>
						<span class="value">3.0</span>
					</div>
				</div>
			</div>
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
	<title>Food</title>
	<link rel="stylesheet" type="text/css" href="stylePrimorskaFood.css">
</head>
<body>
	<header>
		<h1>University of Primorska Campus Voices - Food</h1>
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
	<div class="container">
		<div class="restaurants">
			<?php
			
			// Include the database connection file
			include 'db_conn.php';
			session_start();
			$userid = $_SESSION['id'];
			// Fetch the restaurants from the database
			$query = "SELECT * FROM Restaurants";
			$result = mysqli_query($conn, $query);

			// Check if there are any restaurants
			if (mysqli_num_rows($result) > 0) {
			    // Loop through each restaurant and generate the HTML
			    while ($row = mysqli_fetch_assoc($result)) {
			        $name = $row['name'];
			        $address = $row['address'];
			        $phone = $row['phone'];
			        $price = $row['price'];
			        $image = $row['image'];

			        // Generate the HTML for each restaurant
			        echo '<div class="restaurant">';
			        echo '<img src="' . $image . '" alt="' . $name . '">';
			        echo '<div class="info">';
			        echo '<h2>' . $name . '</h2>';
			        echo '<p>' . $address . '</p>';
			        echo '<p>Phone: ' . $phone . '</p>';
			        echo '<p>Price for students: ' . $price . ' €</p>';
			        echo '</div>';
			        echo '</div>';
			    }
			} else {
			    // No restaurants found
			    echo '<p>No restaurants available at the moment.</p>';
			}

			// Close the database connection
			mysqli_close($conn);
			?>
		</div>
	</div>
	<footer>
		<p>&copy; 2023 University of Primorska Campus Voices</p>
	</footer>
</body>
</html>
