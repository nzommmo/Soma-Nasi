<?php
// Include the database configuration file
include_once 'config.php';

// Check if book ID is provided
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Check if the book exists
    $query = "SELECT * FROM books WHERE id = '$book_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // If book exists, add it to the cart
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $book_title = $row['title'];

        // Insert the book into the cart
        $query = "INSERT INTO cart (user_id, book_id, quantity) VALUES (1, '$book_id', 1)";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        echo "Book '$book_title' added to cart successfully.";
    } else {
        echo "Book not found.";
    }
}

// Close database connection
mysqli_close($conn);
?>
