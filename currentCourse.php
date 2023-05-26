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
// Check if course ID is provided in the URL
if (isset($_GET['id'])) {
    $courseId = $_GET['id'];

    // Fetch the course details from the database
    $query = "SELECT Courses.*, Professor.name AS professor_name, Professor.surname AS professor_surname FROM Courses LEFT JOIN Professor ON Courses.professor_id = Professor.id WHERE Courses.id = $courseId";
    $result = mysqli_query($conn, $query);

    // Check if the course exists
    if (mysqli_num_rows($result) > 0) {
        $course = mysqli_fetch_assoc($result);

        $name = $course['name'];
        $description = $course['description'];
        $ects = $course['ects'];
        $semester = $course['semester'];
        $professorName = $course['professor_name'];
        $professorSurname = $course['professor_surname'];

        // Fetch the reviews for the course
        $reviewsQuery = "SELECT * FROM CoursesReview WHERE course_id = $courseId ORDER BY id DESC";
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
            // Check if the user has already reviewed this course
            $existingReviewQuery = "SELECT * FROM CoursesReview WHERE course_id = $courseId AND user_id = $userid";
            $existingReviewResult = mysqli_query($conn, $existingReviewQuery);
            $existingReviewCount = mysqli_num_rows($existingReviewResult);

            if ($existingReviewCount > 0) {
                // User has already reviewed this course, update the existing review
                $reviewStars = $_POST['stars'];
                $reviewBody = $_POST['review'];

                $updateQuery = "UPDATE CoursesReview SET stars = $reviewStars, body = '$reviewBody' WHERE course_id = $courseId AND user_id = $userid";
                mysqli_query($conn, $updateQuery);
            } else {
                // User has not reviewed this course, insert a new review
                $reviewStars = $_POST['stars'];
                $reviewBody = $_POST['review'];
                $insertQuery = "INSERT INTO CoursesReview (user_id, course_id, body, stars) VALUES ($userid, $courseId, '$reviewBody', $reviewStars)";
                mysqli_query($conn, $insertQuery);
            }

            // Redirect back to the current course page to see the updated reviews
            header("Location: currentCourse.php?id=$courseId");
            exit();
        }

        // Handle review deletion
        if (isset($_POST['delete'])) {
            $deleteQuery = "DELETE FROM CoursesReview WHERE course_id = $courseId AND user_id = $userid";
            mysqli_query($conn, $deleteQuery);

            // Redirect back to the current course page to see the updated reviews
            header("Location: currentCourse.php?id=$courseId");
            exit();
        }
    // Generate the HTML for the current course page
    include "header.php";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Current Course</title>
        <link rel="stylesheet" type="text/css" href="styleCurrentProfessor.css">
        <link rel="stylesheet" type="text/css" href="styleCurrentCourse.css">
    </head>
    <body>
    

        <div class="current-course">
            <h2><?php echo $name; ?></h2>
            <p>Description: <?php echo $description; ?></p>
            <p>ECTS: <?php echo $ects; ?></p>
            <p>Semester: <?php echo $semester; ?></p>
            <p>Professor: <?php echo $professorName . ' ' . $professorSurname; ?></p>
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
if($role == 'student') {
echo "<h3>Leave a Review</h3>";

// Check if the user has already reviewed this course
$existingReviewQuery = "SELECT * FROM CoursesReview WHERE course_id = $courseId AND user_id = $userid";
$existingReviewResult = mysqli_query($conn, $existingReviewQuery);
$existingReviewCount = mysqli_num_rows($existingReviewResult);

if ($existingReviewCount > 0) {
    // User has already reviewed this course, display the edit review form
    $existingReview = mysqli_fetch_assoc($existingReviewResult);
    $existingReviewId = $existingReview['id'];
    $existingReviewStars = $existingReview['stars'];
    $existingReviewBody = $existingReview['body'];

    echo "<form action='' method='POST'>";
    echo "<input type='hidden' name='review_id' value='$existingReviewId'>";
    echo "<label for='stars'>Rating:</label>";
    echo "<input type='number' name='stars' min='1' max='5' value='$existingReviewStars' required>";
    echo "<br>";
    echo "<label for='review'>Review:</label>";
    echo "<textarea name='review' rows='4' cols='50' required>$existingReviewBody</textarea>";
    echo "<br>";
    echo "<input type='submit' name='submit' value='Update Review'>";
    echo "</form>";
} else {
    // User has not reviewed this course, display the new review form
    echo "<form action='' method='POST'>";
    echo "<label for='stars'>Rating:</label>";
    echo "<input type='number' name='stars' min='1' max='5' required>";
    echo "<br>";
    echo "<label for='review'>Review:</label>";
    echo "<textarea name='review' rows='4' cols='50' required></textarea>";
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
    // Course not found
    echo '<p>Course not found.</p>';
}
} else {
    // Course ID not provided
    echo '<p>No course ID provided.</p>';
    }
    
    // Close the database connection
    mysqli_close($conn);
    ?>