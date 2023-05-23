<?php

include "header.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <link rel="stylesheet" type="text/css" href="stylePrimorskaCourses.css">
    <link rel="stylesheet" type="text/css" href="header.css">
</head>
<body>
    <div class="container">
        <div class="search-form">
            <form method="get" action="primorskaCourses.php">
                <label for="search">Search for a Course:</label>
                <input type="text" id="search" name="search" required>
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="courses">
            <?php
            // Include the database connection file
            include 'db_conn.php';

            // Retrieve the search query from the URL if it exists
            $search = $_GET['search'] ?? '';

            // Fetch the courses from the database based on the search query
            $query = "SELECT Courses.*, Professor.name AS professor_name, Professor.surname AS professor_surname, AVG(CoursesReview.stars) AS average_rating 
                      FROM Courses 
                      JOIN Professor ON Courses.professor_id = Professor.id 
                      LEFT JOIN CoursesReview ON Courses.id = CoursesReview.course_id 
                      WHERE Courses.name LIKE '%$search%' 
                      GROUP BY Courses.id";
            $result = mysqli_query($conn, $query);

            // Check if there are any courses
            if (mysqli_num_rows($result) > 0) {
                // Loop through each course and generate the HTML
                while ($row = mysqli_fetch_assoc($result)) {
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
                    echo '<br><a class="infoButton" href="currentCourse.php?id=' . $id . '">More info</a>';
                    echo '</div>';
                }
            } else {
                // No courses found
                echo '<p>No courses available for the given search query.</p>';
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
