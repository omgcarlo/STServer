<?php
	$conn = mysqli_connect("localhost","root","chienihgwapo61296","socialtutor");
	$sql = "SELECT * FROM program";
	$result = mysqli_query($conn,$sql);
?>
<html>
	<head></head>
	<body>
		<form action="save.php" method="POST">
			SchoolId: <input type="text" name="schoolId"><br>
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
			Full Name: <input type="text" name="fullname"><br>
			Birthdate: <input type="text" name="birthdate" placeholder="YY-MM-DD"><br>
			Email: <input type="email" name="email"><br>
			<select name="program">
				<?php
					while($row = mysqli_fetch_array($result)){?>
					<option value ="<?php echo $row['programId'];?>"><?php echo $row['name'];?></option>
					<?php }?>
			</select><br>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>