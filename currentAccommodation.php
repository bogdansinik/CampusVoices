<?php
include "db_conn.php";

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
$userid = $_SESSION['id'];

// Check if accommodation ID is provided in the URL
if (isset($_GET['id'])) {
    $accommodationId = $_GET['id'];

    // Fetch the accommodation details from the database
    $query = "SELECT * FROM Accommodation WHERE id = $accommodationId";
    $result = mysqli_query($conn, $query);

    // Check if the accommodation exists
    if (mysqli_num_rows($result) > 0) {
        $accommodation = mysqli_fetch_assoc($result);

        $name = $accommodation['name'];
        $description = $accommodation['description'];
        $city = $accommodation['city'];
        $address = $accommodation['address'];
        $type = $accommodation['type'];
        $images = $accommodation['images'];
        $contactNumber = $accommodation['number'];
        
        // Fetch the reviews for the accommodation
        $reviewsQuery = "SELECT * FROM AccommodationReview WHERE accommodation_id = $accommodationId ORDER BY id DESC";
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
            // Check if the user has already reviewed this accommodation
            $existingReviewQuery = "SELECT * FROM AccommodationReview WHERE accommodation_id = $accommodationId AND user_id = $userid";
            $existingReviewResult = mysqli_query($conn, $existingReviewQuery);
            $existingReviewCount = mysqli_num_rows($existingReviewResult);

            if ($existingReviewCount > 0) {
                // User has already reviewed this accommodation, update the existing review
                $reviewStars = $_POST['stars'];
                $reviewBody = $_POST['review'];

                $updateQuery = "UPDATE AccommodationReview SET stars = $reviewStars, body = '$reviewBody' WHERE accommodation_id = $accommodationId AND user_id = $userid";
                mysqli_query($conn, $updateQuery);
            } else {
                // User has not reviewed this accommodation, insert a new review
                $reviewStars = $_POST['stars'];
                $reviewBody = $_POST['review'];
                $reviewDate = date('Y-m-d');
                $insertQuery = "INSERT INTO AccommodationReview (accommodation_id, user_id, stars, body,date) VALUES ('$accommodationId', '$userid', '$reviewStars', '$reviewBody', '$reviewDate')";
                mysqli_query($conn, $insertQuery);
            }

            // Redirect back to the current accommodation page to see the updated reviews
            header("Location: currentAccommodation.php?id=$accommodationId");
            exit();
        }

        // Handle review deletion
        if (isset($_POST['delete'])) {
            $deleteQuery = "DELETE FROM AccommodationReview WHERE accommodation_id = $accommodationId AND user_id = $userid";
            mysqli_query($conn, $deleteQuery);

            // Redirect back to the current accommodation page to see the updated reviews
            header("Location: currentAccommodation.php?id=$accommodationId");
            exit();
        }

        // Generate the HTML for the current accommodation page
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Current Accommodation</title>
            <link rel="stylesheet" type="text/css" href="styleCurrentProfessor.css">
            <link rel="stylesheet" type="text/css" href="styleCurrentAccommodation.css">
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

            <div class="current-accommodation">
                <h2><?php echo $name; ?></h2>
                <img src="<?php echo $images; ?>" alt="<?php echo $name; ?>">
                <p><?php echo $city . ", " . $address; ?></p>
                <p><?php echo $description; ?></p>
                <p>Average rating: <?php echo number_format($averageRating, 1); ?></p>
                <p>Type: <?php echo $type; ?></p>
		        <p>Contact number: <?php echo $contactNumber; ?></p>

                <h3>Reviews</h3>
                <?php
                $reviewsResult = mysqli_query($conn, $reviewsQuery);
                if ($reviewCount > 0) {
                    while ($review = mysqli_fetch_assoc($reviewsResult)) {
                        $reviewId = $review['id'];
                        $reviewBody = $review['body'];
                        $reviewStars = $review['stars'];
                        $reviewUserId = $review['user_id'];

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
                // Check if the user has already reviewed this accommodation
                $existingReviewQuery = "SELECT * FROM AccommodationReview WHERE accommodation_id = $accommodationId AND user_id = $userid";
                $existingReviewResult = mysqli_query($conn, $existingReviewQuery);
                $existingReviewCount = mysqli_num_rows($existingReviewResult);

                if ($existingReviewCount > 0) {
                    // User has already reviewed this accommodation, display the edit review form
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
                    // User has not reviewed this accommodation, display the new review form
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
        // Accommodation not found
        echo '<p>Accommodation not found.</p>';
    }
} else {
    // Accommodation ID not provided
    echo '<p>No accommodation ID provided.</p>';
}

// Close the database connection
mysqli_close($conn);
?>
