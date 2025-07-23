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
        <div class="request-container">
            <div class="student-table-header">
                <h2 class="request-title student-info-title">List of Students</h2>
                <a href="./student_info.php"><button class="btn btn-default">Back</button></a>
            </div>
            <?php

		if(isset($_POST['submit']))
		{
			$q=mysqli_query($db,"SELECT studentid,FullName,Email,PhoneNumber,studentpic FROM  `student` where status = 0 AND studentid ='$_POST[search]';");
			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! No student found. Try searching again";

			}
			else
			{
				echo "<table class='rtable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                //Table header
                echo "<th>"; echo "Students"; echo "</th>";
                // echo "<th>"; echo "Full Name"; echo "</th>";
                echo "<th>"; echo "Email"; echo "</th>";
                echo "<th>"; echo "Phone Number"; echo "</th>";
                echo "<th>"; echo "Status"; echo "</th>";
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
                            <p>";echo $row['FullName'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['Email']; echo "</td>";
                    echo "<td>"; echo $row['PhoneNumber']; echo "</td>";
                    echo "<td>";?>
                    <a href="archive_student.php?id=<?php echo $row['studentid'];?>&status=1"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default" ><i class="fas fa-undo"></i> Restore
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
		    }
		}
			//if button is not pressed
		else
		{
			$res=mysqli_query($db,"SELECT studentid,fname,lname,Email,PhoneNumber,studentpic FROM `student` where status = 0;");
            echo "<table class='rtable'>";
            echo "<tr style='background-color: #1aa7ec;'>";
            //Table header
            echo "<th>"; echo "Students"; echo "</th>";
            // echo "<th>"; echo "Full Name"; echo "</th>";
            echo "<th>"; echo "Email"; echo "</th>";
            echo "<th>"; echo "Phone Number"; echo "</th>";
            echo "<th>"; echo "Action"; echo "</th>";
            echo "</tr>";
            if(mysqli_num_rows($res) > 0){
                while($row=mysqli_fetch_assoc($res))
                {
                    echo "<tr>";
                    echo "<td>
                        <div class='table-info'>
                            <img src='images/".$row['studentpic']."'>
                            <div>
                                <p>Student ID: ";echo $row['studentid'];echo"</p>
                                <p>";echo $row['fname'] . ' ' .$row['lname'];echo"</p><br>";?>
                            </div>
                        </div>
                        </td><?php
                    echo "<td>"; echo $row['Email']; echo "</td>";
                    echo "<td>"; echo $row['PhoneNumber']; echo "</td>";
                    echo "<td>";?>
                        <a href="archive_student.php?id=<?php echo $row['studentid'];?>&status=1"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default" ><i class="fas fa-undo"></i> Restore
                            </button>
                        </a>
                        <a href="delete_student.php?del=<?php echo $row['studentid'];?>"><button onclick="del()" style="font-weight:bold;" type="submit" name="submit1" class="delbtn" ><i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </a>
                        <?php
                    echo "</td>"; 
                    
                }
                echo "</table>";
            }else{
                echo "<tr>";
                echo "<td colspan='4'>No data available.</td>";
                echo "</tr>";
                echo "</table>";
            }
        }
        ?> 
        </div>
    </div>
</body>
</html>