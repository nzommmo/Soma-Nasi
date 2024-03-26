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
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../templates/login.php">Login</a>
                </li>
              
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<div class="row row-cols-1 row-cols-md-3 g-4">
<?php
// Connect to your database
require_once 'config.php';

// Query to fetch book titles, thumbnails, and infoLinks from the database
$query = "SELECT title, thumbnail, infoLink FROM Books";

// Perform the query
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    // Fetch associative array
    while ($row = mysqli_fetch_assoc($result)) {
        // Print out card with book title, thumbnail, and "Read More" button
        echo '<div class="col">
                <div class="card h-100">
                    <img src="' . $row['thumbnail'] . '" class="card-img-top" alt="' . $row['title'] . '" style="object-fit: cover; height: 400px; width:200xp">
                    <div class="card-body">
                        <h5 class="card-title">' . $row['title'] . '</h5>
                        <p class="card-text">This is a placeholder text for the book description.</p>
                        <a href="' . $row['infoLink'] . '" class="btn btn-primary">Read More</a>
                        <button class="btn btn-primary mark-as-reading" data-book-id="1">Mark as Reading</button>
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
<script src="../static/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
