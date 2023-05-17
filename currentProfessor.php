<?php
include "db_conn.php";

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
$userid = $_SESSION['id'];

// Check if professor ID is provided in the URL
if (isset($_GET['id'])) {
    $professorId = $_GET['id'];

    // Fetch the professor details from the database
    $query = "SELECT Professor.*, AVG(ProfessorReview.stars) AS average_rating FROM Professor LEFT JOIN ProfessorReview ON Professor.id = ProfessorReview.professor_id WHERE Professor.id = $professorId GROUP BY Professor.id";
    $result = mysqli_query($conn, $query);

    // Check if the professor exists
    if (mysqli_num_rows($result) > 0) {
        $professor = mysqli_fetch_assoc($result);

        $name = $professor['name'];
        $surname = $professor['surname'];
        $department = $professor['department'];
        $email = $professor['email'];
        $averageRating = $professor['average_rating'];

        // Fetch the reviews for the professor
        $reviewsQuery = "SELECT * FROM ProfessorReview WHERE professor_id = $professorId ORDER BY id DESC";
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
            // Check if the user has already reviewed this professor
            $existingReviewQuery = "SELECT * FROM ProfessorReview WHERE professor_id = $professorId AND user_id = $userid";
            $existingReviewResult = mysqli_query($conn, $existingReviewQuery);
            $existingReviewCount = mysqli_num_rows($existingReviewResult);

            if ($existingReviewCount > 0) {
                // User has already reviewed this professor, update the existing review
                $reviewStars = $_POST['stars'];
                $reviewBody = $_POST['review'];

                $updateQuery = "UPDATE ProfessorReview SET stars = $reviewStars, body = '$reviewBody' WHERE professor_id = $professorId AND user_id = $userid";
                mysqli_query($conn, $updateQuery);
            } else {
                // User has not reviewed this professor, insert a new review
                $reviewStars = $_POST['stars'];
                $reviewBody = $_POST['review'];
                $insertQuery = "INSERT INTO ProfessorReview (user_id, professor_id, body, stars) VALUES ($userid, $professorId, '$reviewBody', $reviewStars)";
                mysqli_query($conn, $insertQuery);
            }

            // Redirect back to the current professor page to see the updated reviews
            header("Location: currentProfessor.php?id=$professorId");
            exit();
        }

        // Handle review deletion
        if (isset($_POST['delete'])) {
            $deleteQuery = "DELETE FROM ProfessorReview WHERE professor_id = $professorId AND user_id = $userid";
            mysqli_query($conn, $deleteQuery);

            // Redirect back to the current professor page to see the updated reviews
            header("Location: currentProfessor.php?id=$professorId");
            exit();
        }
        // Generate the HTML for the current professor page
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Current Professor</title>
            <link rel="stylesheet" type="text/css" href="styleCurrentProfessor.css">
            <link rel="stylesheet" type="text/css" href="header.css">
        </head>
        <body>
            <header>
                <h1>University of Primorska Campus Voices - Professor</h1>
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

            <div class="current-professor">
                <h2><?php echo $name . ' ' . $surname; ?></h2>
                <p>Department: <?php echo $department; ?></p>
                <p>Email: <?php echo $email; ?></p>
                <p>Average rating: <?php echo number_format($averageRating, 1); ?></p>

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
                // Check if the user has already reviewed this professor
                $existingReviewQuery = "SELECT * FROM ProfessorReview WHERE professor_id = $professorId AND user_id = $userid";
                $existingReviewResult = mysqli_query($conn, $existingReviewQuery);
                $existingReviewCount = mysqli_num_rows($existingReviewResult);

                if ($existingReviewCount > 0) {
                    // User has already reviewed this professor, display the update review form
                    $existingReview = mysqli_fetch_assoc($existingReviewResult);
                    $existingReviewId = $existingReview['id'];
                    $existingReviewStars = $existingReview['stars'];
                    $existingReviewBody = $existingReview['body'];
                    ?>
                    <form action="" method="POST">
                        <input type="hidden" name="review_id" value="<?php echo $existingReviewId; ?>">
                        <label for="stars">Rating:</label>
                        <select name="stars">
                            <option value="1" <?php if ($existingReviewStars == 1) echo 'selected'; ?>>1</option>
                            <option value="2" <?php if ($existingReviewStars == 2) echo 'selected'; ?>>2</option>
                            <option value="3" <?php if ($existingReviewStars == 3) echo 'selected'; ?>>3</option>
                            <option value="4" <?php if ($existingReviewStars == 4) echo 'selected'; ?>>4</option>
                            <option value="5" <?php if ($existingReviewStars == 5) echo 'selected'; ?>>5</option>
                        </select>
                        <br>
                        <label for="review">Review:</label><br>
                        <textarea name="review" rows="4" cols="50"><?php echo $existingReviewBody; ?></textarea>
                        <br>
                        <input type="submit" name="submit" value="Update Review">
                    </form>
                    <?php
                } else {
                    // User has not reviewed this professor, display the new review form
                    ?>
                    <form action="" method="POST">
                        <label for="stars">Rating:</label>
                        <select name="stars">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <br>
                        <label for="review">Review:</label><br>
                        <textarea name="review" rows="4" cols="50"></textarea>
                        <br>
                        <input type="submit" name="submit" value="Submit Review">
                    </form>
                    <?php
                }
                ?>

            </div>

            <footer>
                <p>&copy; 2023 University of Primorska Campus Voices</p>
            </footer>
        </body>
        </html>
        <?php
    } else {
        echo 'Professor not found.';
    }
} else {
    echo 'Professor ID not provided.';
}

// Close the database connection
mysqli_close($conn);
?>
