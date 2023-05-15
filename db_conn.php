<?php //CHANGE THE FOLLOWING WHEN MOVING TO SERVER ON FACULTY!!! VVVV
$servername = '';
$username = 'codeigniter';
//$username = 'root';
$password = 'codeigniter2019';
//$password = '';
$db_name = 'CV_proj';
//$db_name = 'sis3_php';
$urlroot = 'https://www.studenti.famnit.upr.si/~89201023/CampusVoices/login.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>    