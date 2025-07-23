<?php
include __DIR__ . "/includes/connection.php";
include "student_navbar.php";
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
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="testimonial">
        <div class="small-container">
            <!-- Scanner Section -->
            <div class="scanner" id="scanner">
                <h3>Scan QR Code</h3>
                <button onclick="scanQRCode()">Start Scanner</button>
                <video id="preview" style="width: 300px; height: 200px; margin-bottom: 25px;"></video>
            </div>

            <!-- Book Info Section -->
            <div class="form form-book bookinfo" id="bookinfo" style="display: none;">
                <div class="form-container edit-form-container edit-book-container">
                    <div class="form-btn">
                        <span style="width: 100%;">Book Info</span>
                        <hr id="indicator" class="add-author">
                    </div>
                    <div class="label book-img">
                        <img id="bookImage" width="50px" height="50px" src="" alt="Book Image" style="margin-left:20px;">
                    </div>
                    <div class="label">
                        <label for="bookid">Book ID:</label>
                        <b id="bookId"></b><br>
                    </div>
                    <div class="label">
                        <label for="bookname">Title:</label>
                        <b id="bookName"></b><br>
                    </div>
                    <div class="label">
                        <label for="bookdesc">Description:</label>
                        <b id="bookDesc"></b><br>
                    </div>
                    <div class="label">
                        <label for="categoryname">Category:</label>
                        <b id="categoryName"></b><br>
                    </div>
                    <div class="label">
                        <label for="authorname">Author Name:</label>
                        <b id="authorName"></b><br>
                    </div>
                    <div class="label">
                        <label for="ISBN">ISBN:</label>
                        <b id="ISBN"></b><br>
                    </div>
                    <div class="label">
                        <label for="callnum">Call Number:</label>
                        <b id="callNum"></b><br>
                    </div>
                    <div class="label">
                        <label for="acessnum">Acession Number:</label>
                        <b id="acessNum"></b><br>
                    </div>
                    <div class="label">
                        <label for="year">Year:</label>
                        <b id="year"></b><br>
                    </div>
                    <div class="label">
                        <label for="libsection">Library Section:</label>
                        <b id="libSection"></b><br>
                    </div>
                    <div class="label">
                        <label for="status">Status:</label>
                        <b id="status"></b><br>
                    </div>
                    <button class="btn" onclick="retryScan()" style="margin-top:30px;">Retry QR Scan</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer" style="position:absolute; bottom:0px; width:100%;">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
<script>
    function scanQRCode() {
        // Open camera and scan QR code
        const scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
            // Send scanned data to the server via AJAX
            fetch('process_qr.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'scanned_data=' + encodeURIComponent(content),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success) {
                    // Populate form fields with fetched book data
                    document.getElementById('bookId').textContent = data.book.bookid;
                    document.getElementById('bookName').textContent = data.book.bookname;
                    document.getElementById('bookDesc').textContent = data.book.bookdesc;
                    document.getElementById('categoryName').textContent = data.book.categoryname;
                    document.getElementById('authorName').textContent = data.book.authorname;
                    document.getElementById('ISBN').textContent = data.book.ISBN;
                    document.getElementById('callNum').textContent = data.book.callnum;
                    document.getElementById('acessNum').textContent = data.book.acessionnum;
                    document.getElementById('year').textContent = data.book.year;
                    document.getElementById('libSection').textContent = data.book.libsection;
                    document.getElementById('status').textContent = data.book.status;
                    document.getElementById('bookImage').src = 'images/' + data.book.bookpic;

                    // Hide scanner and show book info
                    document.getElementById('scanner').style.display = 'none';
                    document.getElementById('bookinfo').style.display = 'block';
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Book not found.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            })
            .catch(error => console.error('Error:', error));
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    }

    function retryScan() {
        // Hide book info and show scanner
        document.getElementById('bookinfo').style.display = 'none';
        document.getElementById('scanner').style.display = 'flex';
    }
</script>
</html>
