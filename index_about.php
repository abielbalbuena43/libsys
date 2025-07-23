<?php
include __DIR__ . "/includes/connection.php";
include "student_navbar.php";

if (!isset($db)) {
    die('Database connection failed.');
}


$res = mysqli_query($db, "SELECT * FROM category");

if (!$res) {
    die('Query failed: ' . mysqli_error($db));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dela Paz National High School</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="footer" style="height:85vh; padding:32px;">
        <div class="footer-row">
            <div class="footer-left">
            <h1>Opening Hours</h1>
                <p><i class="far fa-clock"></i>Monday to Friday - 7 am to 4 pm</p>
            </div>
            <div class="footer-middle">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.1540333649855!2d121.16770900631141!3d14.590297277278752!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b8acc89ed76b%3A0xd3293901f05a2029!2sDela%20Paz%20National%20High%20School!5e0!3m2!1sen!2sph!4v1722444395299!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            </div>
            <div class="footer-right">
                <h1>Get In Touch</h1>
                <p>Dela Paz National High School, Antipolo City<i class="fas fa-map-marker-alt"></i></p>
                <p>delapaznhs2011@gmail.com<i class="fas fa-paper-plane"></i></p>
                <p>02 - 470 - 3945<i class="fas fa-phone-alt"></i></p>
            </div>
        </div>
        
    </div>
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
</html>
