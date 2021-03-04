<html>
<head>
<title> PHP SQL Example </title>

<h3> Case 2: Dropdown List - Manual Coding </h3>
<h3> You want to search the projects associated with which employee? </h3>

<form action="" method="post">
	<select name="employeeID">
		<option value="12"> 12 Mary Jacobs </option>
		<option value="13"> 13 Rosalie Jackson </option>
		<option value="14"> 14 Richard Bandalone </option>
		<option value="15"> 15 Tom Caruthers </option>
		<option value="16"> 16 Heather Jones </option>
		<option value="17"> 17 Mary Abernathy </option>
		<option value="18"> 18 George Smith </option>
		<option value="19"> 19 Tom Jackson </option>
		<option value="20"> 20 George Jones </option>
		<option value="21"> 21 Ken Numoto </option>
		<option value="22"> 22 James Nestor </option>
		<option value="23"> 23 Rick Brown </option>
	</select>
	<input type="submit" value="Submit"/>
</form>

<?php
	$server = "localhost";
	$sqlUsername = "root";
	$sqlPassword = "yourpass";
	$databaseName = "yourdb";

	$conn = new mysqli($server, $sqlUsername, $sqlPassword,$databaseName);

	// check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully<br>";

	if (!empty($_POST['employeeID'])) {

		// get the employeeID
		$employeeID = $_POST['employeeID'];

		// prepare SQL query
		$query = "SELECT *
					FROM Project
					WHERE ProjectID IN
					(SELECT ProjectID FROM Assignment WHERE Assignment.EmployeeNumber=$employeeID)";

		// print the query
		echo "Query: ".$query."<br>";

		// Execute SQL query
		$result = $conn->query($query)
			or die( "ERROR: Query is wrong");

		// Display results in a table
		echo "<table border=1>";
		echo "<tr>";

		// fetch attribute names
		$fieldinfo=$result->fetch_fields();
		foreach ($fieldinfo as $fieldMetadata) {
			echo "<th>".$fieldMetadata->name."</th>";
		}
		//foreach( sqlsrv_field_metadata($result) as $fieldMetadata)
		//	echo "<th>".$fieldMetadata['Name']."</th>";
		//echo "</tr>";

		// fetch rows in the table
		while( $row = $result->fetch_assoc() ) {
			echo "<tr>\n";
			foreach ($row as $cell) {
				echo "<td> $cell </td>";
			}
			echo "</tr>\n";
		}

		echo "</table>";
	}

	// close the connection with database
	$conn->close();
?>

</html>
