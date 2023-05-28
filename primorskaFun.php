
	<?php
include "db_conn.php";

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$userid = $_SESSION['id'];

// Handle ad submission
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $people = $_POST['people'];
    $phone = $_POST['phone'];

    // Check if all fields are filled
    if (!empty($title) && !empty($description) && !empty($location) && !empty($people) && !empty($phone)) {
        $insertQuery = "INSERT INTO Ad (title, user_id, description, location, people, phone) VALUES ('$title', $userid, '$description', '$location', $people, '$phone')";
        mysqli_query($conn, $insertQuery);

        // Redirect back to the primorskaFun page to see the updated ads
        header("Location: primorskaFun.php");
        exit();
    } else {
        $error = "All fields are required.";
    }
}

// Handle ad deletion
if (isset($_POST['delete'])) {
    $adId = $_POST['ad_id'];
    $deleteQuery = "DELETE FROM Ad WHERE id = $adId AND user_id = $userid";
    mysqli_query($conn, $deleteQuery);

    // Redirect back to the primorskaFun page to see the updated ads
    header("Location: primorskaFun.php");
    exit();
}

// Fetch all ads from the database
$query = "SELECT * FROM Ad ORDER BY date DESC";
$result = mysqli_query($conn, $query);
$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
include "header.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Primorska Fun - Ads</title>
    <link rel="stylesheet" type="text/css" href="stylePrimorskaFun.css">
</head>
<body >
	<main style = "margin : 20px">
		<h2>Student Organizations</h2>

		<ul class="org-list">
			<li>
				<h3>SOUP - Student organization University of Primorska</h3>
				<p>SOUP is a student organization at the University of Primorska that provides various activities and opportunities for students to engage in the academic and social life of the university. The organization is run by students, for students, and strives to promote student involvement in university decision-making and to enhance the student experience.</p>
				<a href="https://soup.si/sl">See Events</a>
			</li>
			<li>
				<h3>ESN - Erasmus Student Network</h3>
				<p>ESN is a student organization at the University of Primorska that provides support and assistance to international students who are studying at the university. The organization provides a variety of services and activities, such as language courses, cultural events, and social gatherings, to help international students integrate into the university and the local community.</p>
				<a href="https://accounts.esn.org/section/si-kope-pri">See Events</a>
			</li>
			<li>
				<h3>FAMNIT Student Council</h3>
				<p>The FAMNIT Student Council is a student organization that represents the interests and concerns of students in the Faculty of Mathematics, Natural Sciences and Information Technologies at the University of Primorska. The organization works to improve the quality of education and student life in the faculty and to foster a sense of community and collaboration among students.</p>
				<a href="https://www.famnit.upr.si/sl/studenti/studentski-svet">See Events</a>
			</li>
		</ul>
        <div>
            <h2>Ads</h2>
        </div>
    <div class="ads">
        <?php if (!empty($ads)) : ?>
            <?php foreach ($ads as $ad) : 
				$adOwner = $ad['user_id'];
				$query = "SELECT name,surname FROM `User` WHERE id= $adOwner";
				$result= mysqli_query($conn, $query);
				$row = mysqli_fetch_assoc($result);
				$name = $row['name'];
				$surname = $row['surname'];
				?>
                <div class="ad" style = "margin: 20px">
                    <h3><?php echo $ad['title']; ?> by <?php echo $name . " " . $surname; ?></h3>
                    <p>Description: <?php echo $ad['description']; ?></p>
                    <p>Location: <?php echo $ad['location']; ?></p>
                    <p>People: <?php echo $ad['people']; ?></p>
                    <p>Contact: <?php echo $ad['phone']; ?></p>
                    <?php if ($ad['user_id'] == $userid) : ?>
                        <!-- Display delete button for ads posted by the current user -->
                        <form method="post" action="primorskaFun.php">
                            <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    <?php endif; ?>
                </div>
            
            <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No ads available.</p>
        <?php endif; ?>
    <div class = "createAd">
        <h2>Create an Ad</h2>
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="primorskaFun.php">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required><br>

            <label for="people">Number of People:</label>
            <input type="number" id="people" name="people" required><br>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required><br>

            <input type="submit" name="submit" value="Post Ad">
        </form>
        </div>
    </div>
	</main>
   
</body>
</html>
