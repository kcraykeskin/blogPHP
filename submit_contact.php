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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['question'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $question = $_POST['question'];

    // SQL to insert the contact information into the database
    $sql = "INSERT INTO contacts (name, surname, email, question) VALUES (?, ?, ?, ?)";

    // Prepare statement
    $stmt = sqlsrv_prepare($conn, $sql, array(&$name, &$surname, &$email, &$question));
    
    // Execute the statement
    if (sqlsrv_execute($stmt)) {
        echo "<button onclick=\"window.location.href='blog.html'\">Return Home</button>";
    } else {
        echo "Error submitting your question.";
        die(formatErrors(sqlsrv_errors()));
    }
}

// Function to format errors
function formatErrors($errors)
{
    // Display errors
    echo "Error information: ";

    foreach ($errors as $error) {
        echo "SQLSTATE: ".$error['SQLSTATE']."";
        echo "Code: ".$error['code']."";
        echo "Message: ".$error['message']."";
    }
}
?>
