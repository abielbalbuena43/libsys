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
			
			$id=$_GET['ed1'];
            $q = "SELECT issueid, 
            IFNULL(student.studentid, employee.id) AS studentid, 
            IFNULL(student.fname, employee.fname) AS fname, 
            IFNULL(student.lname, employee.lname) AS lname, 
            IFNULL(student.Email, employee.email) AS Email, 
            IFNULL(student.lrn, employee.id) AS lrn, 
            IFNULL(student.studentpic, employee.pic) AS studentpic, 
            books.bookid, 
            bookname, 
            ISBN, 
            price, 
            bookpic, 
            authors.authorname, 
            category.categoryname,
            approve,
            fine
            FROM issueinfo 
            LEFT JOIN student ON student.studentid = issueinfo.studentid 
            LEFT JOIN employee ON employee.id = issueinfo.studentid 
            INNER JOIN books ON issueinfo.bookid = books.bookid 
            JOIN authors ON authors.authorid = books.authorid 
            JOIN category ON category.categoryid = books.categoryid 
            WHERE issueid = '".$_GET['issueid']."'";			
            $res=mysqli_query($db,$q) or die(mysqli_error());
			
			while($row=mysqli_fetch_assoc($res))
			{
                $email=$row['Email'];
				$issueid=$row['issueid'];
                $bookid=$row['bookid'];
                $pic=$row['bookpic'];
				$bookname=$row['bookname'];
                $borrowername=$row['fname'] . ' ' . $row['lname'];
                $lrn=$row['lrn'];
                $fine=$row['fine'];
                $approve=$row['approve'];
			}
	    ?>
        <div class="form issue-book-container">
            <div class="form-container" style="height:455px;">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Issue Book</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <input type="text" name="issueid" style="display:none;" value="<?php echo $issueid ?>">
                    <input type="text" name="email" style="display:none;" value="<?php echo $email ?>">
                    <input type="text" name="book" style="display:none;" value="<?php echo $bookname ?>">
                    <input type="text" name="name" style="display:none;" value="<?php echo $borrowername ?>">
                    <input type="text" name="lrn" style="display:none;" value="<?php echo $lrn ?>">

                    <div class="label book-img">
                        <?php echo "<img width='50px' height='50px' src='images/".$pic."'>"?>
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
                        <label for="ISBN">Status : </label>
                    </div>
                    <input type="hidden" name="fine" value="0">
                    <select name="approve">
                        <option value='<p class="issued-pill">ISSUED</p>' <?php echo $approve == '<p class="issued-pill">ISSUED</p>' ? 'selected' : '' ?>>Issued</option>
                        <?php
                            if($approve == '<p class="issued-pill">ISSUED</p>'){
                        ?>
                            <option value='<p class="approve-return-pill">RETURNED</p>' <?php echo $approve == '<p class="approve-return-pill">RETURNED</p>' ? 'selected' : '' ?>>Returned</option>
                        <?php } ?>
                        <option value='<p class="expired-pill">OVERDUE</p>' <?php echo $approve == '<p class="expired-pill">OVERDUE</p>' ? 'selected' : '' ?>>Overdue</option>
                        <?php
                            if($approve == '<p class="expired-pill">OVERDUE</p>' ||  $approve == '<p class="approve-return-pill">PAID</p>'){
                        ?>
                            <option value='<p class="approve-return-pill">PAID</p>' <?php echo $approve == '<p class="approve-return-pill">PAID</p>' ? 'selected' : '' ?>>Paid</option>
                        <?php } ?>
                        <option value='<p class="stolen-pill">STOLEN</p>' <?php echo $approve == '<p class="stolen-pill">STOLEN</p>' ? 'selected' : '' ?>>Stolen</option>
                        <option value='<p class="lost-pill">LOST</p>' <?php echo $approve == '<p class="lost-pill">LOST</p>' ? 'selected' : '' ?>>Lost</option>
                        <option value='<p class="discarded-pill">DISCARDED</p>' <?php echo $approve == '<p class="discarded-pill">DISCARDED</p>' ? 'selected' : '' ?>>Discarded</option>
                        
                    </select>
                    <button type="submit" class="btn" name="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit']))
        {
            $borrowername=$_POST['name'];
            $lrn=$_POST['lrn'];
            $issueid=$_POST['issueid'];
            $email=$_POST['email'];
            $book=$_POST['book'];
            $fine=$_POST['fine'];
            $approve=$_POST['approve'];
            $var='<p class="issued-pill">ISSUED</p>';

            if($approve == '<p class="approve-return-pill">RETURNED</p>'){
                $q1="UPDATE issueinfo SET returndate = NOW(), approve = '".$approve."', fine = '".$fine."' WHERE issueid = '".$issueid."';";
            }else{
                $q1="UPDATE issueinfo SET approve = '".$approve."', fine = '".$fine."' WHERE issueid = '".$issueid."';";
            }
            if(mysqli_query($db,$q1))
            {   
                logger($db, $_SESSION['userid'], '1', 'Updated issued book "'.$book.'"');
                
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Issued book updated successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        <?php if($approve == '<p class="issued-pill">ISSUED</p>') { ?>
                            window.location.href = "manage_issued_books.php";
                        <?php } else if($approve == '<p class="expired-pill">OVERDUE</p>' || $approve == '<p class="approve-return-pill">PAID</p>') { ?>
                            window.location.href = "expired.php";
                        <?php } else if($approve == '<p class="stolen-pill">STOLEN</p>' || $approve == '<p class="lost-pill">LOST</p>') { ?>
                            window.location.href = "stolen.php";
                        <?php } else if($approve == '<p class="approve-return-pill">RETURNED</p>') { ?>
                            window.location.href = "returned.php";
                        <?php } else if($approve == '<p class="discarded-pill">DISCARDED</p>') { ?>
                            window.location.href = "discarded.php";
                        <?php } ?>
                    });
                </script>
                <?php
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