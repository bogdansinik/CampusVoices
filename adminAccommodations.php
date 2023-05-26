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
  <title>Admin Accommodation</title>
</head>
<body>
  <h2>Accommodation Management</h2>

  <?php
  // Function to sanitize user inputs
  function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // Update Accommodation
  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $city = sanitize($_POST['city']);
    $address = sanitize($_POST['address']);
    $type = sanitize($_POST['type']);
    $images = sanitize($_POST['images']);
    $number = sanitize($_POST['number']);
    if($city != 'Koper' | $city != 'Izola' | $city !='Piran' | $city != 'Portorož' | $city !='Lucija' | $type != 'Shared Room'| $type != 'Single Room'| $type != 'Condo'| $type != 'Other'| $type != 'Studio' | $type != 'Other'){
        header('Location: adminAccommodations.php');
  }
    else {$sql = "UPDATE Accommodation SET name='$name', description='$description', city='$city', address='$address', type='$type', images='$images', number='$number' WHERE id='$id'";}
    if ($conn->query($sql) === TRUE) {
      echo "Accommodation updated successfully.<br>";
    } else {
      echo "Error updating accommodation: " . $conn->error . "<br>";
    }
  }

  // Delete Accommodation
  if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM Accommodation WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
      echo "Accommodation deleted successfully.<br>";
    } else {
      echo "Error deleting accommodation: " . $conn->error . "<br>";
    }
  }

  // Add Accommodation
  if (isset($_POST['add'])) {
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $city = sanitize($_POST['city']);
    $address = sanitize($_POST['address']);
    $type = sanitize($_POST['type']);
    $images = sanitize($_POST['images']);
    $number = sanitize($_POST['number']);
    if($city != 'Koper' | $city != 'Izola' | $city !='Piran' | $city != 'Portorož' | $city !='Lucija' | $type != 'Shared Room'| $type != 'Single Room'| $type != 'Condo'| $type != 'Other'| $type != 'Studio' | $type != 'Other'){
        header('Location: adminAccommodations.php');
  }else $sql = "INSERT INTO Accommodation (name, description, city, address, type, images, number) VALUES ('$name', '$description', '$city', '$address', '$type', '$images', '$number')";
    if ($conn->query($sql) === TRUE) {
      echo "Accommodation added successfully.<br>";
    } else {
      echo "Error adding accommodation: " . $conn->error . "<br>";
    }
  }

  // Retrieve accommodations
  $sql = "SELECT * FROM Accommodation";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Display accommodation data in a table
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>City</th><th>Address</th><th>Type</th><th>Images</th><th>Number</th><th>Actions</th></tr>";

    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<form action='' method='post'>";
      echo "<td>".$row["id"]."</td>";
      echo "<td><input type='text' name='name' value='".$row["name"]."'></td>";
      echo "<td><input type='text' name='description' value='".$row["description"]."'></td>";
      echo "<td><input type='text' name='city' value='".$row["city"]."'></td>";
      echo "<td><input type='text' name='address' value='".$row["address"]."'></td>";
      echo "<td><input type='text' name='type' value='".$row["type"]."'></td>";
      echo "<td><input type='text' name='images' value='".$row["images"]."'></td>";
      echo "<td><input type='text' name='number' value='".$row["number"]."'></td>";
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
    echo "<td><input type='text' name='name' placeholder='Accommodation Name' required></td>";
    echo "<td><input type='text' name='description' placeholder='Accommodation Description' required></td>";
    echo "<td><input type='text' name='city' placeholder='City' required></td>";
    echo "<td><input type='text' name='address' placeholder='Address' required></td>";
    echo "<td><input type='text' name='type' placeholder='Type' required></td>";
    echo "<td><input type='text' name='images' placeholder='Images' required></td>";
    echo "<td><input type='text' name='number' placeholder='Number' required></td>";
    echo "<td><input type='submit' name='add' value='Add'></td>";
    echo "</form>";
    echo "</tr>";

    echo "</table>";
  } else {
    echo "No accommodations found.";
  }

  // Close the database connection
  $conn->close();
  ?>
</body>
</html>
