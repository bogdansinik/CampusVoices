<?php
include "db_conn.php";

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
$userid = $_SESSION['id'];

// Check if restaurant ID is provided in the URL
if (isset($_GET['id'])) {
    $restaurantId = $_GET['id'];

    // Fetch the restaurant details from the database
    $query = "SELECT * FROM Restaurants WHERE id = $restaurantId";
    $result = mysqli_query($conn, $query);

    // Check if the restaurant exists
    if (mysqli_num_rows($result) > 0) {
        $restaurant = mysqli_fetch_assoc($result);

        $name = $restaurant['name'];
        $city = $restaurant['city'];
        $address = $restaurant['address'];
        $price = $restaurant['price'];
        $images = $restaurant['image'];
        $contactNumber = $restaurant['phone'];
        // Fetch the reviews for the restaurant
        $reviewsQuery = "SELECT * FROM RestaurantsReview WHERE restaurant_id = $restaurantId ORDER BY id DESC";
        $reviewsResult = mysqli_query($conn, $reviewsQuery);

        // Calculate the average rating
        $totalStars = 0;
        $reviewCount = mysqli_num_rows($reviewsResult);
        while ($review = mysqli_fetch_assoc($reviewsResult)) {
            $totalStars += $review['stars'];
        }
        $averageRating = ($reviewCount > 0) ? $totalStars / $reviewCount : 0;

        // Handle review submission
        if (isset($_POST['submit'])) {
            // Check if the user has already reviewed this restaurant
            $existingReviewQuery = "SELECT * FROM RestaurantsReview WHERE restaurant_id = $restaurantId AND user_id = $userid";
            $existingReviewResult = mysqli_query($conn, $existingReviewQuery);
            $existingReviewCount = mysqli_num_rows($existingReviewResult);

            if ($existingReviewCount > 0) {
                // User has already reviewed this restaurant, update the existing review
                $reviewStars = $_POST['stars'];
                $reviewBody = $_POST['review'];

                $updateQuery = "UPDATE RestaurantsReview SET stars = $reviewStars, body = '$reviewBody' WHERE restaurant_id = $restaurantId AND user_id = $userid";
                mysqli_query($conn, $updateQuery);
            } else {
                // User has not reviewed this restaurant, insert a new review
                $reviewStars = $_POST['stars'];
                $reviewBody = $_POST['review'];
                $reviewDate = date('Y-m-d');
                $insertQuery = "INSERT INTO RestaurantsReview (restaurant_id, user_id, stars, body, date) VALUES ('$restaurantId', '$userid', '$reviewStars', '$reviewBody', '$reviewDate')";
                mysqli_query($conn, $insertQuery);
            }

            // Redirect back to the current restaurant page to see the updated reviews
            header("Location: currentRestaurant.php?id=$restaurantId");
            exit();
        }

        // Handle review deletion
        if (isset($_POST['delete'])) {
            $deleteQuery = "DELETE FROM RestaurantsReview WHERE restaurant_id = $restaurantId AND user_id = $userid";
            mysqli_query($conn, $deleteQuery);

            // Redirect back to the current restaurant page to see the updated reviews
            header("Location: currentRestaurant.php?id=$restaurantId");
            exit();
        }

        // Generate the HTML for the current restaurant page
        include "header.php";
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Current Restaurant</title>
            <link rel="stylesheet" type="text/css" href="styleCurrentProfessor.css">
            <link rel="stylesheet" type="text/css" href="styleCurrentAccommodation.css">
        </head>
        <body>
           

            <div class="current-accommodation">
                <h2><?php echo $name; ?></h2>
                <img src="<?php echo $images; ?>" alt="<?php echo $name; ?>">
                <p><?php echo $city . ", " . $address; ?></p>
                <p><?php echo $description; ?></p>
                <p>Average rating: <?php echo number_format($averageRating, 1); ?></p>
                <p>Contact number: <?php echo $contactNumber; ?></p>
                <p>Student price: <?php echo $price; ?>€</p>
                <h3>Reviews</h3>
                <?php
                $reviewsResult = mysqli_query($conn, $reviewsQuery);
                if ($reviewCount > 0) {
                    while ($review = mysqli_fetch_assoc($reviewsResult)) {
                        $reviewId = $review['id'];
                        $reviewBody = $review['body'];
                        $reviewStars = $review['stars'];
                        $reviewUserId = $review['user_id'];
                        $date = $review['date'];
                        // Fetch the user's information based on user_id
                        $userQuery = "SELECT name, surname FROM User WHERE id = $reviewUserId";
                        $userResult = mysqli_query($conn, $userQuery);
                        $user = mysqli_fetch_assoc($userResult);
                        $reviewUserName = $user['name'];
                        $reviewUserSurname = $user['surname'];

                        // Check if the review is made by the logged-in user
                        $isUserReview = ($reviewUserId == $userid);
                        ?>
                        <div class="review">
                            <p>Rating: <?php echo $reviewStars; ?>/5</p>
                            <p>By: <?php echo $reviewUserName . ' ' . $reviewUserSurname; ?></p>
                            <p><?php echo $date; ?></p>
                            <p><?php echo $reviewBody; ?></p>
                            <?php
                            if ($isUserReview) {
                                // Display the delete option for the user's review
                                ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="review_id" value="<?php echo $reviewId; ?>">
                                    <input type="submit" name="delete" value="Delete Review">
                                </form>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>No reviews available.</p>';
                }
                ?>

                <h3>Leave a Review</h3>
                <?php
                // Check if the user has already reviewed this restaurant
                $existingReviewQuery = "SELECT * FROM RestaurantsReview WHERE restaurant_id = $restaurantId AND user_id = $userid";
                $existingReviewResult = mysqli_query($conn, $existingReviewQuery);
                $existingReviewCount = mysqli_num_rows($existingReviewResult);

                if ($existingReviewCount > 0) {
                    // User has already reviewed this restaurant, display the edit review form
                    $existingReview = mysqli_fetch_assoc($existingReviewResult);
                    $existingReviewId = $existingReview['id'];
                    $existingReviewStars = $existingReview['stars'];
                    $existingReviewBody = $existingReview['body'];
                    ?>
                    <form action="" method="POST">
                        <input type="hidden" name="review_id" value="<?php echo $existingReviewId; ?>">
                        <label for="stars">Rating:</label>
                        <input type="number" name="stars" min="1" max="5" value="<?php echo $existingReviewStars; ?>" required>
                        <br>
                        <label for="review">Review:</label>
                        <textarea name="review" rows="4" cols="50" required><?php echo $existingReviewBody; ?></textarea>
                        <br>
                        <input type="submit" name="submit" value="Update Review">
                    </form>
                    <?php
                } else {
                    // User has not reviewed this restaurant, display the new review form
                    ?>
                    <form action="" method="POST">
                        <label for="stars">Rating:</label>
                        <input type="number" name="stars" min="1" max="5" required>
                        <br>
                        <label for="review">Review:</label>
                        <textarea name="review" rows="4" cols="50" required></textarea>
                        <br>
                        <input type="submit" name="submit" value="Submit Review">
                    </form>
                    <?php
                }
                ?>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Restaurant not found
        echo '<p>Restaurant not found.</p>';
    }
} else {
    // Restaurant ID not provided
    echo '<p>No restaurant ID provided.</p>';
}

// Close the database connection
mysqli_close($conn);
?>
