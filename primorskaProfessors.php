<!DOCTYPE html>
<html>
<head>
    <title>Professors</title>
    <link rel="stylesheet" type="text/css" href="stylePrimorskaCourses.css">
</head>
<body>
    <header>
        <h1>University of Primorska Campus Voices</h1>
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
        <div class="professors">
            <?php
            // Include the database connection file
            include 'db_conn.php';

            // Fetch the professors from the database along with average rating
            $query = "SELECT Professor.*, AVG(ProfessorReview.stars) AS average_rating FROM Professor LEFT JOIN ProfessorReview ON Professor.id = ProfessorReview.professor_id GROUP BY Professor.id";
            $result = mysqli_query($conn, $query);

            // Check if there are any professors
            if (mysqli_num_rows($result) > 0) {
                // Loop through each professor and generate the HTML
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $surname = $row['surname'];
                    $department = $row['department'];
                    $email = $row['email'];
                    $averageRating = $row['average_rating'];

                    // Generate the HTML for each professor
                    echo '<div class="course">';
                    echo '<h2>' . $name . ' ' . $surname . '</h2>';
                    echo '<p>Department: ' . $department . '</p>';
                    echo '<p>Email: ' . $email . '</p>';
                    echo '<p>Average rating: ' . number_format($averageRating, 1) . '</p>';
                    echo '<a href="currentProfessor.php?id=' . $id . '">Rate Professor</a>';
                    echo '</div>';
                    echo '<br>';
                }
            } else {
                // No professors found
                echo '<p>No professors available at the moment.</p>';
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

