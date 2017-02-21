<?php 

namespace Gisue\System;

class Model extends Framework
{
	function __construct($app)
	{
    	parent::__construct($app);
		$this->className = 'model';
	}
	
	public function getName()
	{
		$nameArr = explode("\\", get_class($this));
		$namelast = $nameArr[count($nameArr)-1];
		return str_replace("Model", "", $namelast);
	}
	
	public function operation()
	{
		// sql to create table
		$sql = "CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";
		
		if ($conn->query($sql) === TRUE) {
			echo "Table MyGuests created successfully";
		} else {
			echo "Error creating table: " . $conn->error;
		}
		
		$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com')";
		
		if ($conn->query($sql) === TRUE) {
			$last_id = $conn->insert_id;
			echo "New record created successfully. Last inserted ID is: " . $last_id;
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		
		$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com');";
		$sql .= "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Mary', 'Moe', 'mary@example.com');";
		$sql .= "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Julie', 'Dooley', 'julie@example.com')";
		
		if ($conn->multi_query($sql) === TRUE) {
			echo "New records created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		
		$stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $firstname, $lastname, $email);
		
		// set parameters and execute
		$firstname = "John";
		$lastname = "Doe";
		$email = "john@example.com";
		$stmt->execute();
		
		$firstname = "Mary";
		$lastname = "Moe";
		$email = "mary@example.com";
		$stmt->execute();
		
		$firstname = "Julie";
		$lastname = "Dooley";
		$email = "julie@example.com";
		$stmt->execute();
		
		echo "New records created successfully";
		
		$stmt->close();
		
		
		$sql = "SELECT id, firstname, lastname FROM MyGuests";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
			}
		} else {
			echo "0 results";
		}
		
		
		// sql to delete a record
		$sql = "DELETE FROM MyGuests WHERE id=3";
		
		if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: " . $conn->error;
		}
		
		
		$sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
		
		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();

		
		$sqlInsert = 'INSERT INTO `test` (`name`, `job`) 
		VALUES (:name1,:job1),
		       (:name2,:job3), 
		       (:name3,:job3);';
		$preparedStatement = $conn->prepare($sqlInsert);
		$preparedStatement->execute(array(':name1' => 'Tony', ':job1' => 'gardner', ':name2' => 'Dony', ':job2' => 'carpenter', ':name3' => 'Carl', ':job3' => 'policeman'));
		
		//selecting some data
		$sqlSelect = "SELECT * from `test`";
		$data = $conn->query($sqlSelect);
		echo '<div style="' . $divStyle . '">
		        <b>These are the INSERT results:</b><br /><br />';
		foreach ($data as $row) {
		    print "<b>ID:</b> <u>" . $row['id'] . "</u>\t";
		    print "<b>NAME:</b> <u>" . $row['name'] . "</u>\t";
		    print "<b>JOB:</b> <u>" . $row['job'] . "</u><br />";
		}
		echo '</div>';
		
		
		#UPDATE DATA
		//updating some some data
		$sqlInsert = 'UPDATE test set name=:name where id=:id';
		$preparedStatement = $conn->prepare($sqlInsert);
		$preparedStatement->execute(array(':name' => 'MICHAEL', ':id' => 1));
		
		//selecting some data
		$sqlSelect = "SELECT * from `test`";
		$data = $conn->query($sqlSelect);
		echo '<div style="' . $divStyle . '">
		        <b>These are the UPDATE results:</b><br /><br />';
		foreach ($data as $row) {
		    print "<b>ID:</b> <u>" . $row['id'] . "</u>\t";
		    print "<b>NAME:</b> <u>" . $row['name'] . "</u>\t";
		    print "<b>JOB:</b> <u>" . $row['job'] . "</u><br />";
		}
		echo '</div>';
		
		#DELETE DATA
		//delete some some data
		$sqlInsert = 'DELETE from test where id=:id';
		$preparedStatement = $conn->prepare($sqlInsert);
		$preparedStatement->execute(array(':id' => 1));
		
		//selecting some data
		$sqlSelect = "SELECT * from `test`";
		$data = $conn->query($sqlSelect);
		echo '<div style="' . $divStyle . '">
		        <b>These are the DELETE results:</b><br /><br />';
		foreach ($data as $row) {
		    print "<b>ID:</b> <u>" . $row['id'] . "</u>\t";
		    print "<b>NAME:</b> <u>" . $row['name'] . "</u>\t";
		    print "<b>JOB:</b> <u>" . $row['job'] . "</u><br />";
		}
	}
}