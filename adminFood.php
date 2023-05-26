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
  <title>Admin Food</title>
</head>
<body>
  <h2>Food Management</h2>

  <?php
  // Function to sanitize user inputs
  function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // Update Restaurant
  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = sanitize($_POST['name']);
    //$description = sanitize($_POST['description']);
    $address = sanitize($_POST['address']);
    $phone = sanitize($_POST['phone']);
    $price = sanitize($_POST['price']);
    $city = sanitize($_POST['city']);
    //echo $city != "Izola";
    if($city != "Koper" & $city != "Izola" & $city != "Portoroz" & $city != "Piran"){
        //header("Location: adminFood.php");
        echo $city;
    }else $sql = "UPDATE Restaurants SET name='$name', address='$address', phone='$phone', price = '$price', city = '$city' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
      echo "Restaurant updated successfully.<br>";
    } else {
      echo "Error updating restaurant: " . $conn->error . "<br>";
    }
  }

  // Delete Restaurant
  if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM Restaurants WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
      echo "Restaurant deleted successfully.<br>";
    } else {
      echo "Error deleting restaurant: " . $conn->error . "<br>";
    }
  }

  // Add Restaurant
  if (isset($_POST['add'])) {
    $name = sanitize($_POST['name']);
    //$description = sanitize($_POST['description']);
    $address = sanitize($_POST['address']);
    $phone = sanitize($_POST['phone']);
    $price = sanitize($_POST['price']);
    $city = sanitize($_POST['city']);
    $image = sanitize($_POST['image']);
    if($city != "Koper" & $city != "Izola" & $city != "Portoroz" & $city != "Piran"){
        header("Location: adminFood.php");

    }else {$sql = "INSERT INTO Restaurants (name, address, phone, price, city, image) VALUES ('$name', '$address', '$phone', '$price', '$city','$image')";}
    if ($conn->query($sql) === TRUE) {
      echo "Restaurant added successfully.<br>";
    } else {
      echo "Error adding restaurant: " . $conn->error . "<br>";
    }
  }

  // Retrieve restaurants
  $sql = "SELECT * FROM Restaurants";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Display restaurant data in a table
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>City</th><th>Address</th><th>Phone</th><th>Price</th></tr>";

    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<form action='' method='post'>";
      echo "<td>".$row["id"]."</td>";
      echo "<td><input type='text' name='name' value='".$row["name"]."'></td>";
      echo "<td><input type='text' name='city' value='".$row["city"]."'></td>";
      echo "<td><input type='text' name='address' value='".$row["address"]."'></td>";
      echo "<td><input type='text' name='phone' value='".$row["phone"]."'></td>";
      echo "<td><input type='text' name='price' value='".$row["price"]."'></td>";
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
    echo "<td><input type='text' name='name' placeholder='Restaurant Name' required></td>";
    echo "<td><input type='text' name='city' placeholder='Restaurant City' required></td>";
    echo "<td><input type='text' name='address' placeholder='Restaurant Address' required></td>";
    echo "<td><input type='text' name='phone' placeholder='Restaurant Phone' required></td>";
    echo "<td><input type='text' name='price' placeholder='Restaurant Price' required></td>";
    echo "<td><input type='submit' name='add' value='Add'></td>";
    echo "</form>";
    echo "</tr>";

    echo "</table>";
  } else {
    echo "No restaurants found.";
  }

  // Close the database connection
  $conn->close();
  ?>
</body>
</html>
