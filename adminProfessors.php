<?php
// Include the database connection file
include "db_conn.php";

// Include the header file
include "header.php";
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Professors</title>
</head>
<body>
  <h2>Professor Management</h2>

  <?php
  // Function to sanitize user inputs
  function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // Update Professor
  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = sanitize($_POST['name']);
    $surname = sanitize($_POST['surname']);
    $email = sanitize($_POST['email']);
    $department = sanitize($_POST['department']);

    $sql = "UPDATE Professor SET name='$name', surname = '$surname', email='$email', department='$department' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
      echo "Professor updated successfully.<br>";
    } else {
      echo "Error updating professor: " . $conn->error . "<br>";
    }
  }

  // Delete Professor
  if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM Professor WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
      echo "Professor deleted successfully.<br>";
    } else {
      echo "Error deleting professor: " . $conn->error . "<br>";
    }
  }

  // Add Professor
  if (isset($_POST['add'])) {
    $name = sanitize($_POST['name']);
    $surname = sanitize($_POST['surname']);
    $email = sanitize($_POST['email']);
    $department = sanitize($_POST['department']);
    //echo $department;
    $sql = "INSERT INTO Professor (name, surname, email, department) VALUES ('$name','$surname', '$email', '$department')";
    if ($conn->query($sql) === TRUE) {
      echo "Professor added successfully.<br>";
    } else {
      echo "Error adding professor: " . $conn->error . "<br>";
    }
  }

  // Retrieve professors
  $sql = "SELECT * FROM Professor";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Display professor data in a table
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Department</th><th>Actions</th></tr>";

    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<form action='' method='post'>";
      echo "<td>".$row["id"]."</td>";
      echo "<td><input type='text' name='name' value='".$row["name"]."'></td>";
      echo "<td><input type='text' name='surname' value='".$row["surname"]."'></td>";
      echo "<td><input type='text' name='email' value='".$row["email"]."'></td>";
      echo "<td><input type='text' name='department' value='".$row["department"]."'></td>";
      echo "<td>
              <input type='hidden' name='id' value='".$row["id"]."'>
              <input type='submit' name='update' value='Update'>
              <input type='submit' name='delete' value='Delete'>
            </td>";
      echo "</form>";
      echo "</tr>";
    }

    echo "<tr>";
    echo "<form action='' method='post'>";
    echo "<td><i>Auto-generated</i></td>";
    echo "<td><input type='text' name='name' placeholder='Professor Name' required></td>";
    echo "<td><input type='text' name='surname' placeholder='Professor Surname' required></td>";
    echo "<td><input type='text' name='email' placeholder='Professor Email' required></td>";
    echo "<td><input type='text' name='department' placeholder='Professor Department' required></td>";
    echo "<td><input type='submit' name='add' value='Add'></td>";
    echo "</form>";
    echo "</tr>";

    echo "</table>";
  } else {
    echo "No professors found.";
  }

  // Close the database connection
  $conn->close();
  ?>
</body>
</html>
