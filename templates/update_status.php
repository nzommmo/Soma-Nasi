<?php
// Start the session to retrieve user information
session_start();

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    // Connect to your database
    require_once 'config.php';

    // Check if book ID is set
    if(isset($_POST['book_id'])) {
        // Retrieve book ID from the POST data
        $bookId = $_POST['book_id'];

        // Retrieve user ID from the session
        $userId = $_SESSION['user_id'];

        // Prepare the SQL query to insert into the cart
        $query = "INSERT INTO Cart (user_id, book_id) VALUES ($userId, $bookId)";

        // Perform the query
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            // Print success message or perform any other action if needed
            echo "Book added to cart successfully!";
        } else {
            // Print error message if query fails
            echo "Error: " . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    } else {
        // If book ID is not set, handle the error accordingly
        echo "Error: Book ID not provided!";
    }
} else {
    // If user is not logged in, handle the error accordingly
    echo "Error: User not logged in!";
}
?>
