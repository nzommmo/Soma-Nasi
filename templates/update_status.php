// update_status.php - PHP script to handle AJAX request and update book status
<?php
// Connect to the database
require_once 'config.php';

// Check if book ID and status are provided in the POST request
if (isset($_POST['title']) && isset($_POST['reading_status'])) {
    $title = $_POST['title'];
    $status = $_POST['reading_status'];

    // Validate the status (optional)
    // Perform necessary validation here

    // Update the status of the book in the database
    $query = "UPDATE Books SET reading_status = ? WHERE title = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $status, $bookId);
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Return success response
        http_response_code(200);
        echo 'Book status updated successfully';
    } else {
        // Return error response
        http_response_code(500);
        echo 'Error updating book status';
    }

    // Close statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Return error response if required parameters are not provided
    http_response_code(400);
    echo 'Missing parameters';
}
?>
