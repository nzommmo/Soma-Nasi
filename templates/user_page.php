<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>HomePage!</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Genre
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Thriller</a></li>
                        <li><a class="dropdown-item" href="#">Fantasy</a></li>
                        <li><a class="dropdown-item" href="#">Fiction</a></li>
                    </ul>
                </li>
            </ul>
            <!-- Cart section in the navbar -->
            <div class="d-flex">
                <div class="nav-item">
                    <a class="nav-link" href="#" id="cart-link">Cart <span id="cart-counter">Items in Cart: 0</span></a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3>Featured Books</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    // Connect to your database
    require_once 'config.php';

    // Query to fetch book titles, thumbnails, and infoLinks from the database
    $query = "SELECT id, title, thumbnail, infoLink FROM Books";

    // Perform the query
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if ($result) {
        // Fetch associative array
        while ($row = mysqli_fetch_assoc($result)) {
            // Print out card with book title, thumbnail, and "Read More" button
            echo '<div class="col">
                    <div class="card h-100">
                        <img src="' . $row['thumbnail'] . '" class="card-img-top" alt="' . $row['title'] . '" style="object-fit: cover; height: 400px; width:200px">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['title'] . '</h5>
                            <p class="card-text">This is a placeholder text for the book description.</p>
                            <a href="' . $row['infoLink'] . '" class="btn btn-primary">Read More</a>
                            <button class="btn btn-primary add-to-cart" data-book-id="' . $row['id'] . '">Add to Cart</button>
                        </div>
                    </div>
                </div>';
        }
        
        // Free result set
        mysqli_free_result($result);
    } else {
        // Print error message if query fails
        echo "Error: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
    ?>
    </div>
</div>
<!-- Cart items modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cart-items">
                <!-- Cart items will be displayed here -->
                sjdskfdsk
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter for number of items in the cart
    let cartItemCount = 0;
    const cartCounter = document.getElementById('cart-counter');
    const cartLink = document.getElementById('cart-link');
    const cartItemsDiv = document.getElementById('cart-items');

    // Add click event listener to all "Add to Cart" buttons
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the book ID from the data-book-id attribute
            const bookId = this.getAttribute('data-book-id');
            
            // Send an AJAX request to add the book to the cart
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_status.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Display success message
                    alert('Book added to cart!');
                    // Increment cart item count
                    cartItemCount++;
                    cartCounter.textContent = `Items in Cart: ${cartItemCount}`;
                } else {
                    // Display error message
                    alert('Failed to add book to cart. Please try again later.');
                }
            };
            // Send book ID as a parameter in the request
            xhr.send('id=' + bookId);
        });
    });

    // Updated JavaScript code

// Show cart modal when cart link is clicked
cartLink.addEventListener('click', function() {
    const cartModal = new bootstrap.Modal(document.getElementById('cartModal'), {
        keyboard: false
    });
    cartModal.show();
    
    // Fetch and display cart items
    fetch('update_status.php') // Use the correct URL to match your PHP script
        .then(response => response.text())
        .then(data => {
            cartItemsDiv.innerHTML = data; // Update cart-items div with fetched cart items
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
});

});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist
