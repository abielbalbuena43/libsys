<?php
session_start();
include __DIR__ . '/includes/connection.php'; // Corrected path to connection.php
include __DIR__ . '/includes/admin_navbar.php';
include __DIR__ . '/logger.php';
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

$res=mysqli_query($db,"SELECT * FROM category ORDER BY categoryname");
$res1=mysqli_query($db,"SELECT * FROM authors ORDER BY authorname");
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="edit-profile-container" style="min-height:85vh;">
        <div class="form">
            <div class="form-container edit-form-container add-book-form" >
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Add Book</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="bookform" method="post" enctype='multipart/form-data'>
                    <div class="form-group compact-form-group">
                        <label for="addMethod" class="addMethod">Choose how to add books:</label><br>
                        <input type="radio" name="add_method" id="manual_entry" value="manual" checked>
                        <label for="manual_entry" class="compact-label">Add Manually</label>
                        <input type="radio" name="add_method" id="upload_excel" value="excel">
                        <label for="upload_excel" class="compact-label">Upload via Excel/CSV</label>
                    </div>


                    <div id="manualForm">
                        <!-- Existing form inputs for adding a book manually -->
                        <input type="text" placeholder="Book Title" name="bookname" required>
                        <input type="text" placeholder="Book Description" name="bookdesc" required>
                        <div style="position: relative;">
                            <input type="text" placeholder="Book Author" name="author" required>
                            <div id="author-suggestions" style="position: absolute; background: #fff; border: 1px solid #ccc; display: none; z-index: 1000;"></div>
                        </div>
                        <select class="form-control" name="category" required>
                            <option value="">Select Category</option>
                            <?php while($row=mysqli_fetch_array($res)): ?>
                                <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                            <?php endwhile; ?>
                        </select><br>
                        <input type="text" placeholder="ISBN" name="ISBN" required>
                        <input type="text" placeholder="Call Number" name="callnum" required>
                        <input type="text" placeholder="Acession Number" name="acessionnum" required>
                        <input type="text" placeholder="Publication Year" name="year" required>
                        <!-- <input type="text" placeholder="Library Section" name="section" required> -->
                        <input type="text" placeholder="Dewey Classification" name="dewey" required>
                        <input type="text" placeholder="Quantity" name="quantity" required>
                        <div class="label">
                            <label for="pic">Upload picture of the book:</label>
                        </div>
                        <input type="file" name="file" class="file" required>
                        <button type="submit" class="btn" name="submit">Add Manually</button>
                    </div>

                    <div id="excelForm" style="display: none;">
                        <!-- Input for Excel/CSV file upload -->
                        <div class="label">
                            <label for="file">Upload Book Excel/CSV File:</label>
                        </div>
                        <input type="file" name="book_excel" class="file" accept=".xlsx, .xls, .csv" />
                        <button type="submit" class="btn" name="submit_excel">Upload via Excel/CSV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        if (isset($_POST['submit'])) {
            // Handle manual form submission
            move_uploaded_file($_FILES['file']['tmp_name'], "images/" . $_FILES['file']['name']);
            $pic = $_FILES['file']['name'];
            $authorname = mysqli_real_escape_string($db, $_POST['author']);
            $authorQuery = mysqli_query($db, "SELECT authorid FROM authors WHERE authorname = '$authorname'");
            if (mysqli_num_rows($authorQuery) > 0) {
                $authorRow = mysqli_fetch_assoc($authorQuery);
                $author_id = $authorRow['authorid'];
            } else {
                mysqli_query($db, "INSERT INTO authors (authorname) VALUES ('$authorname')");
                $author_id = mysqli_insert_id($db);
            }
        
            mysqli_query($db, "INSERT INTO books VALUES(
                '', '$pic', '$_POST[bookname]', '$_POST[bookdesc]', '$author_id', '$_POST[category]', 
                '$_POST[ISBN]', '$_POST[callnum]', '$_POST[acessionnum]', '$_POST[year]', '', 
                '$_POST[dewey]', 0, '$_POST[quantity]', 'Available')");
            echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Book added successfully.",
                    icon: "success",
                    button: "OK",
                });
            </script>';
        }
    
        if (isset($_POST['submit_excel'])) {
            $file = $_FILES['book_excel']['tmp_name'];
            if ($file) {
                $fileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);
                $spreadsheet = $reader->load($file);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                
                $sheet = $spreadsheet->getActiveSheet();
                $imageCount = 0;
                $imageData = [];  
        
                foreach ($sheet->getDrawingCollection() as $drawing) {
                    if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\Drawing) {
                        ob_start();
                        call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                        $imageContents = ob_get_contents();
                        ob_end_clean();
                        
                        $extension = 'png'; 
                        switch ($drawing->getMimeType()) {
                            case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_PNG:
                                $extension = 'png';
                                break;
                            case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_GIF:
                                $extension = 'gif';
                                break;
                            case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_JPEG:
                                $extension = 'jpg';
                                break;
                        }
        
                        $imageName = 'book_img_' . $imageCount . '.' . $extension;
        
                        if (!is_dir('images')) {
                            mkdir('images', 0755, true);
                        }
        
                        if (file_put_contents('images/' . $imageName, $imageContents) !== false) {
                            $imageData[] = $imageName; 
                        }
                        $imageCount++;
                    }
                }
        
                for ($i = 1; $i < count($sheetData); $i++) { 
                    $row = $sheetData[$i];
                    $title = mysqli_real_escape_string($db, $row[0]);
                    $description = mysqli_real_escape_string($db, $row[1]);
                    $authorname = mysqli_real_escape_string($db, $row[2]);
                    $category = mysqli_real_escape_string($db, $row[3]);
                    $isbn = mysqli_real_escape_string($db, $row[4]);
                    $callnum = mysqli_real_escape_string($db, $row[5]);
                    $acensionnum = mysqli_real_escape_string($db, $row[6]);
                    $year = mysqli_real_escape_string($db, $row[7]);
                    $section = '';
                    $dewey = mysqli_real_escape_string($db, $row[9]);
                    $quantity = mysqli_real_escape_string($db, $row[10]);
        
                    $bookimg = isset($imageData[$imageCount - 1]) ? mysqli_real_escape_string($db, $imageData[$imageCount - 1]) : '';
        
                    $authorQuery = mysqli_query($db, "SELECT authorid FROM authors WHERE authorname = '$authorname'");
                    if (mysqli_num_rows($authorQuery) > 0) {
                        $authorRow = mysqli_fetch_assoc($authorQuery);
                        $author_id = $authorRow['authorid'];
                    } else {
                        mysqli_query($db, "INSERT INTO authors (authorname) VALUES ('$authorname')");
                        $author_id = mysqli_insert_id($db);
                    }
        
                    $categoryQuery = mysqli_query($db, "SELECT categoryid FROM category WHERE categoryname = '$category'");
                    if (mysqli_num_rows($categoryQuery) > 0) {
                        $categoryRow = mysqli_fetch_assoc($categoryQuery);
                        $category_id = $categoryRow['categoryid'];
                    } else {
                        mysqli_query($db, "INSERT INTO category (categoryname) VALUES ('$category')");
                        $category_id = mysqli_insert_id($db);
                    }
        
                    mysqli_query($db, "INSERT INTO books 
                        (bookpic, bookname, bookdesc, authorid, categoryid, ISBN, callnum, 
                         acessionnum, year, libsection, dewey, price, quantity, status) 
                         VALUES 
                        ('$bookimg', '$title', '$description', '$author_id', '$category_id', '$isbn', '$callnum', 
                         '$acensionnum', '$year', '$section', '$dewey', 0, '$quantity', 'Available')");
                }
                echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "Books added successfully via Excel/CSV with images.",
                        icon: "success",
                        button: "OK",
                    });
                </script>';
            } else {
                echo '<script>
                    Swal.fire({
                        title: "Invalid File!",
                        text: "Please upload a valid Excel or CSV file.",
                        icon: "error",
                        button: "OK",
                    });
                </script>';
            }
        }
        
          
	?>
    <div class="footer">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
<script>
document.getElementById('manual_entry').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('manualForm').style.display = 'block';
        document.getElementById('excelForm').style.display = 'none';
        
        let manualInputs = document.querySelectorAll('#manualForm input, #manualForm select');
        manualInputs.forEach(input => input.required = true);

        let excelInputs = document.querySelectorAll('#excelForm input');
        excelInputs.forEach(input => input.required = false);
    }
});

document.getElementById('upload_excel').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('manualForm').style.display = 'none';
        document.getElementById('excelForm').style.display = 'block';

        let manualInputs = document.querySelectorAll('#manualForm input, #manualForm select');
        manualInputs.forEach(input => input.required = false);

        let excelInputs = document.querySelectorAll('#excelForm input');
        excelInputs.forEach(input => input.required = true);
    }
});

$(document).ready(function() {
    $('input[name="author"]').on('input', function() {
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
        $('input[name="author"]').val($(this).text());
        $('#author-suggestions').hide();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#author-suggestions').length) {
            $('#author-suggestions').hide();
        }
    });
});
</script>

</script>
</html>