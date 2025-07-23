<?php


include __DIR__ . '/includes/connection.php'; 
include __DIR__ . '/includes/admin_navbar.php';
include __DIR__ . '/mailer.php';
include __DIR__ . '/logger.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="edit-profile-container">
        <?php
            $id = $_GET['ed1'];
            // Modify the query to include both student and employee info
            $q = "SELECT issueid, 
                        IFNULL(student.studentid, employee.id) AS studentid, 
                        IFNULL(student.fname, employee.fname) AS fname, 
                        IFNULL(student.lname, employee.lname) AS lname, 
                        IFNULL(student.Email, employee.email) AS Email, 
                        IFNULL(student.lrn, employee.employee_id) AS lrn, 
                        IFNULL(student.studentpic, employee.pic) AS studentpic, 
                        books.bookid, 
                        bookname, 
                        ISBN, 
                        price, 
                        bookpic, 
                        authors.authorname, 
                        category.categoryname 
                FROM issueinfo 
                LEFT JOIN student ON student.studentid = issueinfo.studentid 
                LEFT JOIN employee ON employee.id = issueinfo.studentid 
                INNER JOIN books ON issueinfo.bookid = books.bookid 
                JOIN authors ON authors.authorid = books.authorid 
                JOIN category ON category.categoryid = books.categoryid 
                WHERE issueid = '".$_GET['issueid']."'";

            $res = mysqli_query($db, $q) or die(mysqli_error($db));
            
            while($row = mysqli_fetch_assoc($res)) {
                $email = $row['Email'];
                $issueid = $row['issueid'];
                $bookid = $row['bookid'];
                $pic = $row['bookpic'];
                $bookname = $row['bookname'];
                $borrowername = $row['fname'] . ' ' . $row['lname'];
                $lrn = $row['lrn'];
                $studentid = $row['studentid'];
                $price = $row['price'];
            }
        ?>
        <div class="form issue-book-container">
            <div class="form-container" style="height:375px;">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Issue Book</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <input type="text" name="issueid" style="display:none;" value="<?php echo $issueid ?>">
                    <input type="text" name="email" style="display:none;" value="<?php echo $email ?>">
                    <input type="text" name="book" style="display:none;" value="<?php echo $bookname ?>">
                    <input type="text" name="price" style="display:none;" value="<?php echo $price ?>">
                    <input type="text" name="name" style="display:none;" value="<?php echo $borrowername ?>">
                    <input type="text" name="lrn" style="display:none;" value="<?php echo $lrn ?>">
                    <input type="text" name="studentid" style="display:none;" value="<?php echo $studentid ?>">

                    <div class="label book-img">
                        <?php echo "<img width='200px' height='200px' src='images/".$pic."'>"?>
                    </div>
                    <div class="label">
                        <label for="studentid">Book ID : </label>
                        <b style="font-size: 15px;">
                        <?php
                            echo $bookid;
                        ?>
                        </b><br>
                    </div>
                    <div class="label">
                        <label for="bookname">Book Name : <?php echo $bookname; ?></label>
                    </div>
                    <div class="label">
                        <label for="authorname">Borrower Name : <?php echo $borrowername;?></label>
                    </div>
                    <div class="label">
                        <label for="ISBN">Return Date : </label>
                    </div>
                    <?php
                    $today = date("Y-m-d");
                    $three_days_later = date("Y-m-d", strtotime("+3 days"));
                    ?>
                    <input type="date" name="returndate" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $three_days_later; ?>" required>
                    <button type="submit" class="btn" name="submit">Issue</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit'])) {
            $borrowername = $_POST['name'];
            $lrn = $_POST['lrn'];
            $studentid = $_POST['studentid'];
            $issueid = $_POST['issueid'];
            $returndate = $_POST['returndate'];
            $email = $_POST['email'];
            $book = $_POST['book'];
            $fine = $_POST['price'];
            $var = '<p class="issued-pill">ISSUED</p>';
        
            $q2 = "SELECT COUNT(*) as issued_count FROM issueinfo WHERE studentid = '".$studentid."' AND approve = '".$var."'";
            $result = mysqli_query($db, $q2);
            $row = mysqli_fetch_assoc($result);
            
            if ($row['issued_count'] >= 2) {
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Warning!",
                        text: "This student still has already 2 issued books. Cannot issue more.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "request_info.php";
                    });
                </script>
                <?php
            } else {
                $q1 = "UPDATE issueinfo SET issuedate = NOW(), duedate = '".$returndate."', approve = '".$var."', fine = '".$fine."' WHERE issueid = '".$issueid."';";
                if (mysqli_query($db, $q1)) {   
                    include "invoice.php";
                    logger($db, $_SESSION['userid'], '1', 'Issued book "'.$book.'" with return date "'.$returndate.'"');
        
                    $message = "Hi there,<br><br>
                    Thank you for using DPNHS library services. The book you are borrowing, '<b>$book</b>', has been approved and issued. You may claim it now at our library. Please return this book by <b>$returndate</b>.<br><br>
                    Thanks,<br>
                    DPNHS Library";
                    
                    $mail->setFrom('delapaznhs11@gmail.com', 'DPNHS Library');
                    $mail->addAddress($email);
                    $mail->Subject = 'Book Issuance';
                    $mail->Body = $message;
                    $mail->addAttachment(__DIR__ . "/receipt/receipt.pdf");
            
                    if (!$mail->send()) {
                        echo 'Message could not be sent.';
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    } else {
                        'Message has been sent';
                    }
        
                    ?>
                    <script type="text/javascript">
                        Swal.fire({
                            title: "Success!",
                            text: "Book issued successfully.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "request_info.php";
                        });
                    </script>
                    <?php
                }
            }
        }        
		?>
    <!-- <div class="footer">
        <div class="footer-row">
            <div class="footer-left">
                <h1>Opening Hours</h1>
                <p><i class="far fa-clock"></i>Monday to Friday - 9am to 9pm</p>
                <p><i class="far fa-clock"></i>Saturday to Sunday - 8am to 11pm</p>
            </div>
            <div class="footer-right">
                <h1>Get In Touch</h1>
                <p>#30 abc Colony, xyz City IN<i class="fas fa-map-marker-alt"></i></p>
                <p>example@website.com<i class="fas fa-paper-plane"></i></p>
                <p>+8801515637957<i class="fas fa-phone-alt"></i></p>
            </div>
        </div>
        <div class="social-links">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-instagram-square"></i>
            <i class="fab fa-youtube"></i>
            <p>&copy; 2021 Copyright by Nazre Imam Tahmid</p>
        </div>
    </div> -->
</body>
</html>