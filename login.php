<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

include 'db_conn.php';

//$email = '';
$pass = '';
$uname = '';

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "here!";
    $uname = trim($_POST['uname']);
    $pass = trim($_POST['password']);
    echo $uname;
    // Validate credentials
    $sql = "SELECT * FROM User WHERE username = '$uname' AND password = '$pass'";
    $sql_all = "SELECT * FROM User";
    if ($result = mysqli_query($conn, $sql)) {
        if ($result->num_rows > 0) {
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            } 
            $data = mysqli_fetch_array($result);
            // Store data in session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $data['id'];
            $_SESSION['role'] = $data['role'];

            //$_SESSION['email'] = $email;
            $_SESSION['uname'] = $data['uname'];
            // Redirect user to welcome page    
            header('Location: welcomePage.php');
        } else {
            echo '<script>alert("Wrong username or password")</script>';
            //header("Location: login_view.php");
        }
    }
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Campus Voices - Login</title>
  <link rel="stylesheet" type="text/css" href="styleLogin.css">
</head>
<body>
    <h2>CAMPUS VOICES</h2>
  <div id="container">
    <div id="image-container">
      <img src="./images/university.jpg" alt="Logo" width="200">
    </div>
    <div id="form-container">
        <div id="login-form">
        <h3>Log In</h3>
        <form action="login.php" method="post">
            <input type="text" name="uname" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
        <a href="register.php">Not registered?</a>
        </div>
    </div>
  </div>
</body>
</html>
