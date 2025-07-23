<?php

include __DIR__ . "/includes/connection.php"; // Adjust path if necessary
include __DIR__ . "/includes/admin_navbar.php"; // Adjust path if necessary
require_once "./logger.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dela Paz National High School</title>
    <link rel="stylesheet" href="style.css">
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
                    <hr id="indicator">
                </div>
                <form action="" id="loginform" method="post">
                    <input type="text" placeholder="User Name" name="username" required>
                    <input type="password" placeholder="Password" name="password" id="adminpass" required>
                    <span class='show-hide-adminpass'><i class="fas fa-eye" id="eye-adminpass"></i></span>
                    <button type="submit" class="btn" name="login">Login</button>
                    <!--<a href="admin_forgot_password.php">Forgot Password?</a>-->
                </form>
            </div>
        </div>
    </div>

    <?php

		if(isset($_POST['login']))
		{
			$res=mysqli_query($db,"SELECT * FROM `admin` WHERE username='$_POST[username]' && password='$_POST[password]';");
			$count=mysqli_num_rows($res);
            $row=mysqli_fetch_assoc($res);
			if($count==0)
			{
				?>
				<script type="text/javascript">
					Swal.fire({
                        title: "Error!",
                        text: "The username or password doesn't match.",
                        icon: "error",
                        button: "OK",
                    });
				</script>
				<?php
			}
			else
			{
				$_SESSION['login_admin_username']=$_POST['username'];
                $_SESSION['pic1'] = $row['pic'];
                $_SESSION['stdusername']='';
                $_SESSION['userid'] = $row['adminid'];

                logger($db, $_SESSION['userid'], '1', 'Logged in');

				?>
				<script type="text/javascript">
					window.location="admin_dashboard.php";
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

    <script>
        var pass2 = document.getElementById("adminpass");
        var showbtn2 = document.getElementById("eye-adminpass");
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