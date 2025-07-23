<?php
	
	include __DIR__ . "/includes/connection.php";
	include "student_navbar.php";
	include __DIR__ . '/logger.php';
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>
<?php
    if(isset($_GET['req']))
	{
		if(isset($_SESSION['login_emp_username'])){
			$var='<p class="expired-pill">EXPIRED</p>';
			$q=mysqli_query($db,"SELECT id from employee where username='$_SESSION[login_emp_username]';");
			$row=mysqli_fetch_assoc($q);
			$studentid="{$row['id']}";
			$id=$_GET['req'];
			$q2=mysqli_query($db,"SELECT * from issueinfo where studentid=$studentid and bookid=$id and (approve=' ' or approve='yes' or approve='$var');");
			$q3=mysqli_query($db,"SELECT * from issueinfo where studentid=$studentid and (approve=' ' or approve='yes' or approve='$var');");
			$total = mysqli_num_rows($q3);
			if($total==2){
				?>
				<script type="text/javascript">
					Swal.fire({
						title: "Warning!",
						text: "You already requested two books. You must return one book first.",
						icon: "warning",
						confirmButtonText: "OK"
					}).then(() => {
						window.location.href = "employee_books.php";
					});
				</script>
				<?php
			}
			else if(mysqli_num_rows($q2)!=0)
			{
				?>
				<script type="text/javascript">
					Swal.fire({
						title: "Warning!",
						text: "You already requested this book. You must return it first.",
						icon: "warning",
						confirmButtonText: "OK"
					}).then(() => {
						window.location.href = "employee_books.php";
					});
				</script>
				<?php
			}
			else
			{
				$q1=mysqli_query($db,"SELECT * FROM books where bookid=$id and  status='Available';");
			if(mysqli_num_rows($q1)!=0)
			{
				mysqli_query($db,"INSERT INTO issueinfo VALUES(NULL, '$studentid','$id','','','','','');");
				mysqli_query($db,"UPDATE books SET quantity=quantity-1 where bookid=$id;");
			$res=mysqli_query($db,"SELECT quantity from books where bookid=$id;");
			while($row=mysqli_fetch_assoc($res))
			{
				if($row['quantity']==0)
				{
					mysqli_query($db,"UPDATE books SET status='Not Available' where bookid=$id;");
				}
			}
				logger($db, $_SESSION['userid'], '0', 'Requested a book with id "'.$id.'"');
				?>
			<script type="text/javascript">
				Swal.fire({
					title: "Success!",
					text: "Book Requested successfully.",
					icon: "success",
					confirmButtonText: "OK"
				}).then(() => {
					window.location.href = "employee_books.php";
				});
			</script>
			<?php
			}
			else
			{
				?>
				<script type="text/javascript">
					Swal.fire({
						title: "Error!",
						text: "This book is not available; you can't request it.",
						icon: "error",
						confirmButtonText: "OK"
					}).then(() => {
						window.location.href = "employee_books.php";
					});
				</script>
				<?php
			}
			}
		}else{
			$var='<p class="expired-pill">EXPIRED</p>';
			$q=mysqli_query($db,"SELECT studentid from student where student_username='$_SESSION[login_student_username]';");
			$row=mysqli_fetch_assoc($q);
			$studentid="{$row['studentid']}";
			$id=$_GET['req'];
			$q2=mysqli_query($db,"SELECT * from issueinfo where studentid=$studentid and bookid=$id and (approve=' ' or approve='yes' or approve='$var');");
			$q3=mysqli_query($db,"SELECT * from issueinfo where studentid=$studentid and (approve=' ' or approve='yes' or approve='$var');");
			$total = mysqli_num_rows($q3);
			if($total==2){
				?>
				<script type="text/javascript">
					Swal.fire({
						title: "Warning!",
						text: "You already requested two books. You must return one book first.",
						icon: "warning",
						confirmButtonText: "OK"
					}).then(() => {
						window.location.href = "student_books.php";
					});
				</script>
				<?php
			}
			else if(mysqli_num_rows($q2)!=0)
			{
				?>
				<script type="text/javascript">
					Swal.fire({
						title: "Warning!",
						text: "You already requested this book. You must return it first.",
						icon: "warning",
						confirmButtonText: "OK"
					}).then(() => {
						window.location.href = "student_books.php";
					});
				</script>
				<?php
			}
			else
			{
				$q1=mysqli_query($db,"SELECT * FROM books where bookid=$id and  status='Available';");
			if(mysqli_num_rows($q1)!=0)
			{
				mysqli_query($db,"INSERT INTO issueinfo VALUES(NULL, '$studentid','$id','','','','','');");
				mysqli_query($db,"UPDATE books SET quantity=quantity-1 where bookid=$id;");
			$res=mysqli_query($db,"SELECT quantity from books where bookid=$id;");
			while($row=mysqli_fetch_assoc($res))
			{
				if($row['quantity']==0)
				{
					mysqli_query($db,"UPDATE books SET status='Not Available' where bookid=$id;");
				}
			}
				logger($db, $_SESSION['userid'], '0', 'Requested a book with id "'.$id.'"');
				?>
			<script type="text/javascript">
				Swal.fire({
					title: "Success!",
					text: "Book Requested successfully.",
					icon: "success",
					confirmButtonText: "OK"
				}).then(() => {
					window.location.href = "student_books.php";
				});
			</script>
			<?php
			}
			else
			{
				?>
				<script type="text/javascript">
					Swal.fire({
						title: "Error!",
						text: "This book is not available; you can't request it.",
						icon: "error",
						confirmButtonText: "OK"
					}).then(() => {
						window.location.href = "student_books.php";
					});
				</script>
				<?php
			}
			}
		}
		
	}

?>
</body>
</html>
