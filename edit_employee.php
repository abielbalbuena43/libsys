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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="edit-profile-container" style="min-height: 85vh;">
        <?php
			
			$id=$_GET['id'];
			$q= "SELECT * FROM employee WHERE employee_id = '".$id."'";
			$res = mysqli_query($db, $q) or die(mysqli_error($db));

			
			while($row=mysqli_fetch_assoc($res))
			{
                $id=$row['id'];
                $pic = $row['pic'];
				$employee_id=$row['employee_id'];
                $username=$row['username'];
                $fname=$row['fname'];
                $lname= $row['lname'];
				$email=$row['email'];
				$pnum=$row['phone'];
			}
	    ?>
        <div class="form form-book">
            <div class="form-container edit-form-container" style="height:600px; overflow:auto;">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Edit Student Info</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label book-img">
                        <?php echo "<img width='50px' height='50px' src='images/".$pic."'>"?>
                    </div>
                    <div class="label">
                        <label for="email">Employee ID : </label>
                    </div>
                    <input type="number" name="emp_id" value="<?php echo $employee_id; ?>" required>
                    <div class="label">
                        <label for="username">Username : </label>
                    </div>
                    <input type="text"  name="username" value="<?php echo $username; ?>">
                    <div class="label">
                        <label for="fname">First Name : </label>
                    </div>
                    <input type="text"  name="fname" value="<?php echo $fname; ?>">
                    <div class="label">
                        <label for="lname">Last Name : </label>
                    </div>
                    <input type="text"  name="lname" value="<?php echo $lname; ?>">
                    <div class="label">
                        <label for="email">Email : </label>
                    </div>
                    <input type="text"  name="email" value="<?php echo $email; ?>">
                    <div class="label">
                        <label for="pnum">Phone Number : </label>
                    </div>
                    <input type="text"  name="pnum" value="<?php echo $pnum; ?>">                
                    <button type="submit" class="btn" name="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit']) && !empty($_FILES["file"]["name"]))
        {
            
            $username=$_POST['username'];
            $fname=$_POST['fname'];
            $lname=$_POST['lname'];
            $email=$_POST['email'];
            $pnum=$_POST['pnum'];
            $emp_id=$_POST['emp_id'];
            move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);
            $pic = $_FILES['file']['name'];

            $q1="UPDATE employee SET pic = '$pic',username='$username',fname='$fname',lname='$lname',email='$email',phone='$pnum',employee_id='$emp_id' where id=".$id.";";
            if(mysqli_query($db,$q1))
            {
                logger($db, $_SESSION['userid'], '1', 'Updated employee with id "'.$id.'"');
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Employee updated successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "employee_info.php";
                    });
                </script>
                <?php
            }
        }
        else if(isset($_POST['submit']))
        {
            
            $username=$_POST['username'];
            $fname=$_POST['fname'];
            $lname=$_POST['lname'];
            $email=$_POST['email'];
            $pnum=$_POST['pnum'];
            $emp_id=$_POST['emp_id'];
        
            $q1="UPDATE employee SET username='$username',fname='$fname',lname='$lname',email='$email',phone='$pnum',employee_id='$emp_id' where id=".$id.";";
            if(mysqli_query($db,$q1))
            {
                logger($db, $_SESSION['userid'], '1', 'Updated employee with id "'.$id.'"');
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Employee updated successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "employee_info.php";
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