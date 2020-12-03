<?php
/*########################################
create tables to store the data 
########################################*/

//Essential database login data
//****************please change this to the login data of your mysql server ****************//
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "submissionDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

for ($x = 0; $x <= 9; $x++) {
  $table = array("submission","validsubmissiontable","klasse5", "klasse6", "klasse7", "klasse8", "klasse9", "klasse10", "klasse11", "klasse12");
  // sql to create table
  $currenttable = $table[$x];
  $sql = "CREATE TABLE klasse12 (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vornameZiel VARCHAR(30) NOT NULL,
    nachnameZiel VARCHAR(30) NOT NULL,
    vornameSender VARCHAR(30) NOT NULL,
    nachnameSender VARCHAR(30) NOT NULL,
    Stufe VARCHAR(15) NOT NULL,
    Klasse VARCHAR(15),
    email VARCHAR(50),
    nachricht TEXT,
    code VARCHAR(8),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
  if ($conn->query($sql) === TRUE) {
    echo "Table $currenttable created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
}


$conn->close();
