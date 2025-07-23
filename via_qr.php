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
    <title>Library QR Scanner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="scanner" id="scanner" style="height:70vh; flex-direction:column;">
        <h3><?php echo isset($_GET['action']) ? $_GET['action'] : '' ?> via QR Code</h3>
        <button onclick="scanQRCode()">Start Scanner</button>
        <video id="preview" style="width: 300px; height: 200px; margin-bottom: 25px;"></video>
    </div>

    <div class="footer" style="position:absolute; bottom:0px; width:100%;">
        <div class="social-links">
            <p>&copy; 2024 Montemayor • Balbuena • Azores</p>
        </div>
    </div>
</body>
<script>
    function scanQRCode() {
        const scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
            // Send scanned data (bookid) to the server via AJAX
            fetch('process_via_qr.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'bookid=' + encodeURIComponent(content)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success) {
                    alert(data.message);
                    // Redirect based on action (request or return)
                    if (data.action === 'request') {
                        window.location = "request_book.php";
                    } else if (data.action === 'return') {
                        window.location = "student_issue_info.php";
                    }
                } else {
                    alert('Operation failed: ' + data.message);
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
</script>
</html>
