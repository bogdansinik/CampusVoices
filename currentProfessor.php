<?php
include "db_conn.php";

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$userid = $_SESSION['id'];
$role = $_SESSION['role'];
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
        include "header.php";
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Current Professor</title>
            <link rel="stylesheet" type="text/css" href="styleCurrentProfessor.css">
            <link rel="stylesheet" type="text/css" href="header.css">
        </head>
        <body>
            

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
 <?php
                if($role == "student"){
 
                  
                    echo "<h3>Leave a Review</h3>";
                    
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
                    
                        echo "<form action='' method='POST'>";
                        echo "<input type='hidden' name='review_id' value='$existingReviewId'>";
                        echo "<label for='stars'>Rating:</label>";
                        echo "<select name='stars'>";
                        echo "<option value='1'" . ($existingReviewStars == 1 ? "selected" : "") . ">1</option>";
                        echo "<option value='2'" . ($existingReviewStars == 2 ? "selected" : "") . ">2</option>";
                        echo "<option value='3'" . ($existingReviewStars == 3 ? "selected" : "") . ">3</option>";
                        echo "<option value='4'" . ($existingReviewStars == 4 ? "selected" : "") . ">4</option>";
                        echo "<option value='5'" . ($existingReviewStars == 5 ? "selected" : "") . ">5</option>";
                        echo "</select>";
                        echo "<br>";
                        echo "<label for='review'>Review:</label><br>";
                        echo "<textarea name='review' rows='4' cols='50'>$existingReviewBody</textarea>";
                        echo "<br>";
                        echo "<input type='submit' name='submit' value='Update Review'>";
                        echo "</form>";
                    } else {
                        // User has not reviewed this professor, display the new review form
                        echo "<form action='' method='POST'>";
                        echo "<label for='stars'>Rating:</label>";
                        echo "<select name='stars'>";
                        echo "<option value='1'>1</option>";
                        echo "<option value='2'>2</option>";
                        echo "<option value='3'>3</option>";
                        echo "<option value='4'>4</option>";
                        echo "<option value='5'>5</option>";
                        echo "</select>";
                        echo "<br>";
                        echo "<label for='review'>Review:</label><br>";
                        echo "<textarea name='review' rows='4' cols='50'></textarea>";
                        echo "<br>";
                        echo "<input type='submit' name='submit' value='Submit Review'>";
                        echo "</form>";
                    }
                }
                    ?>
                    

            </div>
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
