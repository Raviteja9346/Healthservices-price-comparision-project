<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Reviews and Ratings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        .review {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .review p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Doctor Reviews and Ratings</h2>

    <?php
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "specialist";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve doctor_id from user input (assuming it's passed via GET method)
    if (isset($_GET['id'])){ 
        $id = $_GET['id'];

        // SQL query to fetch reviews and ratings for the specified doctor_id
        $sql = "SELECT review, rating FROM reviews WHERE id = ?";
        
        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("i", $id);  // Assuming doctor_id is an integer
        
        // Execute the query
        $stmt->execute();
        
        // Store result
        $stmt->store_result();
        
        // Bind result variables
        $stmt->bind_result($review, $rating);
        
        // Check if reviews exist for the doctor_id
        if ($stmt->num_rows > 0) {
            // Output reviews and ratings
            while ($stmt->fetch()) {
                echo '<div class="review">';
                echo '<p><strong>Review:</strong> ' . htmlspecialchars($review) . '</p>';
                echo '<p><strong>Rating:</strong> ' . htmlspecialchars($rating) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No reviews found for Doctor ID: ' . htmlspecialchars($id) . '</p>';
        }
        
        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
    ?>

    <p><a href="javascript:history.go(-1)">Go Back</a></p>
</div>

</body>
</html>
