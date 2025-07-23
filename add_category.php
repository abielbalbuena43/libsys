<?php

include __DIR__ . '/includes/connection.php'; // Corrected path to connection.php
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
    <div class="edit-profile-container">
        <div class="form">
            <div class="form-container">
                <div class="form-btn form-password">
                    <span onclick="login()" style="width: 100%;">Add Category</span>
                    <hr id="indicator" class="indi-password add-author">
                </div>
                <form action="" id="loginform" method="post">
                    <input type="text" placeholder="Category Name" name="categoryname" required>
                    <button type="submit" class="btn" name="add">Add</button>
                </form>
            </div>
        </div>
    </div>
    <?php
		if(isset($_POST['add']))
		{

			mysqli_query($db,"INSERT INTO category VALUES('','$_POST[categoryname]') ;");
            logger($db, $_SESSION['userid'], '1', 'Added a new category "'.$_POST['categoryname'].'"');
			?>
			<script type="text/javascript">
				
				Swal.fire({
                    title: "Success!",
                    text: "Category added successfully.",
                    icon: "success",
                    button: "OK",
                });

			</script>
			<?php

		}

	?>
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
</html>