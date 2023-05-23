<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" type="text/css" href="myProfile.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <?php
        // Include the database connection file
        include 'db_conn.php';
        if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
        $professorID = $_SESSION['id'];

        // Fetch professor's information from the database
        $queryProfessor = "SELECT * FROM Professor WHERE id = $professorID";
        $resultProfessor = mysqli_query($conn, $queryProfessor);

        if (mysqli_num_rows($resultProfessor) > 0) {
            $rowProfessor = mysqli_fetch_assoc($resultProfessor);
            $professorName = $rowProfessor['name'];
            $professorEmail = $rowProfessor['email'];
            $professorDepartment = $rowProfessor['department'];

            echo '<h2>Welcome, Professor ' . $professorName . '</h2>';
            echo '<h3>Personal Information:</h3>';
            echo '<p>Name: ' . $professorName . '</p>';
            echo '<p>Email: ' . $professorEmail . '</p>';
            echo '<p>Department: ' . $professorDepartment . '</p>';

            // Fetch professor's course ratings from the database
            $queryCourses = "SELECT c.*, AVG(rc.stars) AS average_rating
                             FROM Courses AS c
                             LEFT JOIN CoursesReview AS rc ON c.id = rc.course_id
                             WHERE c.professor_id = $professorID
                             GROUP BY c.id";
            $resultCourses = mysqli_query($conn, $queryCourses);
            
            $queryProfRating = "SELECT AVG(stars) as avg_rating FROM ProfessorReview WHERE professor_id = $professorID";
            $resultProfRating = mysqli_query($conn, $queryProfRating);
            $rowProfRating = mysqli_fetch_assoc($resultProfRating);
           
            
            if (mysqli_num_rows($resultCourses) > 0) {
                echo '<h3>Ratings:</h3>';
                echo '<div class="ratings">';
                echo '<h4>My Average Rating: ' .number_format($rowProfRating['avg_rating'],1) . '</h4>';
                echo '<h4>Course Ratings:</h4>';
                echo '<ul>';

                while ($rowCourse = mysqli_fetch_assoc($resultCourses)) {
                    $courseName = $rowCourse['name'];
                    $courseAverageRating = $rowCourse['average_rating'];

                    echo '<li>';
                    echo '<span>' . $courseName . ':</span>';
                    echo '<span>Average Rating: ' .number_format($courseAverageRating,1) . '</span>';
                    echo '</li>';
                }

                echo '</ul>';
                echo '</div>';
            } else {
                echo '<p>No course ratings available.</p>';
            }
        } else {
            echo '<p>Professor not found.</p>';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
    <footer>
        <p>&copy; 2023 University of Primorska Campus Voices</p>
    </footer>
</body>
</html>
