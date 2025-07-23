<?php


include __DIR__ . '/includes/connection.php'; 
include __DIR__ . '/includes/admin_navbar.php';
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
			
            $page=$_GET['page'];
			$id=$_GET['id'];
			$q= "SELECT * FROM student WHERE studentid = '".$id."'";
			$res=mysqli_query($db,$q) or die(mysqli_error());
			
			while($row=mysqli_fetch_assoc($res))
			{
                $pic = $row['studentpic'];
				$studentid=$row['studentid'];
                $username=$row['student_username'];
				$fullname=$row['fname'] . ' ' . $row['lname'];
				$email=$row['Email'];
				$pnum=$row['PhoneNumber'];
                $yearlvl=$row['yearlvl'];
                $lrn=$row['lrn'];
                $type=$row['type'];
                $suspension=$row['suspension'];
			}
	    ?>
        <div class="form form-book">
            <div class="form-container edit-form-container" style="height:400px; overflow:auto;">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Suspension</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label book-img">
                        <?php echo "<img width='50px' height='50px' src='images/".$pic."'>"?>
                    </div>
                    <div class="label">
                        <label for="studentid">Student ID : </label>
                        <b style="font-size: 15px;">
                        <?php
			                echo $studentid;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="email">LRN : <?php echo $lrn; ?></label>
                    </div>
                    <div class="label">
                        <label for="fullname">Fullname : <?php echo $fullname; ?></label>
                    </div>
                    <div class="label">
                        <label for="suspension">Suspend Until :</label>
                    </div>
                    <input type="date" name="suspension" value="<?php echo $suspension; ?>" min="<?php echo date('Y-m-d'); ?>">
                    <div class="label">
                        <label for="reason">Reason for Suspension :</label>
                    </div>
                    <input type="text" name="reason" >
                    <button type="submit" class="btn" name="submit">Suspend</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit']))
        {
            
            $suspension=$_POST['suspension'];
            $reason=$_POST['reason'];
        
            $q1="UPDATE student SET suspension='$suspension', reason='$reason' WHERE studentid=".$id.";";
            if(mysqli_query($db,$q1))
            {
                logger($db, $_SESSION['userid'], '1', 'Suspended student with id "'.$id.'"');
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Student suspended successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            <?php if($page == '0'){ ?>
                                window.location = "expired.php";
                            <?php } else { ?>
                                window.location = "stolen.php";
                            <?php } ?>
                        }
                    });
                </script>
                <?php
            }
        }
		?>
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
</html>