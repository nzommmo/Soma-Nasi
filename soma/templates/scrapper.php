<?php
require_once 'config.php'; // Include the database configuration file

$API_KEY = "AIzaSyDTyyjLkecCLqL_U31T6R2uzucT1Cikeuo"; // Replace with your Google Books API key

function scrapeAndUploadBooks() {
    $url = 'https://www.googleapis.com/books/v1/volumes?q=flowers&orderBy=newest&key=AIzaSyDTyyjLkecCLqL_U31T6R2uzucT1Cikeuo'; // URL of the Google Books API

    // Fetch the content from the URL
    $json = file_get_contents($url);

    if ($json === false) {
        // Handle error if unable to fetch content
        echo "Error fetching URL";
    } else {
        // Decode JSON response
        $data = json_decode($json, true);

        // Check if the response contains items
        if (isset($data['items'])) {
            $books = $data['items'];

            global $conn; // Access the database connection from config.php

            // Insert new books into the database
            foreach ($books as $book) {
                $id = mysqli_real_escape_string($conn, $book['id']);
                $title = mysqli_real_escape_string($conn, $book['volumeInfo']['title']);
                $authors = isset($book['volumeInfo']['authors']) ? implode(', ', $book['volumeInfo']['authors']) : '';
                $publisher = mysqli_real_escape_string($conn, $book['volumeInfo']['publisher']);
                $publishedDate = mysqli_real_escape_string($conn, $book['volumeInfo']['publishedDate']);
                $description = mysqli_real_escape_string($conn, $book['volumeInfo']['description']);
                $isbn_10 = isset($book['volumeInfo']['industryIdentifiers'][0]['identifier']) ? mysqli_real_escape_string($conn, $book['volumeInfo']['industryIdentifiers'][0]['identifier']) : '';
                $isbn_13 = isset($book['volumeInfo']['industryIdentifiers'][1]['identifier']) ? mysqli_real_escape_string($conn, $book['volumeInfo']['industryIdentifiers'][1]['identifier']) : '';
                $pageCount = isset($book['volumeInfo']['pageCount']) ? $book['volumeInfo']['pageCount'] : 0;
                $averageRating = isset($book['volumeInfo']['averageRating']) ? $book['volumeInfo']['averageRating'] : 0.0;
                $ratingsCount = isset($book['volumeInfo']['ratingsCount']) ? $book['volumeInfo']['ratingsCount'] : 0;
                $smallThumbnail = isset($book['volumeInfo']['imageLinks']['smallThumbnail']) ? mysqli_real_escape_string($conn, $book['volumeInfo']['imageLinks']['smallThumbnail']) : '';
                $thumbnail = isset($book['volumeInfo']['imageLinks']['thumbnail']) ? mysqli_real_escape_string($conn, $book['volumeInfo']['imageLinks']['thumbnail']) : '';
                $pdfDownloadLink = isset($book['accessInfo']['pdf']['isAvailable']) && $book['accessInfo']['pdf']['isAvailable'] ? mysqli_real_escape_string($conn, $book['accessInfo']['pdf']['acsTokenLink']) : '';
                $language = mysqli_real_escape_string($conn, $book['volumeInfo']['language']);
                $infoLink = mysqli_real_escape_string($conn, $book['volumeInfo']['infoLink']);
                $canonicalVolumeLink = mysqli_real_escape_string($conn, $book['volumeInfo']['canonicalVolumeLink']);
                $isEbook = isset($book['saleInfo']['isEbook']) ? $book['saleInfo']['isEbook'] : false;
                $retailPrice = isset($book['saleInfo']['retailPrice']['amount']) ? $book['saleInfo']['retailPrice']['amount'] : 0.0;
// Check if published date is available
// Check if published date is available
if (!empty($book['volumeInfo']['publishedDate'])) {
    // If published date is available, format it correctly
    $publishedDate = date('Y-m-d', strtotime($book['volumeInfo']['publishedDate']));
    // Escape the formatted date and include it in the SQL query
    $publishedDate = mysqli_real_escape_string($conn, $publishedDate);
} else {
    // If published date is not available, set it to NULL
    $publishedDate = "NULL";
}

// SQL query to insert data into the database
$sql = "INSERT INTO Books (id, title, author, publisher, publishedDate, description, isbn_10, isbn_13, pageCount, averageRating, ratingsCount, smallThumbnail, thumbnail, pdfDownloadLink, language, infoLink, canonicalVolumeLink, isEbook, retailPrice) VALUES ('$id', '$title', '$authors', '', $publishedDate, '', '', '', $pageCount, $averageRating, $ratingsCount, '$smallThumbnail', '$thumbnail', '', '$language', '$infoLink', '$canonicalVolumeLink', 0, 0.0)";

                if (mysqli_query($conn, $sql)) {
                    echo "New book inserted successfully: $title <br>";
                } else {
                    echo "Error inserting new book: $title <br>";
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        } else {
            echo "No books found in the response";
        }
    }
}

// Run the scraping and uploading function
scrapeAndUploadBooks();
?>
