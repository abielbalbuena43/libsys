<?php

include __DIR__ . '/includes/connection.php'; // Corrected path to connection.php
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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$status=$_GET['status'];
		mysqli_query($db,"UPDATE employee SET status = $status where employee_id=$id ;");
		logger($db, $_SESSION['userid'], '1', 'Archived employee with id "'.$id.'"');

		?>	
		<script type="text/javascript">
		<?php if($status == 0){ ?>
			Swal.fire({
				title: "Success!",
				text: "Employee archived successfully.",
				icon: "success",
				confirmButtonText: "OK"
			}).then((result) => {
				if (result.isConfirmed || result.dismiss === Swal.DismissReason.backdrop) {
					window.location.href = 'employee_info.php';
				}
			});
		<?php }else{ ?>
			Swal.fire({
				title: "Success!",
				text: "Employee restored successfully.",
				icon: "success",
				confirmButtonText: "OK"
			}).then((result) => {
				if (result.isConfirmed || result.dismiss === Swal.DismissReason.backdrop) {
					window.location.href = 'employee_info.php';
				}
			});
		<?php } ?>
			
		</script>
		
		<?php

	}
	?>
    
    
</body>
</html>