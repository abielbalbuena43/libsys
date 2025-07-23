<?php
include __DIR__ . '/includes/connection.php';

// Get the search term
$searchTerm = isset($_GET['term']) ? $_GET['term'] : '';

// Fetch matching authors
$query = $db->prepare("SELECT authorname FROM authors WHERE authorname LIKE ? LIMIT 10");
$searchTerm = "%$searchTerm%";
$query->bind_param("s", $searchTerm);
$query->execute();

$result = $query->get_result();
$authors = [];

while ($row = $result->fetch_assoc()) {
    $authors[] = $row['authorname'];
}

// Return JSON response
echo json_encode($authors);

$query->close();
$db->close();
?>
