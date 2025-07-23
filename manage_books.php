<?php

 include __DIR__ . '/includes/connection.php'; // Corrected path to connection.php
 include __DIR__ . '/includes/admin_navbar.php';

 require 'vendor/autoload.php';


 use chillerlan\QRCode\{QRCode, QROptions};
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
    <div class="search-bar admin-search">
        <form action="" method='post'>
            <select name="category" class="select-category">
                <option value="">Select Category</option>
                <?php 
                $res2 = mysqli_query($db, "SELECT * FROM category ORDER BY categoryname");
                while($row = mysqli_fetch_assoc($res2)):;?>
                    <option value="<?php echo htmlspecialchars($row['categoryid']);?>" <?php echo isset($_POST['category']) && $_POST['category'] == $row['categoryid'] ? 'selected' : ''  ?>><?php echo htmlspecialchars($row['categoryname']);?></option>
                <?php endwhile;?>
            </select>
            <input type="search" name='search' placeholder='Search by Book Name'>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container book-container" id="printTable">
            <div class="student-table-header">
                <h2 class="request-title student-info-title">List of Books</h2>
                <div>
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" style="width:7vw;">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" style="width:7vw;">
                    <button class="btn btn-default" onclick="openReport()">Print Report</button>                  
                </div>
            </div>
            <?php

		if(isset($_POST['submit']))
		{
        $search = isset($_POST['search']) ? mysqli_real_escape_string($db, $_POST['search']) : '';
        $category = isset($_POST['category']) && $_POST['category'] !== '' ? intval($_POST['category']) : null;
            
		$query = "SELECT books.bookpic, books.bookid, books.bookname, authors.authorname, category.categoryname, books.ISBN, books.price, quantity, status 
          FROM books 
          JOIN authors ON authors.authorid = books.authorid 
          JOIN category ON category.categoryid = books.categoryid 
          WHERE bookname LIKE '%$search%'";

        if ($category !== null) {
            $query .= " AND books.categoryid = $category";
        }

        $q = mysqli_query($db, $query);
			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! No Books found. Try searching again";

			}
			else
			{
				echo "<table class='rtable booktable'>";
                echo "<tr style='background-color: #1aa7ec;'>";
                //Table header
                echo "<th>"; echo "Books"; echo "</th>";
                echo "<th>"; echo "Author Name"; echo "</th>";
                echo "<th>"; echo "Category Name"; echo "</th>";
                echo "<th>"; echo "ISBN"; echo "</th>";
                echo "<th>"; echo "Quantity"; echo "</th>";
                echo "<th>"; echo "Status"; echo "</th>";
                echo "<th>"; echo "Qr Code"; echo "</th>";
                echo "<th class='action-column'>"; echo "Action"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($q))
                {
                    $data = $row['bookid'];
                    $qrcode = (new QRCode)->render($data);
                    echo "<tr>";
                    // echo "<td>"; echo $row['studentid']; echo "</td>";
                    // echo "<td>"; echo $row['FullName']; echo "</td>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['bookpic']."'>
                        <div>
                            <p>Book ID: ";echo $row['bookid'];echo"</p>
                            <p>";echo $row['bookname'];echo"</p>";?>
                            <a href="?req=<?php echo $row['bookid'];?>"><button type='submit' name='remove'>Add as a Trending Book</button></a>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['categoryname']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    echo "<td>"; echo $row['quantity']; echo "</td>";
                    echo "<td>"; echo $row['status']; echo "</td>";
                    echo '<td> <img src="' . (new QRCode)->render($data) . '" alt="QR Code"></td>';
                    echo "<td class='action-column'>";?><a href="edit_book.php?ed=<?php echo $row['bookid'];?>"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn"><i class="fas fa-edit"></i> Edit
			        </button>
                    </a>
                    <button onclick="confirmDelete(<?php echo $row['bookid']; ?>)" style="font-weight:bold;" type="submit" name="submit1" class="delbtn" ><i class="fas fa-trash-alt"></i> Delete</button>
			        <?php 
			        echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$res=mysqli_query($db,"SELECT books.bookpic,books.bookid,books.bookname,authors.authorname,category.categoryname,books.ISBN,books.price,quantity,status from  `books`join `authors` on authors.authorid=books.authorid left join `category` on category.categoryid=books.categoryid ;");
            echo "<table class='rtable booktable'>";
            echo "<tr style='background-color: #1aa7ec;'>";
            //Table header
            echo "<th>"; echo "Books"; echo "</th>";
            echo "<th>"; echo "Author Name"; echo "</th>";
            echo "<th>"; echo "Category Name"; echo "</th>";
            echo "<th>"; echo "ISBN"; echo "</th>";
            echo "<th>"; echo "Quantity"; echo "</th>";
            echo "<th>"; echo "Status"; echo "</th>";
            echo "<th>"; echo "Qr Code"; echo "</th>";
            echo "<th class='action-column'>"; echo "Action"; echo "</th>";
            echo "</tr>";

            while($row=mysqli_fetch_assoc($res))
            {
                $data = $row['bookid'];
                $qrcode = (new QRCode)->render($data);
                echo "<tr>";
                    // echo "<td>"; echo $row['studentid']; echo "</td>";
                    // echo "<td>"; echo $row['FullName']; echo "</td>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['bookpic']."'>
                        <div>
                            <p>Book ID: ";echo $row['bookid'];echo"</p>
                            <p>";echo $row['bookname'];echo"</p>";?>
                            <a href="?req=<?php echo $row['bookid'];?>"><button type='submit' name='remove'>Add as a Trending Book</button></a>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>" .$row['authorname']. "</td>";
                    echo "<td>" .$row['categoryname']. "</td>";
                    echo "<td>" .$row['ISBN']. "</td>";
                    echo "<td>" .$row['quantity']. "</td>";
                    echo "<td>" .$row['status']. "</td>";
                    echo '<td> <img src="' . (new QRCode)->render($data) . '" alt="QR Code"></td>';
                    echo "<td class='action-column'>";?><a href="edit_book.php?ed=<?php echo $row['bookid'];?>"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn"><i class="fas fa-edit"></i> Edit
			        </button>
                    </a>
                    <button onclick="confirmDelete(<?php echo $row['bookid']; ?>)" style="font-weight:bold;" type="submit" name="submit1" class="delbtn" ><i class="fas fa-trash-alt"></i> Delete</button>
			        <?php 
			        echo "</td>";
                    echo "</tr>";
            }
            echo "</table>";

            }
        ?> 
        </div>
    </div>
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>

    <?php
    if(isset($_GET['req']))
	{
		$id=$_GET['req'];
		mysqli_query($db,"INSERT INTO `TRENDINGBOOK` VALUES('$id');");
		?>	
		<script type="text/javascript">
			Swal.fire({
                title: "Success!",
                text: "Successfully added as a trending book.",
                icon: "success",
                confirmButtonText: "OK"
            });
		</script>
		<script type="text/javascript">
			window.location="manage_books.php";
	    </script>
		<?php
	}
	?>
    
</body>
<script>
function confirmDelete(bookid) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'teal',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete_book.php?del=' + bookid;
        }
    })
}

</script>
<script>
    function openReport() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        const url = `book_report.php?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;

        const features = "width=800,height=600,resizable=no,scrollbars=yes,status=yes";

        window.open(url, '_blank', features);
    }
</script>
</html>