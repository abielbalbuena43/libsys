<?php

include __DIR__ . '/includes/connection.php'; // Corrected path to connection.php
include __DIR__ . '/includes/admin_navbar.php';
include __DIR__ . '/logger.php';

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="search-bar admin-search">
        <form action="" method='post'>
            <input type="search" name='search' placeholder='Search by LRN' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container book-container" id="printTable" style="max-width: 1600px;">
            <div class="student-table-header" style="margin-bottom: 12px;">
                <h2 class="request-title student-info-title">List of Returned books</h2>
                <button class="btn btn-default" onclick="printTable()">Print Report</button>
            </div>
            <form action="" method="post">
                    <button type='submit' name='clear' class="clearbtn">Clear</button>
                </form>
            <?php
		if(isset($_POST['submit']))
		{
            $var='<p class="approve-return-pill">RETURNED</p>';
            $var1='<p class="pending-pill">PENDING RETURN</p>';

			$q=mysqli_query($db,"SELECT issueid, duedate, student.studentid, lrn, acessionnum, employee_id, studentpic, books.bookid, bookname, ISBN, price, bookpic, authors.authorname, category.categoryname, issueinfo.issuedate, returndate, approve, fine 
                FROM issueinfo 
                LEFT JOIN student ON student.studentid = issueinfo.studentid 
                LEFT JOIN employee ON employee.id = issueinfo.studentid 
                INNER JOIN books ON issueinfo.bookid = books.bookid 
                JOIN authors ON authors.authorid = books.authorid 
                JOIN category ON category.categoryid = books.categoryid  where (issueinfo.approve='$var' OR issueinfo.approve='$var1') AND lrn='$_POST[search]' ORDER BY `issueinfo`.`returndate` DESC;");
			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! There's no returned book by this student ID";

			}
			else
			{
				echo "<table class='rtable booktable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                //Table header
                echo "<th>"; echo "LRN/Employee ID"; echo "</th>";
                echo "<th>"; echo "Accession Number"; echo "</th>";
                echo "<th>"; echo "ISBN"; echo "</th>";
                echo "<th>"; echo "Author"; echo "</th>";
                echo "<th>"; echo "Title"; echo "</th>";
                echo "<th>"; echo "Issue Date"; echo "</th>";
                echo "<th>"; echo "Return Date"; echo "</th>";
                echo "<th>"; echo "Approve Status"; echo "</th>";
                echo "<th class='action-column'>"; echo "Action"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($q))
                {
                    echo "<tr>";
                    echo "<td>"; echo $row['lrn'] == ''? $row['employee_id'] : $row['lrn']; echo "</td>";
                    echo "<td>"; echo $row['acessionnum']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['bookname']; echo "</td>";
                    echo "<td>"; echo date("m-d-Y", strtotime($row['issuedate'])); "</td>";
                    echo "<td>"; echo date("m-d-Y", strtotime($row['returndate'])); "</td>";
                    echo "<td>"; echo $row['approve']; echo "</td>";
                    echo "<td style='padding-left: 0;' class='action-column'>";?>
                    <?php if($var1 == $row['approve']){ ?>
                    <a href="returned.php?issueid=<?php echo $row['issueid'];?>"><button style="font-weight:bold; width: 140px;" type="submit" name="submit1" class="btn btn-default actionbtn">Approve
			        </button>
                    </a>
                    <?php } ?>
			        <?php 
			        echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$var='<p class="approve-return-pill">RETURNED</p>';
            $var1='<p class="pending-pill">PENDING RETURN</p>';

			$res=mysqli_query($db,"SELECT issueid, duedate, student.studentid, lrn, acessionnum, employee_id, studentpic, books.bookid, bookname, ISBN, price, bookpic, authors.authorname, category.categoryname, issueinfo.issuedate, returndate, approve, fine 
                FROM issueinfo 
                LEFT JOIN student ON student.studentid = issueinfo.studentid 
                LEFT JOIN employee ON employee.id = issueinfo.studentid 
                INNER JOIN books ON issueinfo.bookid = books.bookid 
                JOIN authors ON authors.authorid = books.authorid 
                JOIN category ON category.categoryid = books.categoryid  where (issueinfo.approve='$var' OR issueinfo.approve='$var1') ORDER BY `issueinfo`.`returndate` DESC;");
            if(mysqli_num_rows($res)==0)
			{
				echo "There's no returned books.";
			}
            else{
                echo "<table class='rtable booktable'>";
            echo "<tr style='background-color: #1aa7ec;'>";
            //Table header
            echo "<th>"; echo "LRN/Employee ID"; echo "</th>";
            echo "<th>"; echo "Accession Number"; echo "</th>";
            echo "<th>"; echo "ISBN"; echo "</th>";
            echo "<th>"; echo "Author"; echo "</th>";
            echo "<th>"; echo "Title"; echo "</th>";
            echo "<th>"; echo "Issue Date"; echo "</th>";
            echo "<th>"; echo "Return Date"; echo "</th>";
            echo "<th>"; echo "Approve Status"; echo "</th>";
            echo "<th style='padding-left: 0;' class='action-column'>"; echo "Action"; echo "</th>";

            echo "</tr>";

            while($row=mysqli_fetch_assoc($res))
            {
                echo "<tr>";
                    echo "<td>"; echo $row['lrn'] == ''? $row['employee_id'] : $row['lrn']; echo "</td>";
                    echo "<td>"; echo $row['acessionnum']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['bookname']; echo "</td>";
                    echo "<td>"; echo date("m-d-Y", strtotime($row['issuedate'])); "</td>";
                    echo "<td>"; echo date("m-d-Y", strtotime($row['returndate'])); "</td>";
                    echo "<td>"; echo $row['approve']; echo "</td>";
                    echo "<td class='action-column'>";?>
                    <?php if($var1 == $row['approve']){ ?>
                    <a href="returned.php?issueid=<?php echo $row['issueid'];?>"><button style="font-weight:bold; width: 140px;" type="submit" name="submit1" class="btn btn-default actionbtn">Approve
			        </button>
                    </a>
                    <?php } ?>
			        <?php 
			        echo "</td>";
                    echo "</tr>";
            }
            echo "</table>";
            }
        }
        if(isset($_POST['clear'])){
            $var='<p style="color:yellow; background-color:green;">RETURNED</p>';
            mysqli_query($db,"DELETE issueinfo FROM issueinfo where approve='$var';");
		    ?>	
            <script type="text/javascript">
                Swal.fire({
                    title: "Success!",
                    text: "Cleared successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "returned.php";
                });
            </script>
		
		    <?php
        }else if(isset($_GET['issueid'])){
            mysqli_query($db,"UPDATE issueinfo set approve = '$var' WHERE issueid = '".$_GET['issueid']."';");
            logger($db, $_SESSION['userid'], '1', 'Approved returned book with issue id "'.$_GET['issueid'].'"');
            ?>	
            <script type="text/javascript">
                Swal.fire({
                    title: "Success!",
                    text: "Book return approved successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "returned.php";
                });
            </script>
		
		    <?php
        }
        ?> 
        </div>
    </div>
    <div class="footer" style="position:absolute; bottom:0; width:100vw;">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
    
</body>
<script>
function printTable() {
    var table = document.getElementById('printTable').innerHTML;
    var newWindow = window.open('', '', 'height=500,width=800');
    newWindow.document.write('<html><head><title>Print Table</title>');
    newWindow.document.write('<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">');
    newWindow.document.write('</head><body>');
    newWindow.document.write(table);
    newWindow.document.write('</body></html>');
    newWindow.document.close(); 
    newWindow.print();
} 
</script>
</html>