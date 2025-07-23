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
            <input type="search" name='search' placeholder='Search by user' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container">
            <h2 class="request-title student-info-title">Audit Logs</h2>
            <?php

		if(isset($_POST['submit']))
		{
			$q=mysqli_query($db,"(SELECT logs.log_id, logs.user_type, logs.message, logs.created_at, admin.fullname AS user_name FROM logs INNER JOIN admin ON logs.user_id = admin.adminid WHERE logs.user_type = '1' AND admin.fullname = '".$_POST['search']."') UNION (SELECT logs.log_id, logs.user_type, logs.message, logs.created_at, student.fname AS user_name FROM logs INNER JOIN student ON logs.user_id = student.studentid WHERE logs.user_type = '0'  AND student.fname LIKE '%".$_POST['search']."%' OR student.lname LIKE '%".$_POST['search']."%') ORDER BY created_at DESC;");
			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! No user found. Try searching again";

			}
			else
			{
				echo "<table class='rtable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                //Table header
                echo "<th>"; echo "User"; echo "</th>";
                echo "<th>"; echo "Role"; echo "</th>";
                echo "<th>"; echo "Action/Event/Message"; echo "</th>";
                echo "<th>"; echo "Datetime"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($q))
                {
                    echo "<tr>";
                    echo "<td>"; echo $row['user_name']; echo "</td>";
                    echo "<td>"; echo $row['user_type'] == 1 ? "admin" : "student"; echo "</td>";
                    echo "<td>"; echo $row['message']; echo "</td>";
                    echo "<td>"; echo $row['created_at']; echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$res=mysqli_query($db,"(SELECT logs.log_id, logs.user_type, logs.message, logs.created_at, admin.fullname AS user_name FROM logs INNER JOIN admin ON logs.user_id = admin.adminid WHERE logs.user_type = '1') UNION (SELECT logs.log_id, logs.user_type, logs.message, logs.created_at, student.fname AS user_name FROM logs INNER JOIN student ON logs.user_id = student.studentid WHERE logs.user_type = '0') ORDER BY created_at DESC;");
            echo "<table class='rtable'>";
            echo "<tr style='background-color: #1aa7ec;'>";
            //Table header
            echo "<th>"; echo "User"; echo "</th>";
            echo "<th>"; echo "Role"; echo "</th>";
            echo "<th>"; echo "Action/Event/Message"; echo "</th>";
            echo "<th>"; echo "Datetime"; echo "</th>";
            echo "</tr>";

            while($row=mysqli_fetch_assoc($res))
            {
                echo "<tr>";
                echo "<td>"; echo $row['user_name']; echo "</td>";
                echo "<td>"; echo $row['user_type'] == 1 ? "admin" : "student"; echo "</td>";
                echo "<td>"; echo $row['message']; echo "</td>";
                echo "<td>"; echo $row['created_at']; echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

            }
        ?> 
        </div>
    </div>
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