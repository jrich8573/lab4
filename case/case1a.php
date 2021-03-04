<html>
<head>
<title> PHP SQL Example </title>

<h3> Case 1a: Submit buttons - Automatic Coding </h3>
<h3> You want to browse the employees in which department? </h3>
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
		$query = "SELECT DISTINCT Department FROM Employee";

		// Execute SQL query
		$result = $conn->query($query)
			or die( "ERROR: Query is wrong");

		// fetch table records
		while( $row = $result->fetch_assoc() ) {
			// trim() is to get rid of the spaces at the beginning and the end of the string.
			$departmentName = trim($row['Department']);
			echo "<input type=\"submit\" value=\"$departmentName\" name=\"departmentName\"/> <br>";
		}

		// close the connection with database
		$conn->close();
	?>
</form>

<?php
	$conn = new mysqli($server, $sqlUsername, $sqlPassword,$databaseName);
	// check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully<br>";

	if (!empty($_POST['departmentName'])) {

		// get the department name
		$departmentName = $_POST['departmentName'];

		// prepare SQL query
		$query = "SELECT * FROM Employee WHERE Employee.Department='$departmentName'";

		// print the query
		echo "Query: ".$query."<br>";

		// Execute SQL query
		$result = $conn->query($query)
			or die( "ERROR: Query is wrong");

		// Display results in a table
		echo "<table border=1>";
		echo "<tr>";

		// fetch attribute names
		while ($fieldMetadata = $result->fetch_field() ) {
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
</html>
