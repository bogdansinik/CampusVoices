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
    $uname = trim($_POST['uname']);
    $pass = trim($_POST['password']);
    // Validate credentials
    $sql = "SELECT * FROM User WHERE username = '$uname' AND password = '$pass'";
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
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="styleLogin.css">
  <style>
    body {
      background-color: #87CEEB;
      font-family: Arial, sans-serif;
    }
    
    #container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-gap: 20px;
      justify-items: center;
      align-items: center;
      height: 100vh;
    }

      #form-container {
      display: grid;
      grid-template-columns: 1fr;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    
    #login-form {
      background-color: white;
      padding: 30px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    #login-form h2 {
      text-align: center;
      color: orange;
    }
    
    #login-form input[type="text"],
    #login-form input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    
    #login-form button {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: orange;
      border: none;
      border-radius: 3px;
      color: white;
      font-weight: bold;
    }
    
    #login-form a {
      text-align: center;
      color: #777;
      text-decoration: none;
    }
    
    #login-form a:hover {
      color: orange;
    }

    img {
        border-radius: 50%;
    }
  </style>
</head>
<body>
  <div id="container">
    <div id="image-cell">
      <img src="./images/university.jpg" alt="Logo" width="400">
    </div>
    <div id="form-container">
        <div id="login-form">
          <h2>Campus Voices</h2>
          <form>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
          </form>
          <p>If not registered, <a href="register.php">click here</a></p>
        </div>
  </div>
</body>
</html>
