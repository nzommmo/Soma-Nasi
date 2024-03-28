<?php
// Include the database configuration file
include_once 'config.php';

// User ID (for demonstration purposes, you can replace it with the actual user ID logic)
$user_id = 1;

// Fetch cart items for the user
$query = "SELECT books.title, books.author FROM cart INNER JOIN books ON cart.book_id = books.id WHERE cart.user_id = '$user_id'";
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Display cart items
echo "<h2>Cart Items</h2>";
echo "<ul>";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>{$row['title']} by {$row['author']}</li>";
    }
} else {
    echo "<li>No items in the cart.</li>";
}
echo "</ul>";

// Close database connection
mysqli_close($conn);
?>
