<?php


include __DIR__ . '/includes/connection.php'; 
include __DIR__ . '/includes/admin_navbar.php';
include __DIR__ . '/logger.php';
$res1=mysqli_query($db,"SELECT * FROM category");
$res2=mysqli_query($db,"SELECT * FROM authors");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="edit-profile-container">
        <?php
			
			$id=$_GET['ed'];
			$q= "SELECT books.bookpic,books.bookid,books.bookname, books.bookdesc, books.callnum, books.acessionnum, books.year, books.dewey, books.libsection, authors.authorid,authors.authorname,category.categoryid,category.categoryname,books.ISBN,books.price,quantity,status from  `books`join `authors` on authors.authorid=books.authorid join `category` on category.categoryid=books.categoryid where bookid=$id";
			$res = mysqli_query($db, $q) or die(mysqli_error($db));

			
			while($row=mysqli_fetch_assoc($res))
			{
				$bookid=$row['bookid'];
                $pic=$row['bookpic'];
				$bookname=$row['bookname'];
                $bookdesc=$row['bookdesc'];
				$authorid=$row['authorid'];
				$categoryid=$row['categoryid'];
				$authorname=$row['authorname'];
				$categoryname=$row['categoryname'];
				$ISBN=$row['ISBN'];
                $callnum=$row['callnum'];
                $acessionnum=$row['acessionnum'];
                $year=$row['year'];
                $libsection=$row['libsection'];
                $dewey=$row['dewey'];
				$price=$row['price'];
				$quantity=$row['quantity'];
				$status=$row['status'];

			}
	    ?>
        <div class="form form-book">
            <div class="form-container edit-form-container edit-book-container">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Edit Book Info</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label book-img">
                        <?php echo "<img width='50px' height='50px' src='images/".$pic."'>"?>
                    </div>
                    <div class="label">
                        <label for="studentid">Book ID : </label>
                        <b style="font-size: 15px;">
                        <?php
			                echo $bookid;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="bookname">Book Title : </label>
                    </div>
                    <input type="text"  name="bookname" value="<?php echo $bookname; ?>">
                    <div class="label">
                        <label for="bookdesc">Book Description : </label>
                    </div>
                    <input type="text"  name="bookdesc" value="<?php echo $bookdesc; ?>">
                    <div class="label">
                        <label for="authorname">Author Name : </label>
                    </div>
                    <div style="position: relative;">
                        <input type="text" placeholder="Book Author" name="authorname" value="<?php echo $authorname; ?>" required>
                        <div id="author-suggestions" style="position: absolute; background: #fff; border: 1px solid #ccc; display: none; z-index: 1000;"></div>
                    </div>
                    <div class="label">
                        <label for="categoryname">Category Name : </label>
                    </div>
                    <select class="form-control" name="categoryname">
                        <?php while($row=mysqli_fetch_array($res1)):;?>
                            <option value="<?php echo $row[0];?>" <?php echo $row[0] == $categoryid ? 'selected' : '' ?>><?php echo $row[1];?></option>
                        <?php endwhile;?>
                    </select>
                    <div class="label">
                        <label for="ISBN">ISBN : </label>
                    </div>
                    <input type="text"  name="ISBN" value="<?php echo $ISBN; ?>">
                    <div class="label">
                        <label for="callnum">Call Number : </label>
                    </div>
                    <input type="text"  name="callnum" value="<?php echo $callnum; ?>">
                    <div class="label">
                        <label for="acessionnum">Acession Number : </label>
                    </div>
                    <input type="text"  name="acessionnum" value="<?php echo $acessionnum; ?>">
                    <div class="label">
                        <label for="year">Year : </label>
                    </div>
                    <input type="text"  name="year" value="<?php echo $year; ?>">
                    <!-- <div class="label">
                        <label for="libsection">Libray Section : </label>
                    </div>
                    <input type="text"  name="libsection" value="<?php echo $libsection; ?>"> -->
                    <div class="label">
                        <label for="dewey">Dewey Classification : </label>
                    </div>
                    <input type="text"  name="dewey" value="<?php echo $dewey; ?>">
                    <div class="label">
                        <label for="price">Fine : </label>
                    </div>
                    <input type="text"  name="price" value="<?php echo $price; ?>">
                    <div class="label">
                        <label for="quantity">Quantity : </label>
                    </div>
                    <input type="text"  name="quantity" value="<?php echo $quantity; ?>">
                    <div class="label">
                        <label for="status">Status : </label>
                    </div>
                    <input type="text"  name="status" value="<?php echo $status; ?>">
                    <div class="label">
                        <label for="pic">Update Picture :</label>
                    </div>
                    <input type="file"  name="file" class="file">
                    <button type="submit" class="btn" name="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit']) && !empty($_FILES["file"]["name"]))
        {
            
            $bookname = mysqli_real_escape_string($db, $_POST['bookname']);
            $bookdesc = mysqli_real_escape_string($db, $_POST['bookdesc']);
            $authorname = mysqli_real_escape_string($db, $_POST['authorname']);
            $categoryname = mysqli_real_escape_string($db, $_POST['categoryname']);
            $ISBN = mysqli_real_escape_string($db, $_POST['ISBN']);
            $callnumm = mysqli_real_escape_string($db, $_POST['callnum']);
            $acessionnum = mysqli_real_escape_string($db, $_POST['acessionnum']);
            $year = mysqli_real_escape_string($db, $_POST['year']);
            $libsection = '';
            $dewey = mysqli_real_escape_string($db, $_POST['dewey']);
            $price = mysqli_real_escape_string($db, $_POST['price']);
            $quantity = mysqli_real_escape_string($db, $_POST['quantity']);
            $status = mysqli_real_escape_string($db, $_POST['status']);
            move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);
            $pic = $_FILES['file']['name'];

            $authorQuery = mysqli_query($db, "SELECT authorid FROM authors WHERE authorname = '$authorname'");
            if (mysqli_num_rows($authorQuery) > 0) {
                $authorRow = mysqli_fetch_assoc($authorQuery);
                $author_id = $authorRow['authorid'];
            } else {
                mysqli_query($db, "INSERT INTO authors (authorname) VALUES ('$authorname')");
                $author_id = mysqli_insert_id($db);
            }

            $q1="UPDATE books SET bookpic = '$pic',bookname='$bookname',bookdesc='$bookdesc',authorid='$author_id',categoryid='$categoryname',ISBN='$ISBN',callnum='$callnum',acessionnum='$acessionnum',year='$year',libsection='$libsection',dewey='$dewey',price='$price',quantity='$quantity',status='$status' where bookid=".$id.";";
            if(mysqli_query($db,$q1))
            {
                logger($db, $_SESSION['userid'], '1', 'Updated book with id "'.$id.'"');
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Book updated successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "manage_books.php";
                    });
                </script>
                <?php
            }
        }
        else if(isset($_POST['submit']))
        {
            
            $bookname = mysqli_real_escape_string($db, $_POST['bookname']);
            $bookdesc = mysqli_real_escape_string($db, $_POST['bookdesc']);
            $authorname = mysqli_real_escape_string($db, $_POST['authorname']);
            $categoryname = mysqli_real_escape_string($db, $_POST['categoryname']);
            $ISBN = mysqli_real_escape_string($db, $_POST['ISBN']);
            $callnumm = mysqli_real_escape_string($db, $_POST['callnum']);
            $acessionnum = mysqli_real_escape_string($db, $_POST['acessionnum']);
            $year = mysqli_real_escape_string($db, $_POST['year']);
            $libsection = '';
            $dewey = mysqli_real_escape_string($db, $_POST['dewey']);
            $price = mysqli_real_escape_string($db, $_POST['price']);
            $quantity = mysqli_real_escape_string($db, $_POST['quantity']);
            $status = mysqli_real_escape_string($db, $_POST['status']);

            $authorQuery = mysqli_query($db, "SELECT authorid FROM authors WHERE authorname = '$authorname'");
            if (mysqli_num_rows($authorQuery) > 0) {
                $authorRow = mysqli_fetch_assoc($authorQuery);
                $author_id = $authorRow['authorid'];
            } else {
                mysqli_query($db, "INSERT INTO authors (authorname) VALUES ('$authorname')");
                $author_id = mysqli_insert_id($db);
            }
        
            $q1="UPDATE books SET bookname='$bookname',bookdesc='$bookdesc',authorid='$author_id',categoryid='$categoryname',ISBN='$ISBN',callnum='$callnum',acessionnum='$acessionnum',year='$year',libsection='$libsection',dewey='$dewey',price='$price',quantity='$quantity',status='$status' where bookid=".$id.";";
            if(mysqli_query($db,$q1))
            {
                logger($db, $_SESSION['userid'], '1', 'Updated book with id "'.$id.'"');
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Book updated successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "manage_books.php";
                    });
                </script>
                <?php
            }
        }
		?>
    <!-- <div class="footer">
        <div class="footer-row">
            <div class="footer-left">
                <h1>Opening Hours</h1>
                <p><i class="far fa-clock"></i>Monday to Friday - 9am to 9pm</p>
                <p><i class="far fa-clock"></i>Saturday to Sunday - 8am to 11pm</p>
            </div>
            <div class="footer-right">
                <h1>Get In Touch</h1>
                <p>#30 abc Colony, xyz City IN<i class="fas fa-map-marker-alt"></i></p>
                <p>example@website.com<i class="fas fa-paper-plane"></i></p>
                <p>+8801515637957<i class="fas fa-phone-alt"></i></p>
            </div>
        </div>
        <div class="social-links">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-instagram-square"></i>
            <i class="fab fa-youtube"></i>
            <p>&copy; 2021 Copyright by Nazre Imam Tahmid</p>
        </div>
    </div> -->
</body>
<script>
$(document).ready(function() {
    $('input[name="authorname"]').on('input', function() {
        console.log('searching...')
        let query = $(this).val();

        if (query.length >= 2) {
            $.ajax({
                url: 'fetch_authors.php',
                type: 'GET',
                data: { term: query },
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    let suggestions = '';
                    data.forEach(function(author) {
                        suggestions += `<div class="suggestion">${author}</div>`;
                    });
                    $('#author-suggestions').html(suggestions).show();
                }
            });
        } else {
            $('#author-suggestions').hide();
        }
    });

    $(document).on('click', '.suggestion', function() {
        $('input[name="authorname"]').val($(this).text());
        $('#author-suggestions').hide();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#author-suggestions').length) {
            $('#author-suggestions').hide();
        }
    });
});
</script>
</html>