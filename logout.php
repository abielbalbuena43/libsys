<?php
	
	session_start();
	if(isset($_SESSION['login_student_username']))
	{
		unset($_SESSION['login_student_username']);
		
	}
	
	else if(isset($_SESSION['login_admin_username']))
	{
		unset($_SESSION['login_admin_username']);
	}
	
	else if(isset($_SESSION['login_emp_username']))
	{
		unset($_SESSION['login_emp_username']);
	}
	
	session_unset();
	session_destroy();
	
	header("location:index.php");

?>