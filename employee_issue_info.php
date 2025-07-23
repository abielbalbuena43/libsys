<?php

include __DIR__ . "/includes/connection.php";
include "employee_navbar.php";
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
    <div class="request-table">
        <div class="request-container book-container">
        <div class="student-qr">
            <h2 class="request-title student-info-title" style="padding-top: 50px;">List of Issued Books</h2>
            <!-- <a href="via_qr.php?action=return"><button>Return via QR</button></a> -->
        </div>
            <?php
        $e=0;
	    if(isset($_SESSION['login_emp_username']))
		{

			$q1=mysqli_query($db,"SELECT id from employee where id='$_SESSION[studentid]';");
		    $row=mysqli_fetch_assoc($q1);

		    $var='<p class="expired-pill">OVERDUE</p>';
            $var1='<p class="issued-pill">ISSUED</p>';
            $var2='<p class="approve-return-pill">PAID</p>';

			$q=mysqli_query($db,"SELECT issueid, duedate, employee.id, books.bookid,books.bookname,books.ISBN,books.bookpic,price,issueinfo.issuedate,issueinfo.returndate,
			issueinfo.approve,fine,authors.authorname,category.categoryname from  `issueinfo` join `books` on issueinfo.bookid=books.bookid join `employee`on employee.id=issueinfo.studentid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where employee.id ='$_SESSION[studentid]' and (issueinfo.approve='$var1' or issueinfo.approve='$var' or issueinfo.approve='$var2') ORDER BY `issueinfo`.`returndate` ASC; ");
			if(mysqli_num_rows($q)==0)
			{
				
				echo "There's no issued books";
				
			}
			else
			{
				$var='<p class="expired-pill">OVERDUE</p>';
                $var1='<p class="issued-pill">ISSUED</p>';
                $var2='<p class="approve-return-pill">PAID</p>';

				$row1=mysqli_query($db,"SELECT  issueid, duedate, sum(fine),employee.id,fname from issueinfo join employee on employee.id=issueinfo.studentid where employee.id ='$_SESSION[studentid]' and (issueinfo.approve='$var' OR issueinfo.approve='$var1' OR issueinfo.approve='$var2');");
                $res1=mysqli_fetch_assoc($row1);
                if(mysqli_num_rows($row1)!=0)
                {
                    ?>
                    <!-- <h2 style="padding-left: 1050px;">Your Fine is: &nbsp;<?php echo $res1['sum(fine)'] . " ₱";?></h2> -->
                    <?php
                    
                }
                
				echo "<table class='rtable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                //Table header
                // echo "<th>"; echo "Book ID"; echo "</th>";
                echo "<th>"; echo "Books"; echo "</th>";
                echo "<th>"; echo "ISBN"; echo "</th>";
                echo "<th>"; echo "Issue Date"; echo "</th>";
                echo "<th>"; echo "Due Date"; echo "</th>";
                echo "<th>"; echo "Approve Status"; echo "</th>";
                // echo "<th>"; echo "Fine"; echo "</th>";
                // echo "<th>"; echo "Action"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($q))
                {
                    $d = strtotime($row['returndate']);
                    $c=strtotime(date("Y-m-d"));
                    $diff = $c - $d;
                    // if($d > $row['returndate'])
                    // {
                    //     $e=$e+1;
                    //     $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    //     mysqli_query($db,"UPDATE issueinfo SET approve='$var',fine=10 where `returndate`='$row[returndate]' and approve='yes' limit $e;");
                    // }
                    if($diff>0){
                        $day = floor($diff/(60*60*24));
                        $e=$e+1;
                        $var='<p class="expired-pill">OVERDUE</p>';
                        $fine = $day*10;
                        mysqli_query($db,"UPDATE issueinfo SET approve='$var',fine=$fine where `returndate`='$row[returndate]' and approve='yes' limit $e;");
                    }
                    // $t=mysqli_query($db,"SELECT * FROM timer where stdid='$_SESSION[studentid]' and bid='$row[bookid]';");
                    // $res = mysqli_fetch_assoc($t);
                    // $countDownDate = strtotime($res['date']);
                    // $now = strtotime(date("Y-m-d H:i:s"));
                    // $diff = $now-$countDownDate;
                    
                    // if($diff>0){
                    //     $day = floor($diff/(1000*60*60*24));
                    //     echo $day;
                    //     $e=$e+1;
                    //     $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    //     $fine = $day*10;
                    //     mysqli_query($db,"UPDATE issueinfo SET approve='$var',fine=$fine where `returndate`='$row[returndate]' and approve='yes' limit $e;");
                        
                    // }
                    
                    echo "<tr style='" . ($row['approve'] == $var1 ? '' : 'background-color: #FF7276;') . "'>";
                    // echo "<td>"; echo $row['bookid']; echo "</td>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['bookpic']."'>
                        <div>
                            <p>";echo $row['bookname'];echo"</p>
                            <small>";echo $row['authorname'];;echo" </small><br>
                            <small>";echo $row['categoryname'];;echo" </small><br>";?>
                        </div>
                    </div>
                    </td><?php
               
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    echo "<td>"; echo $row['issuedate']; echo "</td>";
                    echo "<td>"; echo $row['duedate']; echo "</td>";
                    echo "<td>"; echo $row['approve'] == $var1 ? $var1 : $var; echo "</td>";
                    // echo "<td>"; echo $row['fine']; echo "</td>";
                    // echo "<td>";?>
                    <!-- <a href="return_book.php?issueid=<?php echo $row['issueid'];?>&ed=<?php echo $row['studentid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold; width: 100px;" type="submit" name="submit1" class="btn btn-default actionbtn">Return
			        </button>
                    </a> -->
			        <?php 
			        // echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
            ?>
        </div>
    </div>
    <div class="footer" style="position:absolute; bottom:0; width:100vw;">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
    <?php
    if(isset($_GET['req']))
	{
		$id=$_GET['req'];
		mysqli_query($db,"DELETE FROM issueinfo where bookid=$id AND studentid = '$_SESSION[studentid]';");
        $res=mysqli_query($db,"SELECT quantity from books where bookid=$id;");
		while($row=mysqli_fetch_assoc($res))
		{
			if($row['quantity']==0)
			{
				mysqli_query($db,"UPDATE books SET quantity=quantity+1, status='Available' where bookid=$id;");
			}
			else
			{
				mysqli_query($db,"UPDATE books SET quantity=quantity+1 where bookid=$id;");
			}
			
		}
		?>	
		<script type="text/javascript">
			Swal.fire({
                title: "Success!",
                text: "Request deleted successfully.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "request_book.php";
            });
	    </script>
		<?php
	}
	?>
</body>
</html>