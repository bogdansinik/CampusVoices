<?php

include "header.php";

?>
<!DOCTYPE html>
<html>
<head>
    <title>Food</title>
    <link rel="stylesheet" type="text/css" href="stylePrimorskaFood.css">
    <link rel="stylesheet" type="text/css" href="header.css">
</head>
<body>
   
    <div class="container">
        <div class="filter">
            <label for="city">Filter by City:</label>
            <select id="city" name="city">
                <option value="all">All Cities</option>
                <option value="koper">Koper</option>
                <option value="izola">Izola</option>
                <option value="piran">Piran</option>
                <option value="portoroz">Portoroz</option>
            </select>
            <button id="filter-btn">Filter</button>
        </div>
        <div class="restaurants">
            <?php
            // Include the database connection file
            include 'db_conn.php';
            if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
            $userid = $_SESSION['id'];

            // Fetch the restaurants from the database based on the selected city
            $selectedCity = isset($_GET['city']) ? $_GET['city'] : 'all';

            $query = "SELECT r.*, AVG(rr.stars) AS average_rating
                      FROM Restaurants AS r
                      LEFT JOIN RestaurantsReview AS rr ON r.id = rr.restaurant_id";

            // Apply the city filter if a specific city is selected
            if ($selectedCity != 'all') {
                $query .= " WHERE r.city = '$selectedCity'";
            }

            $query .= " GROUP BY r.id";
            $result = mysqli_query($conn, $query);

            // Check if there are any restaurants
            if (mysqli_num_rows($result) > 0) {
                // Loop through each restaurant and generate the HTML
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $city = $row['city'];
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
                    echo '<p>' . $city . '</p>';
                    echo '<p>' . $address . '</p>';
                    echo '<p>Phone: ' . $phone . '</p>';
                    echo '<p>Price for students: ' . $price . ' €</p>';
                    echo '<div class="rating">';
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
   
    <script>
        // Add event listener to the filter button
        const filterBtn = document.getElementById('filter-btn');
        filterBtn.addEventListener('click', () => {
            const selectedCity = document.getElementById('city').value;
            // Redirect to the same page with the selected city as a query parameter
            window.location.href = `primorskaFood.php?city=${selectedCity}`;
        });
    </script>
</body>
</html>
