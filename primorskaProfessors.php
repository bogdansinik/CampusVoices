<?php

include "header.php";

?>
<!DOCTYPE html>
<html>
<head>
    <title>Professors</title>
    <link rel="stylesheet" type="text/css" href="stylePrimorskaCourses.css">
    <link rel="stylesheet" type="text/css" href="header.css">
</head>
<body>
    
    <div class="container">
        <div class="search-form">
            <form method="get" action="primorskaProfessors.php">
                <label for="search">Search for a Professor:</label>
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

            // Fetch the professors from the database based on the search query
            $query = "SELECT Professor.*, AVG(ProfessorReview.stars) AS average_rating 
                      FROM Professor 
                      LEFT JOIN ProfessorReview ON Professor.id = ProfessorReview.professor_id 
                      WHERE Professor.name LIKE '%$search%' OR Professor.surname LIKE '%$search%'
                      GROUP BY Professor.id";
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
                }
            } else {
                // No professors found
                echo '<p>No professors available for the given search query.</p>';
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
    
</body>
</html>
