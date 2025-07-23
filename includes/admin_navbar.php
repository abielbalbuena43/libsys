<?php
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Ensure that the database connection is available
    if (!isset($db)) {
        // 
        include __DIR__ . "/includes/connection.php";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php
    if (isset($_SESSION['login_admin_username'])) {
        // Fetching the number of unread messages from the database
        $r = mysqli_query($db, "SELECT COUNT(status) as total FROM message WHERE status='no' AND sender='student';");
        $c = mysqli_fetch_assoc($r);
    ?>
        <div class="header">
            <div class="container">
                <div class="navbar">
                    <div class="logo">
                        <a href="index.php"><img src="images/logo1.png" width="30px" height="30px" alt="Logo" style="border-radius: 50%;"></a>
                    </div>
                    <div class="admin-title">
                        <a href="index.php"><h3 style="font-size: 16px;">Dela Paz National High School Library</h3></a>
                    </div>
                    <div class="admin-navbar">
                        <ul id="menuitems">
                            <li><a href="admin_dashboard.php">Dashboard</a></li>
                            <li><a href="employee_info.php">Employee Info</a></li>
                            <li><a href="student_info.php">Student Info</a></li>
                            <li class="dropdown">
                                <button onclick="myFunction2()" class="dropbtn admindrop">Authors <i class="fas fa-caret-down"></i></button>
                                <ul class="dropdown-content" id="myDropdown2">
                                    <li><a href="add_author.php">Add Author</a></li>
                                    <li><a href="manage_authors.php">Manage Authors</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <button onclick="myFunction3()" class="dropbtn admindrop">Categories <i class="fas fa-caret-down"></i></button>
                                <ul class="dropdown-content" id="myDropdown3">
                                    <li><a href="add_category.php">Add Category</a></li>
                                    <li><a href="manage_categories.php">Manage Categories</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <button onclick="myFunction4()" class="dropbtn admindrop">Books <i class="fas fa-caret-down"></i></button>
                                <ul class="dropdown-content" id="myDropdown4">
                                    <li><a href="add_book.php">Add Book</a></li>
                                    <li><a href="manage_books.php">Manage Books</a></li>
                                    <li><a href="trending_books.php">Trending Books</a></li>
                                    <li><a href="request_info.php">Request Info</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <button onclick="myFunction5()" class="dropbtn admindrop">Issue Info <i class="fas fa-caret-down"></i></button>
                                <ul class="dropdown-content issuedrop" id="myDropdown5">
                                    <li><a href="manage_issued_books.php">Issued Books</a></li>
                                    <li><a href="returned.php">Returned Books</a></li>
                                    <li><a href="expired.php">Overdue Books</a></li>
                                    <li><a href="stolen.php">Lost/Stolen Books</a></li>
                                    <!-- <li><a href="lost.php">Lost Books</a></li> -->
                                    <li><a href="discarded.php">Discarded Books</a></li>
                                    <li><a href="borrow.php">Borrow History</a></li>
                                </ul>
                            </li>
                            <li><a href="feedback_info.php">Feedback List</a></li>
                            <li><a href="logs.php">Logs</a></li>
                            <li><a href="admin_message.php" id="envelope"><i class="fas fa-envelope"></i>
                            <?php
                            if ($c['total'] > 0 && $c['total'] <= 9) {
                                ?>
                                <sup style="border-radius: 50px; background-color: red; padding: 0 5px;"><?php echo $c['total']; ?></sup>
                                <?php
                            } else if ($c['total'] > 9) {
                                ?>
                                <sup style="border-radius: 50px; background-color: red; padding: 0 5px;">9+</sup>
                                <?php
                            }
                            ?>
                            </a></li>
                            
                            <li class="dropdown">
                                <button onclick="myFunction()" class="dropbtn">
                                <?php
                                    echo "<img class='user-img' src='images/".$_SESSION['pic1']."'>";
                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['login_admin_username'];
                                ?>&nbsp;&nbsp;<i class="fas fa-caret-down"></i></button>
                                <ul class="dropdown-content" id="myDropdown">
                                    <li><a href="admin_update_password.php">Change Password</a></li>
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
    } else {
    ?>
        <div class="header">
            <div class="container">
                <div class="navbar">
                    <div class="logo">
                       <a href="index.php"><img src="images/logo1.png" alt="Logo" style="border-radius: 50%;"></a> 
                    </div>
                    <div class="title">
                    <a href="index.php"><h3 style="font-size: 20px;">Dela Paz National High School Library</h3></a>
                    </div>
                    <nav>
                        <ul id="menuitems">
                            <li><a href="admin.php"><i class="fas fa-user-shield"></i> Admin</a></li>
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
            document.getElementById("myDropdown").style.display = "block";
            document.getElementById("myDropdown2").style.display = "none";
            document.getElementById("myDropdown3").style.display = "none";
            document.getElementById("myDropdown4").style.display = "none";
            document.getElementById("myDropdown5").style.display = "none";
        }
        function myFunction2() {
            document.getElementById("myDropdown2").style.display = "block";
            document.getElementById("myDropdown").style.display = "none";
            document.getElementById("myDropdown3").style.display = "none";
            document.getElementById("myDropdown4").style.display = "none";
            document.getElementById("myDropdown5").style.display = "none";
        }
        function myFunction3() {
            document.getElementById("myDropdown3").style.display = "block";
            document.getElementById("myDropdown").style.display = "none";
            document.getElementById("myDropdown2").style.display = "none";
            document.getElementById("myDropdown4").style.display = "none";
            document.getElementById("myDropdown5").style.display = "none";
        }
        function myFunction4() {
            document.getElementById("myDropdown4").style.display = "block";
            document.getElementById("myDropdown").style.display = "none";
            document.getElementById("myDropdown2").style.display = "none";
            document.getElementById("myDropdown3").style.display = "none";
            document.getElementById("myDropdown5").style.display = "none";
        }
        function myFunction5() {
            document.getElementById("myDropdown5").style.display = "block";
            document.getElementById("myDropdown").style.display = "none";
            document.getElementById("myDropdown2").style.display = "none";
            document.getElementById("myDropdown3").style.display = "none";
            document.getElementById("myDropdown4").style.display = "none";
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display == "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }

    </script>
    <script>
        const currentlocation = location.href;
        const menuitem = document.querySelectorAll('a');
        const menulength = menuitem.length;
        for (let i = 0; i < menulength; i++) {
            if (menuitem[i].href === currentlocation) {
                menuitem[i].className = "active";
            }
        }
    </script>
</body>
</html>
