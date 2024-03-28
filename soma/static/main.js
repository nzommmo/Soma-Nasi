// JavaScript to handle button click and send AJAX request
document.addEventListener('DOMContentLoaded', function () {
    // Get all buttons with class 'mark-as-reading'
    var markButtons = document.querySelectorAll('.mark-as-reading');

    // Add click event listener to each button
    markButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Get the book ID from the data-book-id attribute
            var bookId = button.getAttribute('data-book-id');

            // Send an AJAX request to update the status of the book
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Handle success response
                    alert('Book status updated successfully');
                    // Optionally, update the UI to reflect the new status
                } else {
                    // Handle error response
                    alert('Error updating book status');
                }
            };
            xhr.onerror = function () {
                // Handle network errors
                console.error('Network error occurred');
            };
            xhr.send('book_id=' + encodeURIComponent(bookId) + '&status=reading');
        });
    });
});
