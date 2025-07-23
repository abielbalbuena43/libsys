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
            <input type="search" name='search' placeholder='Search by Student ID' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container book-container">
            <h2 class="request-title student-info-title">List of Feedbacks</h2>
            <?php

		if(isset($_POST['submit']))
		{
			$q=mysqli_query($db,"SELECT student.studentpic,fname,lname,studentid,feedback.rating,comment,date from feedback join student on student.studentid=feedback.stdid where studentid ='$_POST[search]';");
			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! No feedback found by this student ID.";

			}
			else
			{
				echo "<table class='rtable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                //Table header
                echo "<th>"; echo "Students"; echo "</th>";
                // echo "<th>"; echo "Full Name"; echo "</th>";
                echo "<th>"; echo "Rating"; echo "</th>";
                echo "<th>"; echo "Comment"; echo "</th>";
                echo "<th>"; echo "Date"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($q))
                {
                    echo "<tr>";
                    // echo "<td>"; echo $row['studentid']; echo "</td>";
                    // echo "<td>"; echo $row['FullName']; echo "</td>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['studentpic']."'>
                        <div>
                            <p>Student ID: ";echo $row['studentid'];echo"</p>
                            <p>";echo $row['fname'] . ' ' . $row['lname'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['rating'];echo"/5"; echo "</td>";
                    echo "<td>"; echo $row['comment']; echo "</td>";
                    echo "<td>"; echo $row['date']; echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$res=mysqli_query($db,"SELECT student.studentpic,fname,lname,studentid,feedback.rating,comment,date from feedback join student on student.studentid=feedback.stdid ORDER BY feedback.date DESC;");
            echo "<table class='rtable'>";
            echo "<tr style='background-color: #1aa7ec;'>";
            //Table header
            echo "<th>"; echo "Students"; echo "</th>";
            // echo "<th>"; echo "Full Name"; echo "</th>";
            echo "<th>"; echo "Rating"; echo "</th>";
            echo "<th>"; echo "Comment"; echo "</th>";
            echo "<th>"; echo "Date"; echo "</th>";
            echo "</tr>";

            while($row=mysqli_fetch_assoc($res))
            {
                echo "<tr>";
                echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['studentpic']."'>
                        <div>
                            <p>Student ID: ";echo $row['studentid'];echo"</p>
                            <p>";echo $row['fname'] . ' ' . $row['lname'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                echo "<td>"; echo $row['rating'];echo"/5"; echo "</td>";
                echo "<td>"; echo $row['comment']; echo "</td>";
                echo "<td>"; echo $row['date']; echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

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
</html>