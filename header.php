<?php

session_start();
$userId = $_SESSION['id'];
$role = $_SESSION['role'];
//echo $role;
?>
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
                <?php
                if($role == 'professor'){
                    echo '<li><a href="myProfile.php">Profile</a></li>';
                }
                ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
</header>