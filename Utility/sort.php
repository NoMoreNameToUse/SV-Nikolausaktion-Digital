<?php
/*########################################
for displaying (and sorting) data
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
                $id =  $row["id"];
                $vornameEmpfaenger =  $row["vornameZiel"];
                $nachnameEmpfaenger =  $row["nachnameZiel"];
                $vornameSender = $row["vornameSender"];
                $nachnameSender =  $row["nachnameSender"];
                $Stufe = $row["Stufe"];
                $Klasse = $row["Klasse"];
                $email = $row["email"];
                $Nachricht = $row["nachricht"];
                $code =  $row["code"];
                //write to db
                $sql = "INSERT INTO $relklasse (vornameZiel, nachnameZiel, vornameSender, nachnameSender, Stufe, Klasse, email, nachricht, code)
                VALUES ('$vornameEmpfaenger','$nachnameEmpfaenger','$vornameSender','$nachnameSender','$Stufe','$Klasse', '$email','$Nachricht','$code')";
                $state = "true";
                if ($conn->query($sql) === TRUE) {
                  echo "<p>Bestellung erfolgreich eingetragen!</P>";
                } else {
                  echo "OOPS :C Es ist ein unerwartete Fehler aufgetreten: " . $sql . "<br>" . $conn->error;
                }
    echo "id: " . $row["id"]. " - Empfänger: " . $row["vornameZiel"]. " " . $row["nachnameZiel"]. " - Sender: " . $row["vornameSender"]. " " . $row["nachnameSender"]. " - Stufe: " . $row["Stufe"]. " - Klasse: " . $row["Klasse"]."<br>";
  }
} else {
  echo "0 results";
}
}
$conn->close();
