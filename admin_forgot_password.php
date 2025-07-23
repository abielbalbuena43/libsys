<?php

    include "./includes/connection.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dela Paz National High School Library</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="./images/logo1.png" alt="Logo" style="border-radius: 50%;"></a> 
                </div>
                <div class="title">
                <a href="index.php"><h3>Dela Paz National High School Library</h3></a>
                </div>
                <nav>
                    <ul id="menuitems">
                        <li><a href="index.php"><i class="fas fa-home"></i>  Home</a></li>
                        <li><a href=""><i class="fas fa-book"></i> Books</a></li>
                        <!-- <li><a href="">About Us</a></li>
                        <li><a href="">Contact</a></li> -->
                        <li><a href="admin.php"><i class="fas fa-user-shield"></i> Admin</a></li>
                        <li><a href="student.php"><i class="fas fa-users"></i> Student</a></li>
                    </ul>
                </nav>
               <!-- <a href="cart.html"><img src="images/cart.png" alt="Cart" width="50px" height="50px" style="margin-left: 10px;" class="cart-icon"></a> 
                <img src="images/menu.png" alt="Menu" class="menu-icon" onclick="menutoggle()"> -->
            </div>
        </div>
    </div>
    <div class="banner">
        <div class="form">
            <div class="form-container">
                <div class="form-btn form-password">
                    <span onclick="login()" style="width: 100%;">Recover Password</span>
                    <hr id="indicator" class="indi-password">
                </div>
                <form action="" id="loginform" method="post">
                    <input type="text" placeholder="User Name" name="username" required>
                    <input type="password" placeholder="Enter New Password" name="password" id="adminpass2" required>
                    <span class='show-hide-adminpass2'><i class="fas fa-eye" id="eye-adminpass2"></i></span>
                    <button type="submit" class="btn" name="change">Change</button>
                </form>
            </div>
        </div>
    </div>

    <?php

		if(isset($_POST['change']))
		{

			$res=mysqli_query($db,"SELECT * FROM `admin` WHERE username='$_POST[username]' ;");
			$count=mysqli_num_rows($res);
			if($count==0)
			{
				?>
				<script type="text/javascript">
					Swal.fire({
                        title: "Error!",
                        text: "The username doesn't match.",
                        icon: "error",
                        button: "OK",
                    });
				</script>
				<?php
			}
			else
			{
				if(mysqli_query($db,"UPDATE admin SET password='$_POST[password]' WHERE username='$_POST[username]';"))
				{
					?>
					<script type="text/javascript">
						Swal.fire({
                            title: "Success!",
                            text: "Your password has been successfully changed.",
                            icon: "success",
                            button: "OK",
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
        var pass2 = document.getElementById("adminpass2");
        var showbtn2 = document.getElementById("eye-adminpass2");
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