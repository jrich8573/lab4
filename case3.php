<html>
<head>
<title> PHP SQL Case 3 </title>
<h3> Case 3: Dropdown List of Departments </font></h3>
<h3> You want to browse the employees in which department? </h3>


<form action=" " method="post">

   <?php

	$server = 'mysql-class.infra.cs.odu.edu';
	$sqlUsername = "jrich202020";
	$sqlPassword = $_ENV["MYPW"];
	$databaseName = 'jrich202020db';

	$conn = new mysqli($server, $sqlUsername, $sqlPassword,$databaseName);

	// check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully<br>";
	
	$query = "SELECT DISTINCT Department FROM EMPLOYEE";
	
	$result = $conn->query($query)
			or die( "ERROR: Query is wrong");
	
	echo"<select name=\"departmentName\">";

	while( $row = $result->fetch_assoc() ) {
		$departmentName = $row["Department"];
		echo "<option value=\"$departmentName\"> $departmentName</option>";
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
	echo "Connected successfully<br>";


	if (!empty($_POST['departmentName'])) {

		// get the department name
		$departments = $_POST['departmentName'];

		// prepare SQL query
		$query = "SELECT * FROM EMPLOYEE  WHERE EMPLOYEE.Department='$departments'";

		// print the query
		echo "Query: ".$query."<br>";

		// Execute SQL query
		$result = $conn->query($query)
				or die( "ERROR: Query is wrong");

		echo "<table border=1>";
		echo "<tr>";

		// fetch attribute names
		//while ($fieldMetadata = $result->fetch_field() ) {
		//	echo "<th>".$fieldMetadata->name."</th>";
		//}
		$fieldinfo=$result->fetch_fields();
		foreach ($fieldinfo as $fieldMetadata){
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
