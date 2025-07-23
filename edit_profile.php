<?php
    
	include "./includes/connection.php";
    session_start();
    if(isset($_SESSION['login_emp_username'])){
       include "employee_navbar.php"; 
    }else{
        include "student_navbar.php";
    }
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
            if (isset($_SESSION['login_student_username'])) {
                $user_id = $_SESSION['studentid'];
                $q = "SELECT * FROM student WHERE studentid = '$user_id'";
            } else {
                $user_id = $_SESSION['studentid'];
                $q = "SELECT id AS studentid, username AS student_username, fname, lname, email AS Email, employee_id AS lrn, phone AS PhoneNumber FROM employee WHERE id = '$user_id'";
            }

            $res = mysqli_query($db, $q) or die(mysqli_error($db));

            while ($row = mysqli_fetch_assoc($res)) {
                $student_username = isset($row['student_username']) ? $row['student_username'] : '';
                $fname = $row['fname'];
                $lname = $row['lname'];
                $Email = $row['Email'];
                $PhoneNumber = $row['PhoneNumber'];
                $lrn = $row['lrn'];
            }
        ?>
        <div class="form">
            <div class="form-container edit-form-container">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Edit Profile</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label">
                        <label for="studentid">User ID : </label>
                        <b style="font-size: 15px;">
                        <?php echo $user_id; ?>
                        </b><br>
                    </div>
                    <div class="label">
                        <label for="student_username">User Name : </label>
                    </div>
                    <input type="text" name="student_username" value="<?php echo $student_username; ?>">
                    <div class="label">
                        <label for="fname">First Name : </label>
                    </div>
                    <input type="text" name="fname" value="<?php echo $fname; ?>">
                    <div class="label">
                        <label for="lname">Last Name : </label>
                    </div>
                    <input type="text" name="lname" value="<?php echo $lname; ?>">
                    <div class="label">
                        <label for="Email">Email : </label>
                    </div>
                    <input type="email" name="Email" value="<?php echo $Email; ?>">
                    <div class="label">
                        <label for="PhoneNumber">Phone Number : </label>
                    </div>
                    <input type="text" name="PhoneNumber" value="<?php echo $PhoneNumber; ?>">
                    <div class="label">
                        <?php if(isset($_SESSION['login_student_username'])){ ?>
                            <label for="lrn">LRN : </label>
                        <?php }else{ ?>
                            <label for="lrn">Employee ID : </label> 
                        <?php } ?>
                    </div>
                    <input type="text" name="lrn" value="<?php echo $lrn; ?>">
                    <button type="submit" class="btn" name="change">Update</button>
                </form>
            </div>
        </div>
    </div>

    <?php
		if(isset($_POST['change']))
		{
        
            $student_username = $_POST['student_username'];
			$fname=$_POST['fname'];
            $lname=$_POST['lname'];
			$Email=$_POST['Email'];
			$PhoneNumber=$_POST['PhoneNumber'];
            $lrn=$_POST['lrn'];
            if(isset($_SESSION['login_student_username'])){
			    $_SESSION['login_student_username']=$_POST['student_username'];
            }else{
                $_SESSION['login_emp_username']=$_POST['student_username'];
            }

            if (!preg_match('/^(09\d{9}|\+639\d{9})$/', $PhoneNumber)) {
                echo '<script type="text/javascript">
                        Swal.fire({
                            title: "Error!",
                            text: "Invalid phone number",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                      </script>';
            } else if (!preg_match('/^109\d{12}$/', $lrn) && isset($_SESSION['login_student_username'])) {
                echo '<script type="text/javascript">
                        Swal.fire({
                            title: "Error!",
                            text: "Invalid LRN",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                      </script>';
            } else if (!preg_match('/^\d{7}$/', $lrn) && isset($_SESSION['login_emp_username'])) {
                echo '<script type="text/javascript">
                        Swal.fire({
                            title: "Error!",
                            text: "Invalid Employee ID",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                      </script>';
            } else {
                if (isset($_SESSION['login_student_username'])) {
                    $q1 = "UPDATE student SET lrn='$lrn', student_username='$student_username', fname='$fname', lname='$lname', Email='$Email', PhoneNumber='$PhoneNumber'
                            WHERE studentid='" . $_SESSION['studentid'] . "';";
                } else {
                    $q1 = "UPDATE employee SET employee_id='$lrn', username='$student_username', fname='$fname', lname='$lname', email='$Email', phone='$PhoneNumber'
                            WHERE id='" . $_SESSION['studentid'] . "';";
                }    
            
                if (mysqli_query($db, $q1)) {
                    echo '<script type="text/javascript">
                            Swal.fire({
                                title: "Success!",
                                text: "Profile is updated successfully.",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                ' . (isset($_SESSION['login_student_username']) ? 'window.location="profile.php";' : 'window.location="employee_books.php";') . '
                            });
                          </script>';
                }
            }
            
		}
	?>
</body>
</html>