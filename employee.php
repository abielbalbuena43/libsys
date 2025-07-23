<?php

include __DIR__ . "/includes/connection.php";
include __DIR__ . '/mailer.php';
include "student_navbar.php";
include __DIR__ . '/logger.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dela Paz National High School</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="banner">
        <div class="form">
        <div class="form-container">
                <div class="form-btn">
                    <span onclick="login()">Login</span>
                    <span onclick="reg()">Register</span>
                    <hr id="indicator">
                </div>
                <form action="" id="loginform" method="post">
                    <input type="text" placeholder="Employee ID" name="emp_id" required>
                    <input type="password" placeholder="Password" name="Password" id="Pass" required>
                    <span class='show-hide'><i class="fas fa-eye" id="eye"></i></span>
                    <button type="submit" class="btn" name="login" style="margin-top:-10px;">Login</button>
                    <span onclick="reg()" style="color: #1aa7ec;">Sign Up</span>
                    <a href="employee_forgot_password.php">Forgot Password?</a>
                </form>
                <form action="" id="regform" method="post" enctype="multipart/form-data">
                    <input type="text" placeholder="Employee ID" name="emp_id" required>
                    <input type="text" placeholder="User Name" name="emp_username" required>
                    <input type="text" placeholder="First Name" name="fname" required>
                    <input type="text" placeholder="Last Name" name="lname" required>
                    <input type="email" placeholder="Email" name="Email" required>
                    <input type="text" name="PhoneNumber" placeholder="Phone Number" required>
                    <input type="text" name="Password" placeholder="Password" required>
                    <input type="text" name="Cpassword" placeholder="Confirm Password" required>
                    <div class="label">
                        <label for="pic">Upload Picture :</label>
                    </div>
                    <input type="file"  name="file" class="file" value="">
                    <!-- <div class="label">
                        <label for="pic">Upload your profile picture : </label><br>
                    </div>
                    <input type="file" name="pic" class="file"> -->
                    <button type="submit" class="btn" name="register">Register</button>
                </form>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['login'])) {
        $emp_id = $_POST['emp_id'];
        $password = $_POST['Password'];

        $res = mysqli_query($db, "SELECT * FROM `employee` WHERE employee_id='$emp_id' AND password='$password';");
        $count = mysqli_num_rows($res);
        $row = mysqli_fetch_assoc($res);

        if ($count == 0) {
            ?>
            <script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "The username or password doesn't match.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>
            <?php
        } else {
            $studentid = $row['studentid'];
            $overdue_check = mysqli_query($db, "
                SELECT MAX(duedate) AS latest_due_date 
                FROM `issueinfo` 
                WHERE (approve = '<p class=\"expired-pill\">OVERDUE</p>' OR approve = '<p class=\"lost-pill\">LOST</p>' OR approve = '<p class=\"stolen-pill\">STOLEN</p>') 
                AND studentid = '$studentid'
            ");
            $overdue_row = mysqli_fetch_assoc($overdue_check);
            $latest_due_date = $overdue_row['latest_due_date'];

            if ($latest_due_date) {
                $suspension_end_date = date('Y-m-d', strtotime($latest_due_date . ' +3 days'));
                $current_date = date('Y-m-d');

                if ($current_date <= $suspension_end_date) {
                    ?>
                    <script type="text/javascript">
                        Swal.fire({
                            title: "Account Suspended",
                            text: "Your account is suspended for overdue/lost/stolen book until <?php echo $suspension_end_date; ?>.",
                            icon: "warning",
                            confirmButtonText: "OK"
                        });
                    </script>
                    <?php
                    return;
                }
            }

            $_SESSION['login_emp_username'] = $row['username'];
            $_SESSION['studentid'] = $row['id'];
            $_SESSION['pic'] = $row['pic'];
            $_SESSION['userid'] = $row['id'];
            $_SESSION['type'] = 3;

            logger($db, $_SESSION['id'], '0', 'Logged in');

            ?>
            <script type="text/javascript">
                window.location = "employee_dashboard.php";
            </script>
            <?php
        }
    }
    ?>

    <?php

    if(isset($_POST['register']) && !empty($_FILES["file"]["name"]))
    {
        if (!preg_match('/^(09\d{9}|\+639\d{9})$/', $_POST['PhoneNumber'])) {
            echo '<script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Invalid phone number",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
        }else if (!preg_match('/^\d{7}$/', $_POST['emp_id'])) {
            echo '<script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Invalid Employee ID",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
        }else{

            $length = 8;
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $password = '';
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }

            $student_sql = "SELECT MAX(studentid) AS max_studentid FROM student";
            $employee_sql = "SELECT MAX(id) AS max_empid FROM employee";
            
            $student_res = mysqli_query($db, $student_sql);
            $employee_res = mysqli_query($db, $employee_sql);

            $max_studentid = mysqli_fetch_assoc($student_res)['max_studentid'] ?? 0;
            $max_empid = mysqli_fetch_assoc($employee_res)['max_empid'] ?? 0;

            $next_id = max($max_studentid, $max_empid) + 1;

            $count=0;
            $sql="SELECT * from employee";
            $res=mysqli_query($db,$sql);
            

            while($row=mysqli_fetch_assoc($res))
            {
                if($row['username']==$_POST['emp_username'])
                {
                    $count=$count+1;
                }
            }
            if($count==0)
            {
                move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);
                $pic = $_FILES['file']['name'];
                mysqli_query($db,"INSERT INTO `employee` VALUES($next_id,'$_POST[emp_id]','$_POST[emp_username]','$_POST[fname]','$_POST[lname]','$_POST[Email]','$password','$_POST[PhoneNumber]','$pic',1);");

                    $message = "Hi there,<br><br>
                    Thank you for registering on DPNHS Library Website. You can now use our different library services.<br><br>
                    This is your temporary password<br>
                    Password: ".$password."<br><br>
                    This is temporary. please change once you logged in.<br><br>
                    Thanks,<br>
                    DPNHS Library";
                    
                    $mail->setFrom('delapaznhs11@gmail.com', 'DPNHS Library');
                    $mail->addAddress($_POST['Email']);
                    $mail->Subject = 'Account Registration';
                    $mail->Body = $message;
            
                    if (!$mail->send()) {
                        echo 'Message could not be sent.';
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    } else {
                        'Message has been sent';
                    }

                    logger($db, $_POST['emp_id'], '0', 'Registered');

                ?>
                    <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Registration successful.",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                    </script>
                <?php		
            }
            else
            {
                ?>
                    <script type="text/javascript">
                    Swal.fire({
                        title: "Error!",
                        text: "This username is already registered.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    </script>
                <?php
            }
        }
    }
    else if(isset($_POST['register']))
    {
        if (!preg_match('/^(09\d{9}|\+639\d{9})$/', $_POST['PhoneNumber'])) {
            echo '<script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Invalid phone number",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
        }else if (!preg_match('/^\d{7}$/', $_POST['emp_id'])) {
            echo '<script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Invalid Employee ID",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
        }else{

            $length = 8;
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $password = '';
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }

            $empid = ''; 
            for ($i = 0; $i < 7; $i++) {
                $empid .= rand(0, 9);
            }

            $student_sql = "SELECT MAX(studentid) AS max_studentid FROM student";
            $employee_sql = "SELECT MAX(id) AS max_empid FROM employee";
            
            $student_res = mysqli_query($db, $student_sql);
            $employee_res = mysqli_query($db, $employee_sql);

            $max_studentid = mysqli_fetch_assoc($student_res)['max_studentid'] ?? 0;
            $max_empid = mysqli_fetch_assoc($employee_res)['max_empid'] ?? 0;

            $next_id = max($max_studentid, $max_empid) + 1;

            $count=0;
            $sql="SELECT * from student";
            $res=mysqli_query($db,$sql);

            while($row=mysqli_fetch_assoc($res))
            {
                if($row['username']==$_POST['emp_username'])
                {
                    $count=$count+1;
                }
            }
            if($count==0)
            {
                mysqli_query($db,"INSERT INTO `employee` VALUES($next_id,'$_POST[emp_id]','$_POST[emp_username]','$_POST[fname]','$_POST[lname]','$_POST[Email]','$password','$_POST[PhoneNumber]','user2.png',1);");

                $message = "Hi there,<br><br>
                    Thank you for registering on DPNHS Library Website. You can now use our different library services.<br><br>
                    This is your temporary password<br>
                    Password: ".$password."<br><br>
                    This is temporary. please change once you logged in.<br><br>
                    Thanks,<br>
                    DPNHS Library";
                
                $mail->setFrom('delapaznhs11@gmail.com', 'DPNHS Library');
                $mail->addAddress($_POST['Email']);
                $mail->Subject = 'Account Registration';
                $mail->Body = $message;
        
                if (!$mail->send()) {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    'Message has been sent';
                }

                logger($db, $_POST['emp_id'], '0', 'Registered');
                ?>
                    <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Registration successful.",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                    </script>
                <?php		
            }
            else
            {
                ?>
                    <script type="text/javascript">
                    Swal.fire({
                        title: "Error!",
                        text: "This username is already registered.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    </script>
                <?php
            }
        }
    }
    ?>

    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>

    <script>
        var LoginForm = document.getElementById("loginform");
        var regform = document.getElementById("regform");
        var indicator = document.getElementById("indicator");
        
        function reg(){
            regform.style.transform = "translateX(-365px)";
            LoginForm.style.transform = "translateX(-400px)";
            indicator.style.transform = "translateX(150px)";
        }
        function login(){
            regform.style.transform = "translateX(0px)";
            LoginForm.style.transform = "translateX(0px)";
            indicator.style.transform = "translateX(0px)";
        }
    
    </script>
    <script>
        var pass = document.getElementById("Pass");
        var showbtn = document.getElementById("eye");
        showbtn.addEventListener("click",function(){
            if(pass.type === "password"){
                pass.type = "text";
                showbtn.classList.add("hide");
            }
            else{
                pass.type = "password";
                showbtn.classList.remove("hide");
            }
        });
    </script>
    <script>
        var pass2 = document.getElementById("Pass-reg");
        var showbtn2 = document.getElementById("eye-reg");
        showbtn2.addEventListener("click",function(){
            if(pass2.type === "password"){
                pass2.type = "text";
                showbtn2.classList.add("hide");
            }
            else{
                pass2.type = "password";
                showbtn2.classList.remove("hide");
            }
        });
    </script>
</body>
</html>