<?php

include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = trim($_POST['uname']);
    $sname = trim($_POST['sname']);
    $fname = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM User WHERE username = '$uname'";

    if ($result = mysqli_query($conn, $sql)) {
        if ($result->num_rows > 0) {
            $email_err = 'This email is already in use.';
        } else {
            $sql = "INSERT INTO User (id, name, surname, password, username, email, role) VALUES (NULL, '$fname', '$sname', '$password', '$uname', '$email', '$role')";
            if ($statement = mysqli_query($conn, $sql)) {
                if (!empty($_POST['fname']) && !empty($_POST['sname']) && !empty($_POST['email']) && !empty($_POST['uname']) && !empty($_POST['password'])) {
                    header('location: login.php');
                }
            } else {
                echo 'Something went wrong. Please try again later.';
            }
        }
    } else {
        echo 'Something went wrong. Please try again later.';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>REGISTER</title>
    <link rel="stylesheet" type="text/css" href="styleLogin.css">
</head>

<body>
    <form action="register.php" method="post">
        <h2>REGISTER</h2>
        <label>Name</label>
        <input type="text" name="fname" placeholder="Name" required><br>
        <label>Surname</label>
        <input type="text" name="sname" placeholder="Surname" required><br>
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" required><br>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name" required><br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required><br>
        <label>Role</label>
        <select name="role">
            <option value="Professor">Professor</option>
            <option value="Student">Student</option>
        </select><br>
        <button type="submit">Register</button>
    </form>
    <p>Have an account?<br><a href="login.php">Click here</a></p>
</body>

</html>
