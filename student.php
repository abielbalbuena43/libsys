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
                    <input type="text" placeholder="LRN" name="lrn" required>
                    <input type="password" placeholder="Password" name="Password" id="Pass" required>
                    <span class='show-hide'><i class="fas fa-eye" id="eye"></i></span>
                    <button type="submit" class="btn" name="login" style="margin-top:-10px;">Login</button>
                    <span onclick="reg()" style="color: #1aa7ec;">Sign Up</span>
                    <a href="student_forgot_password.php">Forgot Password?</a>
                </form>
                <form action="" id="regform" method="post" enctype="multipart/form-data">
                    <input type="text" placeholder="User Name" name="student_username" required>
                    <input type="text" placeholder="LRN" name="lrn" required>
                    <select name="yearlvl" required>
                        <option selected disabled>Select year level</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                    <input type="text" placeholder="First Name" name="fname" required>
                    <input type="text" placeholder="Last Name" name="lname" required>
                    <input type="email" placeholder="Email" name="Email" required>
                    <input type="text" name="PhoneNumber" placeholder="Phone Number" required>
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
        $lrn = $_POST['lrn'];
        $password = $_POST['Password'];

        $res = mysqli_query($db, "SELECT * FROM `student` WHERE lrn='$lrn' AND password='$password';");
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
            $suspension_date = $row['suspension'];
            $current_date = date('Y-m-d');

            // Check if the student is suspended and the suspension date is still in the future
            if ($suspension_date && $current_date <= $suspension_date) {
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Account Suspended",
                        text: "Your account is suspended until <?php echo $suspension_date; ?>.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                </script>
                <?php
                return;
            }

            // Proceed with login if no suspension
            $_SESSION['login_student_username'] = $row['student_username'];
            $_SESSION['studentid'] = $row['studentid'];
            $_SESSION['pic'] = $row['studentpic'];
            $_SESSION['userid'] = $row['studentid'];
            $_SESSION['type'] = $row['type'];

            logger($db, $_SESSION['userid'], '0', 'Logged in');

            ?>
            <script type="text/javascript">
                window.location = "student_dashboard.php";
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
                    title: "Invalid Input",
                    text: "Invalid phone number",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';

        }else if (!preg_match('/^\d{15}$/', $_POST['lrn'])) {
            echo '<script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Invalid  LRN",
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

            $count=0;
            $sql="SELECT * from student";
            $res=mysqli_query($db,$sql);
            

            while($row=mysqli_fetch_assoc($res))
            {
                if($row['student_username']==$_POST['student_username'])
                {
                    $count=$count+1;
                }
            }
            if($count==0)
            {
                move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);
                $pic = $_FILES['file']['name'];
                mysqli_query($db,"INSERT INTO `student` (lrn, yearlvl, student_username, fname, lname, Email, Password, PhoneNumber, studentpic, type, status) VALUES('$_POST[lrn]','$_POST[yearlvl]','$_POST[student_username]','$_POST[fname]','$_POST[lname]','$_POST[Email]','$password','$_POST[PhoneNumber]','$pic',0,1);");

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

                    logger($db, $_POST['lrn'], '0', 'Registered');

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
                        title: "Registration Error",
                        text: "This username is already registered.",
                        icon: "warning",
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
                    title: "Invalid Input",
                    text: "Invalid phone number",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';

        }else if (!preg_match('/^\d{15}$/', $_POST['emp_id'])) {
            echo '<script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Invalid LRN",
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

            $count=0;
            $sql="SELECT * from student";
            $res=mysqli_query($db,$sql);

            while($row=mysqli_fetch_assoc($res))
            {
                if($row['student_username']==$_POST['student_username'])
                {
                    $count=$count+1;
                }
            }
            if($count==0)
            {
            mysqli_query($db,"INSERT INTO `student` (lrn, yearlvl, student_username, fname, lname, Email, Password, PhoneNumber, studentpic, type, status) VALUES('$_POST[lrn]','$_POST[yearlvl]','$_POST[student_username]','$_POST[fname]','$_POST[lname]','$_POST[Email]','$password','$_POST[PhoneNumber]','user2.png',0,1);");

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

                logger($db, $_POST['lrn'], '0', 'Registered');
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
                        title: "Registration Error",
                        text: "This username is already registered.",
                        icon: "warning",
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