<?php

include __DIR__ . "/includes/connection.php";
include "student_navbar.php";
include __DIR__ . '/logger.php';

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
</head>
<style>
    body {
        margin: 0;
    }

    .book-container {
        display: flex;
        flex-direction: column;
        padding: 16px;
        gap: 24px;
    }

    .img-container{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-container img {
        object-fit: cover;
        height: 400px;
        width: 100%;
        max-width: 300px;
        background-color: blue;
        margin: 0 auto;
    }

    .details-column {
        padding-left: 0;
        width: 100%;
        text-align: center;
    }

    .details-column h1, .details-column h3, .details-column p {
        margin: 8px 0;
    }

    .span-text {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
        margin-top: 12px;
    }

    .badge {
        background: lightgray;
        border-radius: 6px;
        padding: 6px 12px;
    }

    hr {
        border: 1px solid lightgray;
        width: 100%;
    }

    .btn-request {
        border: none;
        margin-bottom: 12px;
        cursor: pointer;
    }

    /* Media Queries for Responsiveness */
    @media (min-width: 768px) {
        .book-container {
            flex-direction: row;
            padding: 32px 64px;
        }

        .cover-column {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .details-column {
            flex: 2;
            padding-left: 24px;
            text-align: left;
        }

        .span-text {
            justify-content: flex-start;
        }
    }
</style>
<body>
<?php
    $res = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, books.bookdesc, books.callnum, books.acessionnum, books.year, books.dewey, books.libsection, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status FROM `books` LEFT JOIN `category` ON category.categoryid = books.categoryid LEFT JOIN `authors` ON authors.authorid = books.authorid LEFT JOIN trendingbook ON trendingbook.bookid = books.bookid WHERE books.bookid = '". $_GET['book'] ."';");
    while ($row = mysqli_fetch_assoc($res)) {
?>
    <div class="book-container">
        <div class="cover-column">
            <div class="img-container">
                <img src="./images/<?php echo $row['bookpic'] ?? '' ?>" alt="Book Cover">
            </div>
        </div>
        <div class="details-column">
            <h1><?php echo $row['bookname'] ?? '' ?></h1>
            <h3><?php echo $row['authorname'] ?? '' ?></h3>
            <div class="span-text">
                <p class="badge"><?php echo $row['categoryname'] ?? '' ?></p>
                <p class="badge"><?php echo $row['year'] ?? '' ?></p>
            </div>
            <p>ISBN: <?php echo $row['ISBN'] ?? '' ?></p>
            <p>Call Number: <?php echo $row['callnum'] ?? '' ?></p>
            <p>Accession Number: <?php echo $row['acessionnum'] ?? '' ?></p>
            <p>Library Section: <?php echo $row['libsection'] ?? '' ?></p>
            <p>Dewey Classification: <?php echo $row['dewey'] ?? '' ?></p>
            <div>
            <div class="span-text">
                <?php if($row['status'] == 'Available'): ?>
                    <p class="badge"><?php echo $row['status'] ?? '' ?></p>
                <?php else: 
                        $query = "SELECT duedate FROM issueinfo WHERE bookid = " . $row['bookid'] . " ORDER BY duedate ASC LIMIT 1";
                        $result = mysqli_query($db, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $nextAvailable = mysqli_fetch_assoc($result)['duedate'];
                            if($nextAvailable == '0000-00-00'){
                                echo '<p class="badge">Currently Not Available</p>';
                            }else{
                                echo '<p class="badge">Available on: ' . date('m/d/Y', strtotime($nextAvailable)) . '</p>';
                            }
                        } else {
                            echo '<p class="badge">Currently Not Available</p>';
                        }
                    
                    ?>
    
                <?php endif; ?>
                <p class="badge">Qty: <?php echo $row['quantity'] ?? '' ?></p>
            </div>
            <a href="requested_book.php?req=<?php echo $row['bookid'];?>">
                <button type="submit" name="submit1" class="btn btn-request" >Borrow</button>
            </a>
            <br><hr><br>
            <h3>Description</h3>
            <p><?php echo $row['bookdesc'] ?? '' ?></p>
        </div>
    </div>
<?php } ?>
</body>
</html>