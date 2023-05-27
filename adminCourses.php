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
  <title>Admin Courses</title>
</head>
<body>
  <h2>Course Management</h2>

  <?php
  // Function to sanitize user inputs
  function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // Update Course
  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $professor_id = $_POST['professor_id'];
    $link = $_POST['link'];
    $semester = $_POST['semester'];
    if($semester != 'Spring' & $semester != 'Winter') {
        header('Location: adminCourses.php');
    }else  {$sql = "UPDATE Courses SET name='$name', description='$description', professor_id='$professor_id', link='$link', semester = '$semester' WHERE id='$id'";}
    if ($conn->query($sql) === TRUE) {
      echo "Course updated successfully.<br>";
    } else {
      echo "Error updating course: " . $conn->error . "<br>";
    }
  }

  // Delete Course
  if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM Courses WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
      echo "Course deleted successfully.<br>";
    } else {
      echo "Error deleting course: " . $conn->error . "<br>";
    }
  }

  // Add Course
  if (isset($_POST['add'])) {
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $professor_id = $_POST['professor_id'];
    $link = $_POST['link'];
    $semester = $_POST['semester'];
    if($semester != 'Spring' & $semester != 'Winter') {
        //header('Location: adminCourses.php');
        echo "asldjnasjkd2";
    }
    else $sql = "INSERT INTO Courses (name, description, professor_id, link, semester) VALUES ('$name', '$description', '$professor_id', '$link', '$semester')";
    if ($conn->query($sql) === TRUE) {
      echo "Course added successfully.<br>";
    } else {
      echo "Error adding course: " . $conn->error . "<br>";
    }
  }

  // Retrieve courses
  $sql = "SELECT * FROM Courses";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Display course data in a table
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Professor ID</th><th>Link</th><th>Semester</th><th>Actions</th></tr>";

    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<form action='' method='post'>";
      echo "<td>".$row["id"]."</td>";
      echo "<td><input type='text' name='name' value='".$row["name"]."'></td>";
      echo "<td><input type='text' name='description' value='".$row["description"]."'></td>";
      echo "<td><input type='text' name='professor_id' value='".$row["professor_id"]."'></td>";
      echo "<td><input type='text' name='link' value='".$row["link"]."'></td>";
      echo "<td><input type='text' name='semester' value='".$row["semester"]."'></td>";
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
    echo "<td><input type='text' name='name' placeholder='Course Name' required></td>";
    echo "<td><input type='text' name='description' placeholder='Course Description' required></td>";
    echo "<td><input type='text' name='professor_id' placeholder='Professor ID' required></td>";
    echo "<td><input type='text' name='link' placeholder='Course Link' required></td>";
    echo "<td><input type='text' name='semester' placeholder='Course Semester' required></td>";
    echo "<td><input type='submit' name='add' value='Add'></td>";
    echo "</form>";
    echo "</tr>";

    echo "</table>";
  } else {
    echo "No courses found.";
  }

  // Close the database connection
  $conn->close();
  ?>
</body>
</html>
