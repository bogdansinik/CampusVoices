<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$userId = $_SESSION['id'];
$role = $_SESSION['role'];
//echo $role;

if($role == 'admin'){
    if($role == 'admin'){
    echo "<header>";
    echo "<h1>University of Primorska Campus Voices</h1>";
    echo '<nav>
    <ul>
        <li><a href="adminCourses.php">Courses</a></li>
        <li><a href="adminAccommodations.php">Accommodation</a></li>
        <li><a href="adminFood.php">Food</a></li>
        <li><a href="adminProfessors.php">Professors</a></li>
        <li><a href="logout.php">Logout</a></li>';
    echo ' </ul>
    </nav>
</header>';

}else{
    echo '<header>
        <h1>University of Primorska Campus Voices</h1>
        <nav>
            <ul>
                <li><a href="welcomePage.php">Home</a></li>
                <li><a href="primorskaCourses.php">Courses</a></li>
                <li><a href="primorskaAccommodation.php">Accommodation</a></li>
                <li><a href="primorskaFood.php">Food</a></li>
                <li><a href="primorskaProfessors.php">Professors</a></li>
                <li><a href="primorskaFun.php">Fun</a></li>
                ';

                if($role == "professor"){
                     echo "<li><a href='myProfile.php'>Profile</a></li>";
                }
        echo '<li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
</header>';
}
