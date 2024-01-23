<?php
// Database configuration
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

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the post ID and the comment text
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['comment_text'];

    // SQL to insert the new comment into the database
    $sql = "INSERT INTO comments (post_id, comment_text) VALUES (?, ?)";

    // Prepare statement
    $stmt = sqlsrv_prepare($conn, $sql, array(&$post_id, &$comment_text));
    
    // Execute the statement
    if (sqlsrv_execute($stmt)) {
        echo "Comment added successfully.";
        // Redirect back to the blog post or some other page
        header("Location: blog_post.php?id=" . $post_id);
    } else {
        echo "Error adding comment.";
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
