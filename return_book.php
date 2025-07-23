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
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    <?php
        
        $studentid=$_GET['ed'];
        $bookid=$_GET['ed1'];
        $issueid=$_GET['issueid'];


        $d=date("Y-m-d");
        $var='<p class="expired-pill">EXPIRED</p>';
        $var1='<p class="approve-return-pill">RETURNED</p>';
        $var2='<p class="pending-pill">PENDING RETURN</p>';
        
        $q2=mysqli_query($db,"UPDATE issueinfo SET returndate='$d',approve='$var2' where issueid='$issueid';");
        mysqli_query($db,"DELETE from timer where stdid='$studentid' and bid='$bookid';");
        $res=mysqli_query($db,"SELECT quantity from books where bookid=$bookid;");
        while($row=mysqli_fetch_assoc($res))
        {
            if($row['quantity']==0)
            {
                mysqli_query($db,"UPDATE books SET quantity=quantity+1, status='Available' where bookid=$bookid;");
            }
            else
            {
                mysqli_query($db,"UPDATE books SET quantity=quantity+1 where bookid=$bookid;");
            }
            
        }
        logger($db, $_SESSION['userid'], '0', 'Returned a book with issue id "'.$issueid.'"');
        ?>
        <script type="text/javascript">
            Swal.fire({
                title: "Success!",
                text: "Book returned successfully.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "manage_issued_books.php";
            });
        </script>
        <?php
        
    ?>
    
</body>
</html>