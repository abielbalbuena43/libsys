<?php
include './includes/connection.php'; // Include your database connection

if (isset($_POST['scanned_data'])) {
    $scanned_data = $_POST['scanned_data'];

    // Query the database for the book with the scanned ID
    $sql = "SELECT * FROM books join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid WHERE bookid = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $scanned_data);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();

        // Return the book details as JSON
        echo json_encode([
            'success' => true,
            'book' => $book
        ]);
    } else {
        // No book found
        echo json_encode([
            'success' => false
        ]);
    }
} else {
    echo json_encode([
        'success' => false
    ]);
}
?>
