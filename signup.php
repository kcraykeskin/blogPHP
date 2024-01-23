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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL to insert the new user into the database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    // Prepare statement
    $stmt = sqlsrv_prepare($conn, $sql, array(&$username, &$hashedPassword));
    
    // Execute the statement
    if (sqlsrv_execute($stmt)) {
        echo "User registered successfully.";
        // Redirect to login page
        header("Location: login.html");
    } else {
        echo "Error registering user.";
        die(formatErrors(sqlsrv_errors()));
    }
}
?>
