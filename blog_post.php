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

// SQL to get all blog posts
$sqlPost = "SELECT id, title, photo, description FROM posts ORDER BY id DESC";
$stmtPost = sqlsrv_query($conn, $sqlPost);

if ($stmtPost === false) {
    die(formatErrors(sqlsrv_errors()));
}

// Loop through each post and fetch comments
while ($post = sqlsrv_fetch_array($stmtPost, SQLSRV_FETCH_ASSOC)) {
    echo "<div class='post'>";
    echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
    echo "<img src='http://localhost/" . htmlspecialchars($post['photo']) . "' alt='Post Image'>";
    echo "<p>" . htmlspecialchars($post['description']) . "</p>";
    $postId = $post['id'];
    $sqlComments = "SELECT comment_text FROM comments WHERE post_id = ? ORDER BY id DESC";
    $stmtComments = sqlsrv_prepare($conn, $sqlComments, array(&$postId));

    // Execute the query for comments
    if (!sqlsrv_execute($stmtComments)) {
        die(formatErrors(sqlsrv_errors()));
    }

    // Comments section
    echo "<div id='comments'>";
    while ($comment = sqlsrv_fetch_array($stmtComments, SQLSRV_FETCH_ASSOC)) {
        echo "<div class='comment'>" . htmlspecialchars($comment['comment_text']) . "</div>";
    }
    echo "</div>";

    // Comment box
    echo "<form onsubmit='submitComment(event)'>";
    echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($post['id']) . "'>";
    echo "<textarea name='comment_text' required></textarea><br>";
    echo "<input type='submit' value='Add Comment'>";
    echo "</form>";
    echo "</div>"; // Closing post div
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
