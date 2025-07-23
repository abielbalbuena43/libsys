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
            <input type="search" name='search' placeholder='Search by Employee ID' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container">
            <div class="student-table-header">
                <h2 class="request-title student-info-title">List of Employees</h2>
                <a href="./employee_archives.php"><button class="btn btn-default">Archives</button></a>
            </div>
            <?php

		if(isset($_POST['submit']))
		{
			$q=mysqli_query($db,"SELECT * FROM  `employee` where status = 1 AND employee_id ='$_POST[search]';");
			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! No employee found. Try searching again";

			}
			else
			{
				echo "<table class='rtable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                //Table header
                echo "<th>"; echo "Students"; echo "</th>";
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
                        <img src='images/".$row['pic']."'>
                        <div>
                            <p>Employee ID: ";echo $row['employee_id'];echo"</p>
                            <p>";echo $row['fname'] . " " . $row['lname'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['email']; echo "</td>";
                    echo "<td>"; echo $row['phone']; echo "</td>";
                    echo "<td>";?><a href="edit_amployee.php?id=<?php echo $row['employee_id'];?>"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn"><i class="fas fa-edit"></i> Edit
                    </button>
                    </a>
                    <a href="archive_employee.php?id=<?php echo $row['employee_id'];?>&status=0"><button style="font-weight:bold;" type="submit" name="submit1" class="delbtn" ><i class="fas fa-archive"></i> Archive
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
			$res=mysqli_query($db,"SELECT * FROM `employee` WHERE status = 1");
            echo "<table class='rtable'>";
            echo "<tr style='background-color: #1aa7ec;'>";
            //Table header
            echo "<th>"; echo "Students"; echo "</th>";
            echo "<th>"; echo "Email"; echo "</th>";
            echo "<th>"; echo "Phone Number"; echo "</th>";
            echo "<th>"; echo "Status"; echo "</th>";
            echo "</tr>";

            if(mysqli_num_rows($res) > 0){
                while($row=mysqli_fetch_assoc($res))
                {
                    echo "<tr>";
                    echo "<td>
                        <div class='table-info'>
                            <img src='images/".$row['pic']."'>
                            <div>
                                <p>Employee ID: ";echo $row['employee_id'];echo"</p>
                                <p>";echo $row['fname'] . " " . $row['lname'];echo"</p><br>";?>
                            </div>
                        </div>
                        </td><?php
                    echo "<td>"; echo $row['email']; echo "</td>";
                    echo "<td>"; echo $row['phone']; echo "</td>";
                    echo "<td>";?><a href="edit_employee.php?id=<?php echo $row['employee_id'];?>"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn"><i class="fas fa-edit"></i> Edit
                    </button>
                    </a>
                    <a href="archive_employee.php?id=<?php echo $row['employee_id'];?>&status=0"><button style="font-weight:bold;" type="submit" name="submit1" class="delbtn" ><i class="fas fa-archive"></i> Archive
                        </button>
                    </a>
			        <?php 
			        echo "</td>";
                    echo "</tr>";
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
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
    
</body>
</html>