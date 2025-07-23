<?php
include './includes/connection.php'; 
include './logger.php';

if (isset($_POST['bookid'])) {
    $bookid = $_POST['bookid']; 
    session_start(); 

    $studentid_query = mysqli_query($db, "SELECT studentid FROM student WHERE student_username='{$_SESSION['login_student_username']}';");
    $studentid_row = mysqli_fetch_assoc($studentid_query);
    $studentid = $studentid_row['studentid'];
    $var1 = '<p class="issued-pill">ISSUED</p>';

    $issue_check_query = mysqli_query($db, "SELECT * FROM issueinfo WHERE studentid='$studentid' AND bookid='$bookid' AND approve = '$var1'");

    if (mysqli_num_rows($issue_check_query) > 0) {
        $issue_row = mysqli_fetch_assoc($issue_check_query);
        $issueid = $issue_row['issueid'];
        $current_date = date("Y-m-d");
        $var2 = '<p class="pending-pill">PENDING RETURN</p>';

        mysqli_query($db, "UPDATE issueinfo SET returndate='$current_date', approve='$var2' WHERE issueid='$issueid'");
        mysqli_query($db, "DELETE FROM timer WHERE stdid='$studentid' AND bid='$bookid';");

        $quantity_check_query = mysqli_query($db, "SELECT quantity FROM books WHERE bookid=$bookid;");
        $quantity_row = mysqli_fetch_assoc($quantity_check_query);
        if ($quantity_row['quantity'] == 0) {
            mysqli_query($db, "UPDATE books SET quantity=quantity+1, status='Available' WHERE bookid=$bookid;");
        } else {
            mysqli_query($db, "UPDATE books SET quantity=quantity+1 WHERE bookid=$bookid;");
        }

        logger($db, $_SESSION['userid'], '0', 'Returned a book with issue id "'.$issueid.'"');
        echo json_encode(['success' => true, 'message' => 'Book returned successfully.', 'action' => 'return']);
    } else {
        $var = '<p class="expired-pill">EXPIRED</p>';
        $var2 = '<p class="pending-pill">PENDING RETURN</p>';
        $total_requests_query = mysqli_query($db, "SELECT * FROM issueinfo WHERE studentid=$studentid AND (approve=' ' OR approve='$var' OR approve='$var2');");
        $total_requests = mysqli_num_rows($total_requests_query);

        if ($total_requests >= 3) {
            echo json_encode(['success' => false, 'message' => 'You already requested three books. You must return one book first.']);
        } else {
            $book_check_query = mysqli_query($db, "SELECT * FROM books WHERE bookid=$bookid AND status='Available';");
            if (mysqli_num_rows($book_check_query) != 0) {
                mysqli_query($db, "INSERT INTO issueinfo VALUES(NULL, '$studentid', '$bookid', '', '', '', '', '');");
                mysqli_query($db, "UPDATE books SET quantity=quantity-1 WHERE bookid=$bookid;");
                $quantity_check_query = mysqli_query($db, "SELECT quantity FROM books WHERE bookid=$bookid;");
                $quantity_row = mysqli_fetch_assoc($quantity_check_query);
                if ($quantity_row['quantity'] == 0) {
                    mysqli_query($db, "UPDATE books SET status='Not Available' WHERE bookid=$bookid;");
                }
                echo logger($db, $_SESSION['userid'], '0', 'Requested a book with id "'.$bookid.'"');
                
                echo json_encode(['success' => true, 'message' => 'Book requested successfully.', 'action' => 'request']);
            } else {
                echo json_encode(['success' => false, 'message' => 'This book is not available for request.']);
            }
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No scanned data provided.']);
}
