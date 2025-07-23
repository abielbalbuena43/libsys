<?php

include __DIR__ . '/includes/connection.php'; 
include __DIR__ . '/includes/admin_navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="search-bar admin-search">
        <form action="" method='post'>
            <input type="search" name='search' placeholder='Search by Student ID/Employee ID' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container book-container">
            <h2 class="request-title student-info-title">Request Information</h2>
            <?php

		if(isset($_POST['submit']))
		{
			$q=mysqli_query($db, "SELECT issueid, student.studentid, student.fname AS student_fname, student.lname AS student_lname, employee.id AS employee_id, employee.fname AS employee_fname, employee.lname AS employee_lname, employee.pic AS employee_pic, studentpic, books.bookid, bookname, ISBN, price, bookpic, authors.authorname, category.categoryname 
            FROM issueinfo 
            LEFT JOIN student ON student.studentid = issueinfo.studentid 
            LEFT JOIN employee ON issueinfo.studentid = employee.id 
            INNER JOIN books ON issueinfo.bookid = books.bookid 
            JOIN authors ON authors.authorid = books.authorid 
            JOIN category ON category.categoryid = books.categoryid 
            WHERE issueinfo.approve = ''
            AND issueinfo.studentid='$_POST[search]';;");
			if(mysqli_num_rows($q) == 0) {
                echo "There's no pending request.";
            } else {
                echo "<table class='rtable booktable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                // Table header
                echo "<th>"; echo "Students"; echo "</th>";
                echo "<th>"; echo "Books"; echo "</th>";
                echo "<th>"; echo "Author Name"; echo "</th>";
                echo "<th>"; echo "Category Name"; echo "</th>";
                echo "<th>"; echo "ISBN"; echo "</th>";
                echo "<th style='padding-left: 40px;'>"; echo "Action"; echo "</th>";
                echo "</tr>";
            
                while($row = mysqli_fetch_assoc($q)) {
                    echo "<tr>";
            
                    echo "<td><div class='table-info'>";
                    if($row['studentid'] != '') {
                        echo "<img src='images/".$row['studentpic']."'>";
                    } else {
                        echo "<img src='images/".$row['employee_pic']."'>";
                    }
                    echo "<div>";
                    if($row['studentid'] != '') {
                        echo "<p>Student ID: " . $row['studentid'] . "</p>";
                    } else {
                        echo "<p>Employee ID:".$row['employee_id']."</p>";
                    }
                    if($row['studentid'] != '') {
                        echo "<p>Student Name: " . $row['student_fname'] . " " . $row['student_lname'] . "</p>";
                    } else {
                        echo "<p>Employee Name: " . $row['employee_fname'] . " " . $row['employee_lname'] . "</p>";
                    }
                    echo "</div></div></td>";
            
                    echo "<td><div class='table-info'>";
                    echo "<img src='images/".$row['bookpic']."'>";
                    echo "<div>";
                    echo "<p>Book ID: " . $row['bookid'] . "</p>";
                    echo "<p>Book Name: " . $row['bookname'] . "</p>";
                    echo "</div></div></td>";
            
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['categoryname']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
            
                    echo "<td>";
                    if($row['studentid'] != '') {
                        echo "<a href='issue_book.php?issueid=".$row['issueid']."&ed=".$row['studentid']."&ed1=".$row['bookid']."'>";
                    } else {
                        echo "<a href='issue_book.php?issueid=".$row['issueid']."&ed=".$row['employee_id']."&ed1=".$row['bookid']."'>";
                    }
                    echo "<button style='font-weight:bold;' type='submit' name='submit1' class='btn btn-default actionbtn'>Issue</button>";
                    echo "</a></td>";
            
                    echo "</tr>";
                }
                echo "</table>";
            }
		}
			//if button is not pressed
		else
		{
            $res = mysqli_query($db, "SELECT issueid, student.studentid, student.fname AS student_fname, student.lname AS student_lname, employee.id AS employee_id, employee.fname AS employee_fname, employee.lname AS employee_lname, employee.pic AS employee_pic, studentpic, books.bookid, bookname, ISBN, price, bookpic, authors.authorname, category.categoryname 
            FROM issueinfo 
            LEFT JOIN student ON student.studentid = issueinfo.studentid 
            LEFT JOIN employee ON issueinfo.studentid = employee.id 
            INNER JOIN books ON issueinfo.bookid = books.bookid 
            JOIN authors ON authors.authorid = books.authorid 
            JOIN category ON category.categoryid = books.categoryid 
            WHERE issueinfo.approve = '';");
            if(mysqli_num_rows($res) == 0) {
                echo "There's no pending request.";
            } else {
                echo "<table class='rtable booktable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                // Table header
                echo "<th>"; echo "Students"; echo "</th>";
                echo "<th>"; echo "Books"; echo "</th>";
                echo "<th>"; echo "Author Name"; echo "</th>";
                echo "<th>"; echo "Category Name"; echo "</th>";
                echo "<th>"; echo "ISBN"; echo "</th>";
                echo "<th style='padding-left: 40px;'>"; echo "Action"; echo "</th>";
                echo "</tr>";
            
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>";
            
                    echo "<td><div class='table-info'>";
                    if($row['studentid'] != '') {
                        echo "<img src='images/".$row['studentpic']."'>";
                    } else {
                        echo "<img src='images/".$row['employee_pic']."'>";
                    }
                    echo "<div>";
                    if($row['studentid'] != '') {
                        echo "<p>Student ID: " . $row['studentid'] . "</p>";
                    } else {
                        echo "<p>Employee ID:".$row['employee_id']."</p>";
                    }
                    if($row['studentid'] != '') {
                        echo "<p>Student Name: " . $row['student_fname'] . " " . $row['student_lname'] . "</p>";
                    } else {
                        echo "<p>Employee Name: " . $row['employee_fname'] . " " . $row['employee_lname'] . "</p>";
                    }
                    echo "</div></div></td>";
            
                    echo "<td><div class='table-info'>";
                    echo "<img src='images/".$row['bookpic']."'>";
                    echo "<div>";
                    echo "<p>Book ID: " . $row['bookid'] . "</p>";
                    echo "<p>Book Name: " . $row['bookname'] . "</p>";
                    echo "</div></div></td>";
            
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['categoryname']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
            
                    echo "<td>";
                    if($row['studentid'] != '') {
                        echo "<a href='issue_book.php?issueid=".$row['issueid']."&ed=".$row['studentid']."&ed1=".$row['bookid']."'>";
                    } else {
                        echo "<a href='issue_book.php?issueid=".$row['issueid']."&ed=".$row['employee_id']."&ed1=".$row['bookid']."'>";
                    }
                    echo "<button style='font-weight:bold;' type='submit' name='submit1' class='btn btn-default actionbtn'>Issue</button>";
                    echo "</a></td>";
            
                    echo "</tr>";
                }
                echo "</table>";
            }
            
        }
        ?> 
        </div>
    </div>
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
    
</body>
</html>