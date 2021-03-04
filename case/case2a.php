<html>
<head>
<title> PHP SQL Example </title>

<h3> Case 2a: Dropdown List - Automatic Generation </font> </h3>

<h3> You want to search the projects associated with which employee? </h3>

<form action="" method="post">

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

	// Prepare SQL query
	$query = "SELECT EmployeeNumber, FirstName, LastName FROM Employee";

	// Execute SQL query
	$result = $conn->query($query)
		or die( "ERROR: Query is wrong");


	echo "<select name=\"employeeID\">";
	// fetch table records
	while( $row = $result->fetch_assoc() ) {
		// EmployeeNumber
		$id = $row['EmployeeNumber'];
		// concatenate FirstName and LastName
		$name = $row['FirstName'].$row['LastName'];
		// concatenate $id and $name
		$employee = $id." ".$name;
		echo "<option value=\"$id\"> $employee </option>";
	}
	echo "</select>";

	// close the connection with database
	$conn->close();
?>

<input type="submit" value="Submit"/>

<?php
	$conn = new mysqli($server, $sqlUsername, $sqlPassword,$databaseName);

	// check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}


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
		echo "</tr>";

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
</form>
</html>
