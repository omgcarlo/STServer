<?php
$conn = mysqli_connect("localhost","root","chienihgwapo61296","socialtutor");
	$schoolId = $_POST['schoolId'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$fullname = $_POST['fullname'];
		$birthdate = $_POST['birthdate'];
		$email = $_POST['email'];
		$programId = $_POST['program'];

		
		mysqli_query($conn,"INSERT INTO user(schoolId,username,password,fullname,birthdate,email,programId) VALUES('$schoolId','$username','$password','$fullname','$birthdate','$email',$programId)");
		?>
		/*

		INSERT INTO college(CollegeCode,name,dean,created_date) VALUES('String','String','String','2012-02-23')
		INSERT INTO department(CollegeCode,DepartmentName) VALUES('CEA','Architecture')
		INSERT INTO user(schoolId,username,password,fullname,birthdate,email,programId) VALUES('$schoolId','$username','$password','$fullname','$birthdate','$email',$programId)

		*/