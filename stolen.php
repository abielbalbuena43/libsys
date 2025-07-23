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
            <input type="search" name='search' placeholder='Search by Student LRN' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container book-container" id="printTable" style="max-width: 1600px;">
            <div class="student-table-header">
                <h2 class="request-title student-info-title">List of Lost/Stolen books</h2>
                <button class="btn btn-default" onclick="printTable()">Print Report</button>
            </div>
            <?php
        $e=0;
		if(isset($_POST['submit']))
		{
            $var1='<p class="stolen-pill">STOLEN</p>';
            $var2='<p class="lost-pill">LOST</p>';
			$q = mysqli_query($db, "
                SELECT issueid, duedate, student.studentid, lrn, acessionnum, employee_id, studentpic, books.bookid, bookname, ISBN, price, bookpic, authors.authorname, category.categoryname, issueinfo.issuedate, returndate, approve, fine 
                FROM issueinfo 
                LEFT JOIN student ON student.studentid = issueinfo.studentid 
                LEFT JOIN employee ON employee.id = issueinfo.studentid 
                INNER JOIN books ON issueinfo.bookid = books.bookid 
                JOIN authors ON authors.authorid = books.authorid 
                JOIN category ON category.categoryid = books.categoryid 
                WHERE (issueinfo.approve = '$var1' OR issueinfo.approve = '$var2') 
                AND lrn = '$_POST[search]' 
                ORDER BY issueinfo.returndate ASC;
            ");
			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! There's no stolen book by this student ID";

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
                echo "<th>"; echo "Due Date"; echo "</th>";
                // echo "<th>"; echo "Approve Status"; echo "</th>";
                echo "<th style='padding-left: 80px;' class='action-column'>"; echo "Action"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($q))
                {
                    $d = strtotime($row['duedate']);
                    $c=strtotime(date("Y-m-d"));
                    $diff = $c-$d;
                    if($diff>0){
                        $day = floor($diff/(60*60*24));
                        $e=$e+1;
                        $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                        $fine = $day*10;
                        mysqli_query($db,"UPDATE issueinfo SET approve='$var',fine=$fine where `duedate`='$row[duedate]' and approve='yes' limit $e;");
                    }
                    echo "<tr>";
                    echo "<td>"; echo $row['lrn'] == ''? $row['employee_id'] : $row['lrn']; echo "</td>";
                    echo "<td>"; echo $row['acessionnum']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['bookname']; echo "</td>";
                    echo "<td>"; echo date("m-d-Y", strtotime($row['issuedate'])); "</td>";
                    echo "<td>"; echo date("m-d-Y", strtotime($row['duedate'])); "</td>";
                    // echo "<td>"; echo $row['approve']; echo "</td>";
                    echo "<td class='action-column'>";?><a href="edit_issue_book.php?issueid=<?php echo $row['issueid'];?>&ed=<?php echo $row['studentid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold; width: 100px;" type="submit" name="submit1" class="btn btn-default actionbtn">Edit
			        </button>
                    </a>
                    <?php if($row['lrn'] != ''){ ?>
                    <a href="suspend.php?id=<?php echo $row['studentid'];?>&status=0&page=1"><button style="font-weight:bold;" type="submit" name="submit1" class="delbtn" > Suspend
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
            $var1='<p class="stolen-pill">STOLEN</p>';
            $var2='<p class="lost-pill">LOST</p>';
			$res = mysqli_query($db, "
                SELECT issueid, duedate, student.studentid, lrn, acessionnum, employee_id, studentpic, books.bookid, bookname, ISBN, price, bookpic, authors.authorname, category.categoryname, issueinfo.issuedate, returndate, approve, fine 
                FROM issueinfo 
                LEFT JOIN student ON student.studentid = issueinfo.studentid 
                LEFT JOIN employee ON employee.id = issueinfo.studentid 
                INNER JOIN books ON issueinfo.bookid = books.bookid 
                JOIN authors ON authors.authorid = books.authorid 
                JOIN category ON category.categoryid = books.categoryid 
                WHERE (issueinfo.approve = '$var1' OR issueinfo.approve = '$var2') 
                ORDER BY issueinfo.returndate ASC;
            ");
            if(mysqli_num_rows($res)==0)
			{
				echo "There's no stolen books.";
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
            echo "<th>"; echo "Due Date"; echo "</th>";
            echo "<th>"; echo "Status"; echo "</th>";
            echo "<th style='padding-left: 80px;' class='action-column'>"; echo "Action"; echo "</th>";
            echo "</tr>";

            while($row=mysqli_fetch_assoc($res))
            {
                $d = strtotime($row['duedate']);
                $c=strtotime(date("Y-m-d"));
                $diff = $c-$d;
                if($diff>0){
                    $day = floor($diff/(60*60*24));
                    $e=$e+1;
                    $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    $fine = $day*10;
                    mysqli_query($db,"UPDATE issueinfo SET approve='$var',fine=$fine where `duedate`='$row[duedate]' and approve='yes' limit $e;");
                }
                echo "<tr>";
                    echo "<td>"; echo $row['lrn'] == ''? $row['employee_id'] : $row['lrn']; echo "</td>";
                    echo "<td>"; echo $row['acessionnum']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['bookname']; echo "</td>";
                    echo "<td>"; echo date("m-d-Y", strtotime($row['issuedate'])); "</td>";
                    echo "<td>"; echo date("m-d-Y", strtotime($row['duedate'])); "</td>";
                    echo "<td>"; echo $row['approve']; echo "</td>";
                    echo "<td class='action-column'>";?><a href="edit_issue_book.php?issueid=<?php echo $row['issueid'];?>&ed=<?php echo $row['studentid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold; width: 100px;" type="submit" name="submit1" class="btn btn-default actionbtn">Edit
			        </button>
                    </a>
                    <?php if($row['lrn'] != ''){ ?>
                    <a href="suspend.php?id=<?php echo $row['studentid'];?>&status=0&page=1"><button style="font-weight:bold;" type="submit" name="submit1" class="delbtn" > Suspend
                        </button>
                    </a>
                    <?php } ?>
			        <?php 
			        echo "</td>";                    echo "</tr>";
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