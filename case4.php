<html>
<head>
<title> PHP SQL Example </title>

<h3> Case 4: Dropdown List - Automatic Generation </font> </h3>

<h3> You want to search the employees associated with which project? </h3>

<form action="" method="post">

<?php
	$server = "mysql-class.infra.cs.odu.edu";
	$sqlUsername = "jrich202020";
	$sqlPassword = "";
	$databaseName = "jrich202020db";

	$conn = new mysqli($server, $sqlUsername, $sqlPassword,$databaseName);

	// check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully<br>";

	// Prepare SQL query
	$query = "SELECT ProjectID, ProjectName FROM PROJECT";

	// Execute SQL query
	$result = $conn->query($query)
		or die( "ERROR: Query is wrong");


	echo "<select name=\"projectID\">";
	// fetch table records
	while( $row = $result->fetch_assoc() ) {
		// project ID
		$id = $row['ProjectID'];
		// concatenate FirstName and LastName
		$name = $row['ProjectName'];
		// concatenate $id and $name
		$project = $id." ".$name;
		echo "<option value=\"$id\"> $project </option>";
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


	if (!empty($_POST['projectID'])) {

		// get the employeeID
		$projectID = $_POST['projectID'];

		// prepare SQL query
		$query = "SELECT *
					FROM EMPLOYEE
					WHERE EmployeeNumber IN
					(SELECT EmployeeNumber FROM ASSIGNMENT WHERE ASSIGNMENT.ProjectID = $projectID)";

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
