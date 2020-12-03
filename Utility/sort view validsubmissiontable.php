<?php
/*########################################
for displaying data
########################################*/

//Essential data for DB Login (mysql)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "submissiondb";

//create connection with target Database
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//loop through all grades 
for($x = 0; $x <= 7; $x++){
//define different grades 
$Stufe = array("5", "6", "7", "8", "9", "EF", "Q1", "Q2");

//defind different table names in DB for output (!please create it with table.php first!)
$klasse = array("klasse5", "klasse6", "klasse7", "klasse8", "klasse9", "klasse10", "klasse11", "klasse12");

echo "############## Stufe ".$Stufe[$x]."##############<br><br>";
$sql = "SELECT * FROM validsubmissiontable WHERE Stufe = '$Stufe[$x]' ORDER BY `validsubmissiontable`.`Klasse` ASC, `vornameZiel` ASC";
$result = $conn->query($sql);
$relklasse = $klasse[$x];
if ($result->num_rows > 0) {
  // output each row data  
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Empfänger: " . $row["vornameZiel"]. " " . $row["nachnameZiel"]. " - Sender: " . $row["vornameSender"]. " " . $row["nachnameSender"]. " - Stufe: " . $row["Stufe"]. " - Klasse: " . $row["Klasse"]."<br>";
  }
} else {
  echo "0 results";
}
}
$conn->close();
