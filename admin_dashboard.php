<?php

include __DIR__ . '/includes/connection.php'; // Corrected path to connection.php
include __DIR__ . '/includes/admin_navbar.php';
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="admin-dashboard">
        <div class="admin-dashboard-container">
            <div class="admin-dashboard-row">
                <?php
             		
             		$students=mysqli_query($db,"SELECT * FROM `student`");
             		$total_students=mysqli_num_rows($students);

             	?>
                <div class="dashboard-col-3">
                    <a href="student_info.php" class="dashboard-card">
                        <i class="fas fa-user-graduate dashboard-icon"></i>
                        <div>
                        <h3><?=$total_students;?></h3>
                        Total Students
                        </div>
                    </a>
                </div>
                <?php
             		$books=mysqli_query($db,"SELECT * FROM `books`");
             		$total_books=mysqli_num_rows($books);

             	?>
                <div class="dashboard-col-3">
                    <a href="manage_books.php" class="dashboard-card">
                        <i class="fas fa-book dashboard-icon"></i>
                        <div>
                        <h3><?=$total_books;?></h3>
                        Books Listed
                        </div>
                    </a>
                </div>
                <?php
             		$authors=mysqli_query($db,"SELECT * FROM `authors`");
             		$total_authors=mysqli_num_rows($authors);

             	?>
                 <div class="dashboard-col-3">
                    <a href="manage_authors.php" class="dashboard-card">
                        <i class="fas fa-user-edit dashboard-icon"></i>
                        <div>
                        <h3><?=$total_authors;?></h3>
                        Authors Listed
                        </div>
                    </a>
                </div>
                <?php
                    $categories=mysqli_query($db,"SELECT * FROM `category`");
                    $total_categories=mysqli_num_rows($categories);

                ?>
                <!-- <div class="dashboard-col-3">
                    <a href="manage_categories.php" class="dashboard-card">
                        <i class="fas fa-list dashboard-icon"></i>
                        <div>
                        <h3><?=$total_categories;?></h3>
                        Categories Listed
                        </div>
                    </a>
                </div>
                <?php
                    $requests=mysqli_query($db,"SELECT student.studentid,fname,lname,books.bookid,bookname,ISBN,price FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='' ");
                    $total_requests=mysqli_num_rows($requests);
                ?>
                <div class="dashboard-col-3">
                    <a href="request_info.php" class="dashboard-card">
                        <i class="fas fa-book-reader dashboard-icon"></i>
                        <div>
                        <h3><?=$total_requests;?></h3>
                        Total Books requests
                        </div>
                    </a>
                </div>
                <?php
                    $var='<p class="issued-pill">ISSUED</p>';
                    $issue=mysqli_query($db,"SELECT student.studentid,fname,lname,books.bookid,bookname,ISBN,price FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='Yes' or issueinfo.approve='$var'");
                    $total_issue=mysqli_num_rows($issue);

                ?>
                <div class="dashboard-col-3">
                    <a href="manage_issued_books.php" class="dashboard-card">
                        <i class="fas fa-address-book dashboard-icon"></i>
                        <div>
                        <h3><?=$total_issue;?></h3>
                        Total Books issued
                        </div>
                    </a>
                </div>
                <?php
                    $var='<p style="color:yellow; background-color:green;">RETURNED</p>';
                    $returned=mysqli_query($db,"SELECT student.studentid,fname,lname,books.bookid,bookname,ISBN,price FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='$var'");
                    $total_returned=mysqli_num_rows($returned);
                ?>
                <div class="dashboard-col-3">
                    <a href="returned.php" class="dashboard-card">
                        <i class="fas fa-undo dashboard-icon"></i>
                        <div>
                        <h3><?=$total_returned;?></h3>
                        Returned Lists
                        </div>
                    </a>
                </div>
                <?php
                    $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    $expired=mysqli_query($db,"SELECT student.studentid,fname,lname,books.bookid,bookname,ISBN,price FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='$var'");
                    $total_expired=mysqli_num_rows($expired);
                ?>
                <div class="dashboard-col-3">
                    <a href="expired.php" class="dashboard-card">
                        <i class="fas fa-times-circle dashboard-icon"></i>
                        <div>
                        <h3><?=$total_expired;?></h3>
                        Expired Lists
                        </div>
                    </a>
                </div>
                <?php
                    $trending=mysqli_query($db,"SELECT *FROM trendingbook;");
                    $total_trending=mysqli_num_rows($trending);
                ?>
                <div class="dashboard-col-3">
                    <a href="trending_books.php" class="dashboard-card">
                        <i class="fas fa-chart-line dashboard-icon"></i>
                        <div>
                        <h3><?=$total_trending;?></h3>
                        Total Trending Books
                        </div>
                    </a>
                </div> -->
            </div>
            <div class="admin-dashboard-row">
                <div class="admin-dashboard-column dashboard-table" style="width:55%">
                    <div class="dashboard-col-2">
                    <p>New Books</p>
                    <?php
                        $res=mysqli_query($db,"SELECT books.bookpic,books.bookid,books.bookname,authors.authorname,category.categoryname,books.ISBN,books.price,quantity,status from  `books`join `authors` on authors.authorid=books.authorid join `category` on category.categoryid=books.categoryid ORDER BY bookid DESC LIMIT 1;");
                        echo "<table class='rtable booktable'>";
                        echo "<tr style='background-color: #1aa7ec;'>";
                        //Table header
                        echo "<th>"; echo "Books"; echo "</th>";
                        echo "<th>"; echo "Author Name"; echo "</th>";
                        echo "<th>"; echo "Category Name"; echo "</th>";
                        echo "<th>"; echo "Action"; echo "</th>";
                        echo "</tr>";
            
                        while($row=mysqli_fetch_assoc($res))
                        {
                            echo "<tr>";
                                // echo "<td>"; echo $row['studentid']; echo "</td>";
                                // echo "<td>"; echo $row['fname,lname']; echo "</td>";
                                echo "<td>
                                <div class='table-info'>
                                    <img src='images/".$row['bookpic']."'>
                                    <div>
                                        <p>Book ID: ";echo $row['bookid'];echo"</p>
                                        <p>";echo $row['bookname'];echo"</p>";?>
                                        <a href="?req=<?php echo $row['bookid'];?>"><button type='submit' name='remove'>Add as a Trending Book</button></a>
                                    </div>
                                </div>
                                </td><?php
                                echo "<td>"; echo $row['authorname']; echo "</td>";
                                echo "<td>"; echo $row['categoryname']; echo "</td>";
                                echo "<td>";?><a href="edit_book.php?ed=<?php echo $row['bookid'];?>"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn"><i class="fas fa-edit"></i> Edit
                                </button>
                                </a>
                                <a href="delete_book.php?del=<?php echo $row['bookid'];?>"><button onclick="del()" style="font-weight:bold;" type="submit" name="submit1" class="delbtn" ><i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </a>
                                <?php 
                                echo "</td>";
                                echo "</tr>";
                        }
                        echo "</table>";
                    ?>
                    <a href="manage_books.php"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn">Show List</button></a>
                    </div>
                    <div class="dashboard-col-2">
                    <p>New Members</p>
                    <?php
                    $res=mysqli_query($db,"SELECT studentid,fname,lname,Email,PhoneNumber,studentpic FROM `student` ORDER BY studentid DESC LIMIT 1;");
                    echo "<table class='rtable'>";
                    echo "<tr style='background-color: #1aa7ec;'>";
                    //Table header
                    echo "<th>"; echo "Students"; echo "</th>";
                    // echo "<th>"; echo "Full Name"; echo "</th>";
                    echo "<th>"; echo "Email"; echo "</th>";
                    echo "<th>"; echo "Phone Number"; echo "</th>";
                    echo "<th>"; echo "Action"; echo "</th>";
                    echo "</tr>";
        
                    while($row=mysqli_fetch_assoc($res))
                    {
                        echo "<tr>";
                        echo "<td>
                            <div class='table-info'>
                                <img src='images/".$row['studentpic']."'>
                                <div>
                                    <p>Student ID: ";echo $row['studentid'];echo"</p>
                                    <p>";echo $row['fname'] .' '. $row['lname'];echo"</p><br>";?>
                                </div>
                            </div>
                            </td><?php
                        echo "<td>"; echo $row['Email']; echo "</td>";
                        echo "<td>"; echo $row['PhoneNumber']; echo "</td>";
                        echo "<td>";?><a href="edit_student.php?id=<?php echo $row['studentid'];?>"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn"><i class="fas fa-edit"></i> Edit
                            </button>
                            </a>
                            <a href="delete_student.php?del=<?php echo $row['studentid'];?>"><button onclick="del()" style="font-weight:bold;" type="submit" name="submit1" class="delbtn" ><i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </a>
                            <?php
                        echo "</td>"; 
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>
                    <a href="student_info.php"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn">Show List</button></a>
                    </div>
                </div>  
                <div class="dashboard-chart">
                    <canvas class="w-100" id="barChart"></canvas>
                </div> 
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
<script>
var ctx = document.getElementById('barChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['New Book Last Day', 'Book Issued', 'New Member', 'Not Returned'],
        datasets: [{
            fill: true,
            label: 'Values',
            data: [ 
                    <?php echo $total_books ?? 20?>, 
                    <?php echo $total_issue ?? 30?>,
                    <?php echo $total_students ?? 15?>,
                    <?php echo $total_requests ?? 20?>,
            ],
            backgroundColor: [
                'rgba(255,100,100,0.4)',
                'rgba(100,255,100,0.4)',
                'rgba(100,100,255,0.4)',
                'rgba(255,100,255,0.4)',
                
            ],
            borderColor: [
                'rgba(26,167,236,1)',
                
            ],
        }]
    },
   
});
</script>
</html>