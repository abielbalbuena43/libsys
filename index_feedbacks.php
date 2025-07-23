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
    <div class="testimonial" style="height:85vh;">
        <div class="small-container">
        <h2 class="co-title">Feedbacks</h2>
            <div class="row">
            <?php
            $res = mysqli_query($db, "SELECT student.studentpic, fname, lname, feedback.rating, comment FROM feedback JOIN student ON student.studentid = feedback.stdid ORDER BY feedback.rating DESC");
            $total = mysqli_num_rows($res);
            $count = 0;
            while ($count < 3 && $row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="col-3">
                    <i class="fas fa-quote-left"></i>
                    <p><?php
                        echo $row['comment'];
                    ?></p>
                    <div class="rating">
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            if ($i < $row['rating']) {
                                echo '<i class="fas fa-star"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                    </div>
                    <?php
                        echo "<img src='images/".$row['studentpic']."'>";
                        echo "<h3>".$row['fname']. ' ' .$row['lname']."</h3>";
                    ?>
                </div>
                <?php
                $count++;
            }
            ?>
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
