<?php

	session_start();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dela Paz National High School Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php
    if(isset($_SESSION['login_student_username']))
    {
       ?>
       <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                   <a href="index.php" class="logo"><img src="images/logo1.png" alt="logo" style="border-radius: 50%;"></a> 
                </div>
                <div class="title admin-title">
                <a href="index.php"><h3>Dela Paz National High School Library</h3></a>
                </div>
                <div class="student-navbar">
                
                    <ul id="menuitems">
                        <li><a href="index.php"><i class="fas fa-home"></i>  Home</a></li>
                        <!-- <li><a href="index_books.php"><i class="fas fa-book"></i> Books</a></li> -->
                        <!--<li><a href="index_scanbook.php"><i class="fas fa-qrcode"></i> Scan Book</a></li>-->
                        <li><a href="index_feedbacks.php"><i class="fas fa-book"></i> Feedbacks</a></li>
                        <li class="dropdown">
                            <button onclick="myFunction()" class="dropbtn">
                            <?php
                                echo "<img class='user-img' src='images/".$_SESSION['pic']."'>";
                                
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['login_student_username'];
                            ?>&nbsp;&nbsp;<i class="fas fa-caret-down"></i></button>
                            <ul class="dropdown-content" id="myDropdown">
                                <li><a href="profile.php">My Profile</a></li>
                                <li><a href="student_update_password.php">Change Password</a></li>
                                <!-- <li><a href="">Change Picture</a></li> -->
                                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> &nbsp; Logout</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </div>
               <!-- <a href="cart.html"><img src="images/cart.png" alt="Cart" width="50px" height="50px" style="margin-left: 10px;" class="cart-icon"></a> 
                <img src="images/menu.png" alt="Menu" class="menu-icon" onclick="menutoggle()"> -->
            </div>
        </div>
    </div>
    <?php
    }
    else if(isset($_SESSION['login_admin_username']))
    {
       ?>
       <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                   <a href="index.php"><img src="images/logo1.png" alt="Logo" style="border-radius: 50%;"></a> 
                </div>
                <div class="title admin-title">
                <a href="index.php"><h3>Dela Paz National High School Library</h3></a>
                </div>
                <div class="student-navbar">
                
                    <ul id="menuitems">
                        <li><a href="index.php"><i class="fas fa-home"></i>  Home</a></li>
                        <!-- <li><a href="index_books.php"><i class="fas fa-book"></i> Books</a></li> -->
                        <li><a href="index_feedbacks.php"><i class="fas fa-book"></i> Feedbacks</a></li>
                        <li class="dropdown">
                            <button onclick="myFunction()" class="dropbtn">
                            <?php
                                echo "<img class='user-img' src='images/".$_SESSION['pic1']."'>";
                                
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['login_admin_username'];
                            ?>&nbsp;&nbsp;<i class="fas fa-caret-down"></i></button>
                            <ul class="dropdown-content" id="myDropdown">
                                <li><a href="student_update_password.php">Change Password</a></li>
                                <!-- <li><a href="">Change Picture</a></li> -->
                                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> &nbsp; Logout</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </div>
               <!-- <a href="cart.html"><img src="images/cart.png" alt="Cart" width="50px" height="50px" style="margin-left: 10px;" class="cart-icon"></a> 
                <img src="images/menu.png" alt="Menu" class="menu-icon" onclick="menutoggle()"> -->
            </div>
        </div>
    </div>
    <?php
    }
    else{
        ?>
        <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                   <a href="index.php"><img src="images/logo1.png" alt="Logo" style="border-radius: 50%;"></a> 
                </div>
                <div class="title">
                <a href="index.php"><h3 style="">Dela Paz National High School Library</h3></a>
                </div>
                <nav>
                    <ul id="menuitems">
                        <li><a href="index.php"><i class="fas fa-home"></i>  Home</a></li>
                        <!-- <li><a href="index_books.php"><i class="fas fa-book"></i> Books</a></li> -->
                        <!--<li><a href="index_scanbook.php"><i class="fas fa-qrcode"></i> Scan Book</a></li>-->
                        <li><a href="index_feedbacks.php"><i class="fas fa-comments"></i> Feedbacks</a></li>
                        <li><a href="index_about.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                        <!-- <li><a href="">Contact</a></li> -->
                        <!-- <li><a href="admin.php"><i class="fas fa-user-shield"></i> Admin</a></li> -->
                        <li><a href="student.php"><i class="fas fa-users"></i> Student</a></li>
                        <li><a href="employee.php"><i class="fas fa-users"></i> Employee</a></li>
                    </ul>
                </nav>
               <!-- <a href="cart.html"><img src="images/cart.png" alt="Cart" width="50px" height="50px" style="margin-left: 10px;" class="cart-icon"></a> 
                <img src="images/menu.png" alt="Menu" class="menu-icon" onclick="menutoggle()"> -->
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
    <script>
        const currentlocation = location.href;
        const menuitem = document.querySelectorAll('a');
        const menulength = menuitem.length;
        for(let i=0; i<menulength;i++){
            if (!menuitem[i].classList.contains('logo') && menuitem[i].href === currentlocation) {
                menuitem[i].className = "active";
            }
        }
    </script>
</body>
</html>