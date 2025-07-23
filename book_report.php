<?php
include __DIR__ . '/includes/connection.php';

// Fetch the date range from the GET request if provided
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Prepare WHERE conditions for the date range filter
$date_condition = '';
if ($start_date && $end_date) {
    $date_condition = "AND issuedate BETWEEN '$start_date' AND '$end_date'";
}

// Number of Borrowed Books
$borrowed_books_query = "SELECT COUNT(*) AS borrowed_books FROM issueinfo WHERE approve = '<p class=\"issued-pill\">ISSUED</p>' $date_condition";
$borrowed_books_result = $db->query($borrowed_books_query);
$borrowed_books = $borrowed_books_result->fetch_assoc()['borrowed_books'];

// Number of Overdue Books
$overdue_books_query = "SELECT COUNT(*) AS overdue_books FROM issueinfo WHERE approve = '<p class=\"expired-pill\">OVERDUE</p>' $date_condition";
$overdue_books_result = $db->query($overdue_books_query);
$overdue_books = $overdue_books_result->fetch_assoc()['overdue_books'];

// Number of Returned Books
$returned_books_query = "SELECT COUNT(*) AS returned_books FROM issueinfo WHERE approve = '<p class=\"approve-return-pill\">RETURNED</p>' $date_condition";
$returned_books_result = $db->query($returned_books_query);
$returned_books = $returned_books_result->fetch_assoc()['returned_books'];

// Number of Discarded/Stolen/Lost Books
$discarded_books_query = "SELECT COUNT(*) AS discarded_books FROM issueinfo WHERE approve IN ('<p class=\"stolen-pill\">STOLEN</p>', '<p class=\"lost-pill\">LOST</p>', '<p class=\"discarded-pill\">DISCARDED</p>') $date_condition";
$discarded_books_result = $db->query($discarded_books_query);
$discarded_books = $discarded_books_result->fetch_assoc()['discarded_books'];

// Number of Book Request
$book_request_query = "SELECT COUNT(*) AS book_requests FROM issueinfo WHERE approve = '' $date_condition";
$book_request_result = $db->query($book_request_query);
$book_request = $book_request_result->fetch_assoc()['book_requests'];

// Count Number of Books in books table
$books_query = "SELECT COUNT(*) AS total_books FROM books";
$books_result = $db->query($books_query);
$total_books = $books_result->fetch_assoc()['total_books'];

// Count Number of Members 
$members_query = "SELECT 
    (SELECT COUNT(*) FROM employee) AS employee_count,
    (SELECT COUNT(*) FROM student) AS student_count";
$members_result = $db->query($members_query);
$members_row = $members_result->fetch_assoc();
$total_members = $members_row['employee_count'] + $members_row['student_count'];

// Count Number of Active Members 
$active_members_query = "SELECT 
    (SELECT COUNT(*) FROM student WHERE status = 1) AS active_students,
    (SELECT COUNT(*) FROM employee) AS active_employees"; 
$active_members_result = $db->query($active_members_query);
$active_members_row = $active_members_result->fetch_assoc();
$active_members = $active_members_row['active_students'] + $active_members_row['active_employees'];

// Most Borrowed Book
$most_borrowed_book_query = "
    SELECT books.bookname, COUNT(issueinfo.bookid) AS borrow_count
    FROM issueinfo
    INNER JOIN books ON issueinfo.bookid = books.bookid
    GROUP BY issueinfo.bookid
    ORDER BY borrow_count DESC
    LIMIT 1";
$most_borrowed_book_result = $db->query($most_borrowed_book_query);
$most_borrowed_book = $most_borrowed_book_result->fetch_assoc()['bookname'];

// Least Borrowed Book
$least_borrowed_book_query = "
    SELECT books.bookname, COUNT(issueinfo.bookid) AS borrow_count
    FROM issueinfo
    INNER JOIN books ON issueinfo.bookid = books.bookid
    GROUP BY issueinfo.bookid
    ORDER BY borrow_count ASC
    LIMIT 1";
$least_borrowed_book_result = $db->query($least_borrowed_book_query);
$least_borrowed_book = $least_borrowed_book_result->fetch_assoc()['bookname'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
    </style>
    <script>
        window.onload = function() {
            window.print(); 
        };

        window.onafterprint = function() {
            window.close();
        };
    </script>
</head>
<body>

<h2>Book Report</h2>
<?php if ($start_date && $end_date): ?>
    <p>Date Range: <?php echo htmlspecialchars($start_date); ?> to <?php echo htmlspecialchars($end_date); ?></p>
<?php endif; ?>

<table>
    <tr>
        <th>Category</th>
        <th>Count</th>
    </tr>
    <tr>
        <td>Number of Borrowed Books</td>
        <td><?php echo $borrowed_books; ?></td>
    </tr>
    <tr>
        <td>Number of Overdue Books</td>
        <td><?php echo $overdue_books; ?></td>
    </tr>
    <tr>
        <td>Number of Returned Books</td>
        <td><?php echo $returned_books; ?></td>
    </tr>
    <tr>
        <td>Number of Discarded/Stolen/Lost Books</td>
        <td><?php echo $discarded_books; ?></td>
    </tr>
    <tr>
        <td>Number of Books</td>
        <td><?php echo $total_books; ?></td>
    </tr>
    <tr>
        <td>Total Number of Members</td>
        <td><?php echo $total_members; ?></td>
    </tr>
    <tr>
        <td>Total Number of Active Members</td>
        <td><?php echo $active_members; ?></td>
    </tr>
    <tr>
        <td>Most Borrowed Book</td>
        <td><?php echo $most_borrowed_book; ?></td>
    </tr>
    <tr>
        <td>Least Borrowed Book</td>
        <td><?php echo $least_borrowed_book; ?></td>
    </tr>
    <tr>
        <td>Number of Book Request</td>
        <td><?php echo $book_request; ?></td>
    </tr>
</table>

</body>
</html>
