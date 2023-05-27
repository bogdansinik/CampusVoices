<?php //CHANGE THE FOLLOWING WHEN MOVING TO SERVER ON FACULTY!!! VVVV
$servername = '';
//$username = 'codeigniter';
$username = 'root';
//$password = 'codeigniter2019';
//$password = '';
//$db_name = 'CV_proj';
$db_name = 'CampusVoices';
$urlroot = 'https://www.studenti.famnit.upr.si/~89201013/CampusVoices/login.php';
//$urlroot = "~/Documents/Faculty/3rd/%20year/MIT/CampusVoices/";
// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);



// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>    