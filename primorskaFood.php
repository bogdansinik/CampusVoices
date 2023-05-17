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
    <div class="container">
        <div class="restaurants">
            <?php
            // Include the database connection file
            include 'db_conn.php';
            session_start();
            $userid = $_SESSION['id'];
            // Fetch the restaurants from the database
            $query = "SELECT r.*, AVG(rr.stars) AS average_rating
                      FROM Restaurants AS r
                      LEFT JOIN RestaurantsReview AS rr ON r.id = rr.restaurant_id
                      GROUP BY r.id";
            $result = mysqli_query($conn, $query);

            // Check if there are any restaurants
            if (mysqli_num_rows($result) > 0) {
                // Loop through each restaurant and generate the HTML
                while ($row = mysqli_fetch_assoc($result)) {
					$id = $row['id'];
                    $name = $row['name'];
                    $address = $row['address'];
                    $phone = $row['phone'];
                    $price = $row['price'];
                    $image = $row['image'];
                    $averageRating = $row['average_rating'];

                    // Generate the HTML for each restaurant
                    echo '<div class="restaurant">';
					echo '<a href="currentRestaurant.php?id=' . $id . '"> <img src="' . $image . '" alt="' . $name . '"></a>';
                   
                    echo '<div class="info">';
                    echo '<h2>' . $name . '</h2>';
                    echo '<p>' . $address . '</p>';
                    echo '<p>Phone: ' . $phone . '</p>';
                    echo '<p>Price for students: ' . $price . ' €</p>';
                    echo '<div class="rating">';
                    // echo '<span class="star">&#9733;</span>';
                    // echo '<span class="star">&#9733;</span>';
                    // echo '<span class="star">&#9733;</span>';
                    // echo '<span class="star">&#9733;</span>';
                    // echo '<span class="star">&#9733;</span>';
                    // //echo '<span class="value">' . $averageRating . '</span>';
					echo '<div class="rating">';
					$filledStars = floor($averageRating); // Number of filled stars
					$hasHalfStar = $averageRating - $filledStars >= 0.5; // Check if there's a half star
					$emptyStars = 5 - $filledStars - $hasHalfStar; // Number of empty stars

					for ($i = 1; $i <= $filledStars; $i++) {
						echo '<span class="star">&#9733;</span>';
					}

					if ($hasHalfStar) {
						echo '<span class="star">&#9733;</span>';
					} else {
						//echo '<span class="star">&#9734;</span>';
					}

					for ($i = 1; $i <= $emptyStars; $i++) {
						echo '<span class="star">&#9734;</span>';
					}

					echo '<span class="value">' . number_format($averageRating, 1) . '</span>';
					echo '</div>';
                    echo '</div>';
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
