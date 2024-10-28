function addBook(event) {
    event.preventDefault();

    const title = document.getElementById('title').value;
    const author = document.getElementById('author').value;
    const genre = document.getElementById('genre').value;

    fetch('add_book.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ title, author, genre })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const table = document.getElementById('inventoryTable');
            const newRow = table.insertRow();
            newRow.innerHTML = `
                <td>${title}</td>
                <td>${author}</td>
                <td>${genre}</td>
                <td>
                    <button onclick="openUpdateForm('${title}', '${author}', '${genre}')">Update</button>
                    <button onclick="deleteBook('${title}')">Delete</button>
                </td>
            `;
            document.getElementById('addBookForm').reset();
            alert("Book added successfully!");
        } else {
            alert("Failed to add book.");
        }
    });
}
// Function to open the update form with pre-filled book details
// Function to open the update form with pre-filled book details
function openUpdateForm(title, author, genre) {
    // Clear the hash from the URL
    window.location.hash = 'updateBookForm';
    
    document.getElementById('updateBookForm').style.display = 'block';
    document.getElementById('updateTitle').value = title;
    document.getElementById('updateAuthor').value = author;
    document.getElementById('updateGenre').value = genre;
    document.getElementById('updateBookForm').setAttribute('data-original-title', title);
}

// Function to handle the update form submission
function submitUpdate() {
    // Store current scroll position
    sessionStorage.setItem('scrollPosition', window.scrollY);

    const originalTitle = document.getElementById('updateBookForm').getAttribute('data-original-title');
    const updatedTitle = document.getElementById('updateTitle').value;
    const updatedAuthor = document.getElementById('updateAuthor').value;
    const updatedGenre = document.getElementById('updateGenre').value;

    // Send the updated data to the PHP script for updating the database
    fetch('update_book.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            originalTitle,
            title: updatedTitle,
            author: updatedAuthor,
            genre: updatedGenre
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Book updated successfully!");
            // Clear the hash after successful update
            window.location.hash = '';
            location.reload(); // Reload the page to refresh the book list
        } else {
            alert("Failed to update book: " + (data.error || ''));
        }
    })
    .catch(error => alert(`Error: ${error.message}`));

    // Hide the update form
    document.getElementById('updateBookForm').style.display = 'none';
}

// Restore scroll position after the page loads
window.onload = function() {
    const scrollPosition = sessionStorage.getItem('scrollPosition');
    if (scrollPosition) {
        window.scrollTo(0, parseInt(scrollPosition));
        sessionStorage.removeItem('scrollPosition'); // Clear scroll position after restoring
    }
};


// Function to delete a book
function deleteBook(title) {
    // Send a request to the PHP script to delete the book from the database
    fetch('delete_book.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Book deleted successfully!");
            location.reload(); // Reload the page to refresh the book list
        } else {
            alert("Failed to delete book.");
        }
    });
}
// Function to delete a book with confirmation
function deleteBook(title) {
    const confirmed = confirm(`Are you sure you want to delete "${title}"?`);

    if (!confirmed) {
        return;
    }

    fetch('delete_book.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Book deleted successfully!");
            location.reload();
        } else {
            alert(`Failed to delete book. ${data.error || ''}`);
        }
    })
    .catch(error => alert(`Error: ${error.message}`));
}

function updateTime() {
    const currentTime = new Date().toLocaleTimeString();
    document.getElementById("currentTime").textContent = `Current Time: ${currentTime}`;
}

// Update the time every second
setInterval(updateTime, 1000);

// Display the initial time when the page loads
updateTime();
