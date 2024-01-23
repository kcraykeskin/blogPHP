<?php
// Database configuration and connection code
$serverName = "denemeserverr.database.windows.net"; // Your server name
$dbName = "deneme"; // Your database name
$username = "CloudSA4249ef14"; // Your username
$password = "Ilovecoffe."; // Your password

// Connection options
$connectionOptions = array(
    "Database" => $dbName,
    "Uid" => $username,
    "PWD" => $password
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(formatErrors(sqlsrv_errors()));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'], $_POST['description'])) {
    $title = $_POST['title'];
    $photo = $_POST['photo']; // Optional: Handle the case when photo URL is not provided
    $description = $_POST['description'];

    // SQL to insert the new post into the database
    $sql = "INSERT INTO posts (title, photo, description) VALUES (?, ?, ?)";

    // Prepare statement
    $stmt = sqlsrv_prepare($conn, $sql, array(&$title, &$photo, &$description));
    
    if (sqlsrv_execute($stmt)) {
        echo "New post created successfully.";
    } else {
        echo "Error creating post.";
        die(formatErrors(sqlsrv_errors()));
    }
}


// Function to format errors
function formatErrors($errors)
{
    // Display errors
    echo "Error information: <br>";

    foreach ($errors as $error) {
        echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
        echo "Code: " . $error['code'] . "<br>";
        echo "Message: " . $error['message'] . "<br>";
    }
}
?>
