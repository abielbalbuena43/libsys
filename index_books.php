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
<div class="trending-books all-books">
        <div class="small-container">
            <h2 class="co-title">Trending Books</h2>
            <div class="row">
            <?php
                $res = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status FROM `books` JOIN `category` ON category.categoryid = books.categoryid JOIN `authors` ON authors.authorid = books.authorid JOIN trendingbook ON trendingbook.bookid = books.bookid;");
                while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <div class="card">
                        <?php
                            echo "<img src='images/".$row['bookpic']."'>";
                        ?>
                        <div class="card-body">
                            <h4 style="font-size: 18px;">
                                <?php
                                    echo $row['bookname'];
                                ?></h4>
                                <p style="font-size: 18px">Price: 
                                <?php
                                    echo $row['price'];
                                ?> ₱</p>
                            
                            <div class="overlay"></div>
                            <div class="sub-card">
                            <p><b>Book Name: &nbsp;</b> 
                            <?php
                                echo $row['bookname'];
                            ?></p>  
                            <p><b>Category Name: &nbsp;</b> 
                            <?php
                                echo $row['categoryname'];
                            ?></p>
                            <p><b>Author Name: &nbsp;</b> 
                            <?php
                                echo $row['authorname'];
                            ?></p>
                            <p><b>ISBN: &nbsp;</b> 
                            <?php
                                echo $row['ISBN'];
                            ?></p>
                            <p><b>Quantity: &nbsp;</b> 
                            <?php
                                echo $row['quantity'];
                            ?></p>
                            <p><b>Price:</b> 
                            <?php
                                echo $row['price'];
                            ?> ₱</p> 
                            <p><b>Status: &nbsp;</b>
                            <span>
                            <?php
                                echo $row['status'];
                            ?></span> </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="all-books">
        <div class="search-bar">
            <form action="" method='post'>
                <select name="category" class="select-category">
                    <option value="selectcat">Select Category</option>
                    <?php while($row = mysqli_fetch_array($res)):;?>
                        <option value="<?php echo htmlspecialchars($row[0]);?>"><?php echo htmlspecialchars($row[1]);?></option>
                    <?php endwhile;?>
                </select>
                <input type="search" name='search' placeholder='Search by Book Name'>
                <button type='submit' name='submit'><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="small-container">
            <?php
            if(isset($_POST['submit'])) {
                if($_POST['category'] != "selectcat") {
                    $cat = mysqli_query($db, "SELECT categoryname FROM category WHERE categoryid = " . intval($_POST['category']) . ";");
                    $row = mysqli_fetch_assoc($cat);
                    ?>
                    <h2 class='all-books-title'><?php echo htmlspecialchars($row['categoryname']); ?></h2>
                    <?php     
                    $q = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status 
                                            FROM books 
                                            JOIN category ON category.categoryid = books.categoryid 
                                            JOIN authors ON authors.authorid = books.authorid 
                                            WHERE bookname LIKE '%" . mysqli_real_escape_string($db, $_POST['search']) . "%' 
                                            AND books.categoryid = " . intval($_POST['category']) . ";");
                    
                    if(mysqli_num_rows($q) == 0) {
                        echo "Sorry! No Books found. Try searching again.";
                    } else {
                        ?>
                        <div class="row">
                        <?php
                        while($row = mysqli_fetch_assoc($q)) {
                            ?>
                            <div class="card">
                                <?php echo "<img src='images/" . htmlspecialchars($row['bookpic']) . "'>"; ?>
                                <div class="card-body">
                                    <h4 style="font-size: 18px;"><?php echo htmlspecialchars($row['bookname']); ?></h4>
                                    <p style="font-size: 18px">Price: <?php echo htmlspecialchars($row['price']); ?> ₱</p>
                                    <div class="overlay"></div>
                                    <div class="sub-card">
                                        <p><b>Book Name: &nbsp;</b><?php echo htmlspecialchars($row['bookname']); ?></p>  
                                        <p><b>Category Name: &nbsp;</b><?php echo htmlspecialchars($row['categoryname']); ?></p>
                                        <p><b>Author Name: &nbsp;</b><?php echo htmlspecialchars($row['authorname']); ?></p>
                                        <p><b>ISBN: &nbsp;</b><?php echo htmlspecialchars($row['ISBN']); ?></p>
                                        <p><b>Quantity: &nbsp;</b><?php echo htmlspecialchars($row['quantity']); ?></p>
                                        <p><b>Price:</b><?php echo htmlspecialchars($row['price']); ?> ₱.</p> 
                                        <p><b>Status: &nbsp;</b><span><?php echo htmlspecialchars($row['status']); ?></span> </p>
                                        <a href="requested_book.php?req=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default" >Request
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        </div>
                        <?php 
                    }  
                } else {
                    ?>
                    <h2 class="all-books-title">All Books</h2>
                    <?php
                    $q = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status 
                                            FROM books 
                                            JOIN category ON category.categoryid = books.categoryid 
                                            JOIN authors ON authors.authorid = books.authorid 
                                            WHERE bookname LIKE '%" . mysqli_real_escape_string($db, $_POST['search']) . "%'
                                            ORDER BY bookname;");
                    
                    if(mysqli_num_rows($q) == 0) {
                        echo "Sorry! No Books found. Try searching again.";
                    } else {
                        ?>
                        <div class="row">
                        <?php
                        while($row = mysqli_fetch_assoc($q)) {
                            ?>
                            <div class="card">
                                <?php echo "<img src='images/" . htmlspecialchars($row['bookpic']) . "'>"; ?>
                                <div class="card-body">
                                    <h4 style="font-size: 18px;"><?php echo htmlspecialchars($row['bookname']); ?></h4>
                                    <p style="font-size: 18px">Price: <?php echo htmlspecialchars($row['price']); ?> ₱</p>
                                    <div class="overlay"></div>
                                    <div class="sub-card">
                                        <p><b>Book Name: &nbsp;</b><?php echo htmlspecialchars($row['bookname']); ?></p>  
                                        <p><b>Category Name: &nbsp;</b><?php echo htmlspecialchars($row['categoryname']); ?></p>
                                        <p><b>Author Name: &nbsp;</b><?php echo htmlspecialchars($row['authorname']); ?></p>
                                        <p><b>ISBN: &nbsp;</b><?php echo htmlspecialchars($row['ISBN']); ?></p>
                                        <p><b>Quantity: &nbsp;</b><?php echo htmlspecialchars($row['quantity']); ?></p>
                                        <p><b>Price:</b><?php echo htmlspecialchars($row['price']); ?> ₱.</p> 
                                        <p><b>Status: &nbsp;</b><span><?php echo htmlspecialchars($row['status']); ?></span> </p>
                                        <a href="requested_book.php?req=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default" >Request
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        </div>
                        <?php 
                    } 
                }
            } else {
                ?>
                <h2 class="all-books-title">All Books</h2>
                <div class="alphabet-navigation">
    <?php 
    foreach (range('A', 'Z') as $letter) {
        echo "<a href='#" . $letter . "'>" . $letter . "</a> ";
    }
    ?>
</div>

<?php
$currentLetter = '';
$res = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status 
                          FROM books 
                          JOIN category ON category.categoryid = books.categoryid 
                          JOIN authors ON authors.authorid = books.authorid
                          ORDER BY bookname;");
while ($row = mysqli_fetch_assoc($res)) {
    $firstLetter = strtoupper($row['bookname'][0]); // Get the first letter of the book name
    
    if ($currentLetter !== $firstLetter) {
        if ($currentLetter !== '') {
            // Close the previous row
            echo "</div>";
        }
        $currentLetter = $firstLetter;
        // Create a new row and section for the current letter
        echo "<div id='" . $currentLetter . "' class='book-section'>";
        echo "<h3>" . $currentLetter . "</h3>";
        echo "<div class='row'>";
    }
    ?>
        <div class="card">
            <?php echo "<img src='images/" . htmlspecialchars($row['bookpic']) . "'>"; ?>
            <div class="card-body">
                <h4 style="font-size: 18px;"><?php echo htmlspecialchars($row['bookname']); ?></h4>
                <p style="font-size: 18px">Price: <?php echo htmlspecialchars($row['price']); ?> ₱</p>
                <div class="overlay"></div>
                <div class="sub-card">
                    <p><b>Book Name: &nbsp;</b><?php echo htmlspecialchars($row['bookname']); ?></p>  
                    <p><b>Category Name: &nbsp;</b><?php echo htmlspecialchars($row['categoryname']); ?></p>
                    <p><b>Author Name: &nbsp;</b><?php echo htmlspecialchars($row['authorname']); ?></p>
                    <p><b>ISBN: &nbsp;</b><?php echo htmlspecialchars($row['ISBN']); ?></p>
                    <p><b>Quantity: &nbsp;</b><?php echo htmlspecialchars($row['quantity']); ?></p>
                    <p><b>Price:</b><?php echo htmlspecialchars($row['price']); ?> ₱</p> 
                    <p><b>Status: &nbsp;</b><span><?php echo htmlspecialchars($row['status']); ?></span></p>
                    <a href="requested_book.php?req=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default" >Request
                        </button>
                    </a>
                </div>
            </div>
        </div>
    <?php
}
// Close the last row
if ($currentLetter !== '') {
    echo "</div></div>";
}
?>
                <?php 
            }
            ?>
        </div>
    </div>
    
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
</html>
