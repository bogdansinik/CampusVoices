<?php
session_start();

include 'db_conn.php';

//$email = '';
$pass = '';
$uname = '';

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = trim($_POST['uname']);
    $pass = trim($_POST['password']);
    // Validate credentials
    $sql = "SELECT * FROM User WHERE username = '$uname' AND password = '$pass'";
    if ($result = mysqli_query($conn, $sql)) {
        if ($result->num_rows > 0) {
            session_start();
            $data = mysqli_fetch_array($result);
            // Store data in session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $data['id'];

            //$_SESSION['email'] = $email;
            $_SESSION['uname'] = $data['uname'];
            // Redirect user to welcome page    
            header('Location: primorskaHome.php');
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

    <title>LOGIN</title>

    <link rel="stylesheet" type="text/css" href="styleLogin.css">

</head>

<body>

     <form action="login.php" method="post">

        <h2>LOGIN</h2>

        <label>User Name</label>

        <input type="text" name="uname" placeholder="User Name"><br>

        <label>Password</label>

        <input type="password" name="password" placeholder="Password"><br> 

        <button type="submit">Login</button>

     </form>
<p>If not registered <br><a href="register.php">click here</a></p>
</body>

</html>



