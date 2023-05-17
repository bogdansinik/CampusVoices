<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <link rel="stylesheet" type="text/css" href="stylePrimorskaCourses.css">
</head>
<body>
    <header>
        <h1>University of Primorska Campus Voices - Courses</h1>
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
    
        <div class="courses">
            <?php
            // Include the database connection file
            include 'db_conn.php';

            // Fetch the courses from the database
            // Fetch the courses from the database
			$query = "SELECT Courses.*, Professor.name AS professor_name, Professor.surname AS professor_surname, AVG(CoursesReview.stars) AS average_rating FROM Courses JOIN Professor ON Courses.professor_id = Professor.id LEFT JOIN CoursesReview ON Courses.id = CoursesReview.course_id GROUP BY Courses.id";
			$result = mysqli_query($conn, $query);


            // Check if there are any courses
            if (mysqli_num_rows($result) > 0) {
                // Loop through each course and generate the HTML
                while ($row = mysqli_fetch_assoc($result)) {
					//echo $row['id'];
					$id = $row['id'];
                    $name = $row['name'];
                    $description = $row['description'];
                    $link = $row['link'];
                    $professorName = $row['professor_name'];
                    $professorSurname = $row['professor_surname'];
                    $averageRating = $row['average_rating'];
                    // Generate the HTML for each course
                    echo '<div class="course">';
                    echo '<h2>' . $name . '</h2>';
                    echo '<p>' . $description . '</p>';
                    echo '<p>Professor: ' . $professorName . ' ' . $professorSurname . '</p>';
                    echo '<p>Average rating for course: ' . number_format($averageRating, 1) . '</p>';
                    echo '<a href="' . $link . '">Online link</a>';
                    //echo '<br> <a href="currentCourse.php?id="'. $id. '>More info</a>';
					echo '<br><a class = "infoButton" href="currentCourse.php?id=' . $id . '">More info</a>';
                    echo '</div>';
                }
            } else {
                // No courses found
                echo '<p>No courses available at the moment.</p>';
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


