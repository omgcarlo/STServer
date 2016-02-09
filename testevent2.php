<?php
    //echo $_GET['date'];
	if(isset($_GET['date'])){
		$datedata = $_GET['date'];?>
		<form method = "POST" action ="events.php?action=new	" >
		<table>
			<tr>
				<td align="right">Event Date:</td>
				<td><input type = "text" name = "edate" value = "<?=$datedata?>"/></td>
			</tr>
			<tr>
				<td align="right">Event Title:</td>
				<td><input type = "text" name = "etitle"/></td>
			</tr>
			<tr>
				<td align="right">Event Description:</td>
				<td><input type = "text" name = "edescription"/></td>
			</tr>
		</table>
		<input type = "text" name = "ownerId" value = "121-122"/>
		<button type = "submit">Submit Bai</button>
		</form>
<?php
	}
?>