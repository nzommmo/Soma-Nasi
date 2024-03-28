<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<h2>Books List</h2>

<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Include the database configuration file
    include_once 'config.php';

    // Fetch all books from the database
    $query = "SELECT * FROM Books";
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Display all books
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if the book is already in the cart
        $user_id = 1; // Change this to the actual user ID
        $book_id = $row['id'];

        // Prepare a select statement to check if the book is in the cart
        $check_query = "SELECT * FROM Cart WHERE user_id = ? AND book_id = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "is", $user_id, $book_id);
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (!$check_result) {
            die("Check query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($check_result) > 0) {
            // Book is already in the cart, display a message instead of the "Add to Cart" button
            echo "<tr>";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['author']}</td>";
            echo "<td>Already in Cart</td>";
            echo "</tr>";
        } else {
            // Book is not in the cart, display the "Add to Cart" button
            echo "<tr>";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['author']}</td>";
            echo "<td><a href='add_to_cart.php?book_id={$row['id']}'>Add to Cart</a></td>";
            echo "</tr>";
        }
    }

    // Close database connection
    mysqli_close($conn);
    ?>
    </tbody>
</table>

</body>
</html>
