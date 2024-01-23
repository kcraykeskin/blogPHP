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

    // SQL to get the user with the given username
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array(&$username));

    // Execute the query
    if (sqlsrv_execute($stmt)) {
        if ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                header("Location: blog.html");
            } else {
                echo "Invalid username or password.";
            }
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Error logging in.";
        die(formatErrors(sqlsrv_errors()));
    }
}
?>
