<?php
include __DIR__ . '/includes/connection.php'; 
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
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="edit-profile-container" style="min-height: 85vh;">
        <?php
            $id = $_GET['id'];
            $q = "SELECT * FROM student WHERE studentid = '".$id."'";
            $res = mysqli_query($db, $q) or die(mysqli_error($db));
            
            while($row = mysqli_fetch_assoc($res)) {
                $pic = $row['studentpic'];
                $studentid = $row['studentid'];
                $username = $row['student_username'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $email = $row['Email'];
                $pnum = $row['PhoneNumber'];
                $yearlvl = $row['yearlvl'];
                $lrn = $row['lrn'];
                $type = $row['type'];
            }
        ?>
        <div class="form form-book">
            <div class="form-container edit-form-container" style="height:600px; overflow:auto;">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Edit Student Info</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label book-img">
                        <?php echo "<img width='50px' height='50px' src='images/".$pic."'>"?>
                    </div>
                    <div class="label">
                        <label for="studentid">Student ID : </label>
                        <b style="font-size: 15px;">
                            <?php echo $studentid; ?>
                        </b><br>
                    </div>
                    <div class="label">
                        <label for="lrn">LRN : </label>
                    </div>
                    <input type="number" placeholder="LRN" name="lrn" value="<?php echo $lrn; ?>" required>
                    <div class="label">
                        <label for="username">Username : </label>
                    </div>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                    <div class="label">
                        <label for="fname">First Name : </label>
                    </div>
                    <input type="text" name="fname" value="<?php echo $fname; ?>" required>
                    <div class="label">
                        <label for="lname">Last Name : </label>
                    </div>
                    <input type="text" name="lname" value="<?php echo $lname; ?>" required>
                    <div class="label">
                        <label for="email">Email : </label>
                    </div>
                    <input type="text" name="email" value="<?php echo $email; ?>">
                    <div class="label">
                        <label for="pnum">Phone Number : </label>
                    </div>
                    <input type="text" name="pnum" value="<?php echo $pnum; ?>">
                    <div class="label">
                        <label for="yearlvl">Year Level : </label>
                    </div>
                    <select name="yearlvl" required>
                        <option selected disabled>Select year level</option>
                        <option value="Grade 7" <?php echo $yearlvl == 'Grade 7' ? 'selected' : '' ?>>Grade 7</option>
                        <option value="Grade 8" <?php echo $yearlvl == 'Grade 8' ? 'selected' : '' ?>>Grade 8</option>
                        <option value="Grade 9" <?php echo $yearlvl == 'Grade 9' ? 'selected' : '' ?>>Grade 9</option>
                        <option value="Grade 10" <?php echo $yearlvl == 'Grade 10' ? 'selected' : '' ?>>Grade 10</option>
                        <option value="Grade 11" <?php echo $yearlvl == 'Grade 11' ? 'selected' : '' ?>>Grade 11</option>
                        <option value="Grade 12" <?php echo $yearlvl == 'Grade 12' ? 'selected' : '' ?>>Grade 12</option>
                    </select>
                    <div class="label">
                        <label for="type">Type : </label>
                    </div>
                    <select name="type" required>
                        <option selected disabled>Select year level</option>
                        <option value="0" <?php echo $type == '0' ? 'selected' : '' ?>>Student</option>
                        <option value="1" <?php echo $type == '1' ? 'selected' : '' ?>>Student Assistant</option>
                    </select>
                    <div class="label">
                        <label for="pic">Update Picture :</label>
                    </div>
                    <input type="file" name="file" class="file">
                    <button type="submit" class="btn" name="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit'])) {
            $username = $_POST['username'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $pnum = $_POST['pnum'];
            $lrn = $_POST['lrn'];
            $yearlvl = $_POST['yearlvl'];
            $type = $_POST['type'];

            if (!preg_match('/^\d{12}$/', $_POST['lrn'])) {
                echo '<script type="text/javascript">
                    Swal.fire({
                        title: "Error!",
                        text: "Invalid  LRN",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                </script>';
            }else{
            
                if(!empty($_FILES["file"]["name"])) {
                    move_uploaded_file($_FILES['file']['tmp_name'], "images/".$_FILES['file']['name']);
                    $pic = $_FILES['file']['name'];
                    $q1 = "UPDATE student SET studentpic = '$pic', student_username='$username', fname='$fname', lname='$lname', Email='$email', PhoneNumber='$pnum', lrn='$lrn', yearlvl='$yearlvl', type='$type' WHERE studentid=".$id.";";
                } else {
                    $q1 = "UPDATE student SET student_username='$username', fname='$fname', lname='$lname', Email='$email', PhoneNumber='$pnum', lrn='$lrn', yearlvl='$yearlvl', type='$type' WHERE studentid=".$id.";";
                }
                
                if(mysqli_query($db, $q1)) {
                    logger($db, $_SESSION['userid'], '1', 'Updated student with id "'.$id.'"');
                    ?>
                    <script type="text/javascript">
                        Swal.fire({
                            title: "Success!",
                            text: "Student updated successfully.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "student_info.php";
                        });
                    </script>
                    <?php
                } else {
                    echo "<script>alert('Error updating student.');</script>";
                }
            }
        }
    ?>
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
</html>
