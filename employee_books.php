<?php
include __DIR__ . "/includes/connection.php";
include "employee_navbar.php";
    $res=mysqli_query($db,"SELECT * FROM category");
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<?php 
if(!isset($_POST['search']) || $_POST['category'] != "selectcat"){
?>
<div class="trending-books all-books">
        <div class="small-container">
            <h2 class="co-title">Trending Books</h2>
            <div class="row">
            <?php
                $res = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, books.bookdesc, books.callnum, books.acessionnum, books.year, books.libsection, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status FROM `books` JOIN `category` ON category.categoryid = books.categoryid JOIN `authors` ON authors.authorid = books.authorid JOIN trendingbook ON trendingbook.bookid = books.bookid;");
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
                            
                            <div class="overlay"></div>
                            <div class="sub-card">
                                <p><b>Book Name: &nbsp;</b><?php echo htmlspecialchars($row['bookname']); ?></p>  
                                <p><b>Description: &nbsp;</b><?php echo htmlspecialchars($row['bookdesc']); ?></p>  
                                <p><b>Year: &nbsp;</b><?php echo htmlspecialchars($row['year']); ?></p>  
                                <p><b>Category Name: &nbsp;</b><?php echo htmlspecialchars($row['categoryname']); ?></p>
                                <p><b>Author Name: &nbsp;</b><?php echo htmlspecialchars($row['authorname']); ?></p>
                                <!-- <p><b>ISBN: &nbsp;</b><?php echo htmlspecialchars($row['ISBN']); ?></p>
                                <p><b>Call Number: &nbsp;</b><?php echo htmlspecialchars($row['callnum']); ?></p>  
                                <p><b>Acession Number: &nbsp;</b><?php echo htmlspecialchars($row['acessionnum']); ?></p>  
                                <p><b>Library Section: &nbsp;</b><?php echo htmlspecialchars($row['libsection']); ?></p>   -->
                                <p><b>Quantity: &nbsp;</b><?php echo htmlspecialchars($row['quantity']); ?></p>
                                <p><b>Status: &nbsp;</b><span><?php echo htmlspecialchars($row['status']); ?></span> </p> 
                                <?php if($row['status'] == 'Available'): ?>
                                    <a href="requested_book.php?req=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default">Borrow</button></a>
                                <?php else: 
                                        $query = "SELECT duedate FROM issueinfo WHERE bookid = " . $row['bookid'] . " ORDER BY duedate ASC LIMIT 1";
                                        $result = mysqli_query($db, $query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            $nextAvailable = mysqli_fetch_assoc($result)['duedate'];
                                            if($nextAvailable == '0000-00-00'){
                                                echo '<button type="button" class="btn btn-default" disabled>Currently Not Available</button>';
                                            }else{
                                                echo '<button type="button" class="btn btn-default" disabled>Available: ' . date('m/d/Y', strtotime($nextAvailable)) . '</button>';
                                            }
                                        } else {
                                            echo '<button type="button" class="btn btn-default" disabled>Currently Not Available</button>';
                                        }
                                    
                                    ?>
                    
                                <?php endif; ?>
                                <a href="view_book.php?book=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default" style="margin-top:12px;">View Details
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="all-books">
    <div class="search-bar">
        <form action="" method='post'>
            <select name="status" class="select-category">
                <option value="">Select Availability</option>
                <option value="Available" <?php echo isset($_POST['status']) && $_POST['status'] == 'Available' ? 'selected' : ''  ?>>Available</option>
                <option value="Not Available" <?php echo isset($_POST['status']) && $_POST['status'] == 'Not Available' ? 'selected' : ''  ?>>Unavailable</option>
            </select>
            <select name="category" class="select-category">
                <option value="">Select Category</option>
                <?php 
                $res2 = mysqli_query($db, "SELECT * FROM category ORDER BY categoryname");
                while($row = mysqli_fetch_assoc($res2)):;?>
                    <option value="<?php echo htmlspecialchars($row['categoryid']);?>" <?php echo isset($_POST['category']) && $_POST['category'] == $row['categoryid'] ? 'selected' : ''  ?>><?php echo htmlspecialchars($row['categoryname']);?></option>
                <?php endwhile;?>
            </select>
            <input type="search" name='search' placeholder='Search by Book Name / Dewey Classification'>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="small-container">
        <?php
        if(isset($_POST['submit'])) {
            if($_POST['category'] != "" || $_POST['status'] != "") {
                $cat = mysqli_query($db, "SELECT categoryname FROM category WHERE categoryid = " . intval($_POST['category']) . ";");
                $row = mysqli_fetch_assoc($cat);
                if($_POST['category'] != ""):
                ?>
                <h2 class='all-books-title'><?php echo htmlspecialchars($row['categoryname']); ?></h2>
                <?php   
                endif;  
                $search = isset($_POST['search']) ? mysqli_real_escape_string($db, $_POST['search']) : '';
                $category = isset($_POST['category']) && $_POST['category'] !== '' ? intval($_POST['category']) : null;
                $status = isset($_POST['status']) && $_POST['status'] !== '' ? $_POST['status'] : null;
                
                $query = "SELECT books.bookid, books.dewey, books.bookpic, books.bookname, books.bookdesc, books.callnum, books.acessionnum, books.year, books.libsection, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status 
                          FROM books 
                          JOIN category ON category.categoryid = books.categoryid 
                          JOIN authors ON authors.authorid = books.authorid 
                          WHERE (bookname LIKE '%$search%' OR dewey LIKE '%$search%')";
                
                if ($category !== null) {
                    $query .= " AND books.categoryid = $category";
                }

                if ($status !== null) {
                    $query .= " AND status = '".$status."'";
                }
                
                $q = mysqli_query($db, $query);
                
                
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
                                <div class="overlay"></div>
                                <div class="sub-card">
                                    <p><b>Book Name: &nbsp;</b><?php echo htmlspecialchars($row['bookname']); ?></p>  
                                    <p><b>Description: &nbsp;</b><?php echo htmlspecialchars($row['bookdesc']); ?></p>  
                                    <p><b>Year: &nbsp;</b><?php echo htmlspecialchars($row['year']); ?></p>  
                                    <p><b>Category Name: &nbsp;</b><?php echo htmlspecialchars($row['categoryname']); ?></p>
                                    <p><b>Author Name: &nbsp;</b><?php echo htmlspecialchars($row['authorname']); ?></p>
                                    <p><b>Quantity: &nbsp;</b><?php echo htmlspecialchars($row['quantity']); ?></p>
                                    <p><b>Status: &nbsp;</b><span><?php echo htmlspecialchars($row['status']); ?></span> </p> 
                                    <?php if($row['status'] == 'Available'): ?>
                                        <a href="requested_book.php?req=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default">Borrow</button></a>
                                    <?php else: 
                                            $query = "SELECT duedate FROM issueinfo WHERE bookid = " . $row['bookid'] . " ORDER BY duedate ASC LIMIT 1";
                                            $result = mysqli_query($db, $query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                $nextAvailable = mysqli_fetch_assoc($result)['duedate'];
                                                if($nextAvailable == '0000-00-00'){
                                                    echo '<button type="button" class="btn btn-default" disabled>Currently Not Available</button>';
                                                }else{
                                                    echo '<button type="button" class="btn btn-default" disabled>Available: ' . date('m/d/Y', strtotime($nextAvailable)) . '</button>';
                                                }
                                            } else {
                                                echo '<button type="button" class="btn btn-default" disabled>Currently Not Available</button>';
                                            }
                                        
                                        ?>
                        
                                    <?php endif; ?>                             
                                    <a href="view_book.php?book=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default" style="margin-top:12px;">View Details</button></a>
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
                $q = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, books.bookdesc, books.callnum, books.acessionnum, books.year, books.libsection, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status 
                                        FROM books 
                                        JOIN category ON category.categoryid = books.categoryid 
                                        JOIN authors ON authors.authorid = books.authorid 
                                        WHERE bookname LIKE '%" . mysqli_real_escape_string($db, $_POST['search']) . "%'
                                        OR dewey LIKE '%" . mysqli_real_escape_string($db, $_POST['search']) . "%'
                                        ORDER BY bookname;");
                
                if(mysqli_num_rows($q) == 0) {
                    echo "Sorry! No Books found. Try searching again.";
                } else {
                    ?>
                    <div class="alphabet-navigation">
                        <?php 
                        foreach (range('A', 'Z') as $letter) {
                            echo "<a href='#" . $letter . "'>" . $letter . "</a> ";
                        }
                        ?>
                    </div>

                    <?php
                    $currentLetter = '';
                    while ($row = mysqli_fetch_assoc($q)) {
                        $firstLetter = strtoupper($row['bookname'][0]); // Get the first letter of the book name

                        if ($currentLetter !== $firstLetter) {
                            if ($currentLetter !== '') {
                                // Close the previous row
                                echo "</div></div>";
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
                                <div class="overlay"></div>
                                <div class="sub-card">
                                    <p><b>Book Name: &nbsp;</b><?php echo htmlspecialchars($row['bookname']); ?></p>  
                                    <p><b>Description: &nbsp;</b><?php echo htmlspecialchars($row['bookdesc']); ?></p>  
                                    <p><b>Year: &nbsp;</b><?php echo htmlspecialchars($row['year']); ?></p>  
                                    <p><b>Category Name: &nbsp;</b><?php echo htmlspecialchars($row['categoryname']); ?></p>
                                    <p><b>Author Name: &nbsp;</b><?php echo htmlspecialchars($row['authorname']); ?></p>
                                    <p><b>Quantity: &nbsp;</b><?php echo htmlspecialchars($row['quantity']); ?></p>
                                    <p><b>Status: &nbsp;</b><span><?php echo htmlspecialchars($row['status']); ?></span> </p> 
                                    <?php if($row['status'] == 'Available'): ?>
                                        <a href="requested_book.php?req=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default">Borrow</button></a>
                                    <?php else: 
                                            $query = "SELECT duedate FROM issueinfo WHERE bookid = " . $row['bookid'] . " ORDER BY duedate ASC LIMIT 1";
                                            $result = mysqli_query($db, $query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                $nextAvailable = mysqli_fetch_assoc($result)['duedate'];
                                                if($nextAvailable == '0000-00-00'){
                                                    echo '<button type="button" class="btn btn-default" disabled>Currently Not Available</button>';
                                                }else{
                                                    echo '<button type="button" class="btn btn-default" disabled>Available: ' . date('m/d/Y', strtotime($nextAvailable)) . '</button>';
                                                }
                                            } else {
                                                echo '<button type="button" class="btn btn-default" disabled>Currently Not Available</button>';
                                            }
                                        
                                        ?>
                        
                                    <?php endif; ?>
                                    <a href="view_book.php?book=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default" style="margin-top:12px;">View Details</button></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    // Close the last row
                    if ($currentLetter !== '') {
                        echo "</div></div>";
                    }
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
            $res = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, books.bookdesc, books.callnum, books.acessionnum, books.year, books.libsection, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status 
                                      FROM books 
                                      JOIN category ON category.categoryid = books.categoryid 
                                      JOIN authors ON authors.authorid = books.authorid
                                      ORDER BY bookname");

            while($row = mysqli_fetch_assoc($res)) {
                $firstLetter = strtoupper($row['bookname'][0]); 

                if ($currentLetter !== $firstLetter) {
                    if ($currentLetter !== '') {
                        // Close the previous row
                        echo "</div></div>";
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
                        <div class="overlay"></div>
                        <div class="sub-card">
                            <p><b>Book Name: &nbsp;</b><?php echo htmlspecialchars($row['bookname']); ?></p>  
                            <p><b>Description: &nbsp;</b><?php echo htmlspecialchars($row['bookdesc']); ?></p>  
                            <p><b>Year: &nbsp;</b><?php echo htmlspecialchars($row['year']); ?></p>  
                            <p><b>Category Name: &nbsp;</b><?php echo htmlspecialchars($row['categoryname']); ?></p>
                            <p><b>Author Name: &nbsp;</b><?php echo htmlspecialchars($row['authorname']); ?></p>
                            <p><b>Quantity: &nbsp;</b><?php echo htmlspecialchars($row['quantity']); ?></p>
                            <p><b>Status: &nbsp;</b><span><?php echo htmlspecialchars($row['status']); ?></span> </p> 
                            <?php if($row['status'] == 'Available'): ?>
                                <a href="requested_book.php?req=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default">Borrow</button></a>
                            <?php else: 
                                    $query = "SELECT duedate FROM issueinfo WHERE bookid = " . $row['bookid'] . " ORDER BY duedate ASC LIMIT 1";
                                    $result = mysqli_query($db, $query);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $nextAvailable = mysqli_fetch_assoc($result)['duedate'];
                                        if($nextAvailable == '0000-00-00'){
                                            echo '<button type="button" class="btn btn-default" disabled>Currently Not Available</button>';
                                        }else{
                                            echo '<button type="button" class="btn btn-default" disabled>Available: ' . date('m/d/Y', strtotime($nextAvailable)) . '</button>';
                                        }
                                    } else {
                                        echo '<button type="button" class="btn btn-default" disabled>Currently Not Available</button>';
                                    }
                                
                                ?>
                
                            <?php endif; ?>
                            <a href="view_book.php?book=<?php echo $row['bookid'];?>"><button type="submit" name="submit1" class="btn btn-default" style="margin-top:12px;">View Details</button></a>
                        </div>
                    </div>
                </div>
                <?php
            }
            // Close the last row
            if ($currentLetter !== '') {
                echo "</div></div>";
            }
        }
        ?>
    </div>
</div>
<div class="footer" >
    <div class="social-links">
        <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
    </div>
</div>
    
</body>
</html>