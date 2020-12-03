<!-- Using CSS Framwork form W3schools -->
<!-- ty, w3! -->
<!-- tinkered together by NoMoreNameToUse  -->

<!-- HTML starter -->
<!DOCTYPE html>
<html>
<!-- title and settings -->
<title>Nikolausaktion Codeeingabe</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- declare dependencies from google and w3.css -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">

<style>
  table,
  th,
  td {
    border: 1px solid black;
    border-collapse: collapse;
  }

  th,
  td {
    padding: 5px;
    text-align: left;
  }
</style>

<body>
  <!-- Global background color and text definition -->
  <div class="w3-sand w3-grayscale w3-large">
    <!-- Code input Container -->
    <div class="w3-container" id="codeinput">
      <div class="w3-content" style="max-width:700px">
        <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Codeeingabe</span></h5>
        <p><strong>Empfangene Code Bitte unten eingeben.</strong></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" required>
          Code: <p><input class="w3-input w3-padding-16 w3-border" name="code"><br>
            <p><input type="radio" name="upload" value="upload" checked> Upload to DB <input type="radio" name="upload" value="view"> only view
              <p><button class="w3-button w3-black" type="submit">Suche</button></p>
        </form>
      </div>
    </div>
    <!-- End page content -->
  </div>

  <div class="w3-container" id="display">
    <div class="w3-content" style="max-width:700px">
      <?php
      //DB Login Data 
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "submissiondb";

      //chech if a code is provided
      if (empty($_POST['code'])) {
        echo "<p style='text-align:center;'>Warten auf Codeeingabe</P>";
      } else {
        //Format and get the Code
        $code = strtoupper($_POST['code']);
        //Initiate some variables 
        $state = "false";
        //connect to DB
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        //Find Matched data in DB
        $sql = "SELECT * FROM submission WHERE code = '$code'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // output data of each row
          while ($row = $result->fetch_assoc()) {
            echo "<table style='width:100%'>";
            echo "<tr>" . "<th>id</th>" . "<th>Sender</th>" . "<th>reciever</th>" . "</tr>";
            echo "<tr>" . "<th>" . $row["id"] . "</th>" . "<th>" . $row["vornameZiel"] . " " . $row["nachnameZiel"] . "</th>" .  "<th>" . $row["vornameSender"] . " " . $row["nachnameSender"] .  "</th>" . "</tr>";
            echo "<tr>" . "<th>Code</th>" . "<th>klasse</th>" . "<th>stufe</th>" . "</tr>";
            echo "<tr>" ."<th>" .$row["code"]  . "</th>" . "<th>" .$row["Klasse"]  . "</th>" . "<th>" . $row["Stufe"]  . "</th>". "</tr>";
            echo "</table>";

            if (isset($_POST['upload']) && $_POST['upload'] == "upload") {
              echo "<p style='text-align:center;'>upload to db<br>";
              if ($state == "false") {
                //Variables for data transport
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
                $sql = "INSERT INTO validSubmissionTable (vornameZiel, nachnameZiel, vornameSender, nachnameSender, Stufe, Klasse, email, nachricht, code)
                VALUES ('$vornameEmpfaenger','$nachnameEmpfaenger','$vornameSender','$nachnameSender','$Stufe','$Klasse', '$email','$Nachricht','$code')";
                $state = "true";
                if ($conn->query($sql) === TRUE) {
                  echo "<p>Bestellung erfolgreich eingetragen!</P>";
                } else {
                  echo "OOPS :C Es ist ein unerwartete Fehler aufgetreten: " . $sql . "<br>" . $conn->error;
                }
                $sql = "DELETE FROM submission WHERE id= $id";
                
                //Delete DB
                if ($conn->query($sql) === TRUE) {
                  echo "Datensatz aus alte DB entfernt";
                } else {
                  echo "Error deleting record: " . $conn->error;
                }
              }
            }
          }
        } else {
          echo "no matched data found ('_')";
        }

        $conn->close();
      }
      ?>
    </div>
  </div>
  <!-- Footer -->
  <footer class="w3-center w3-light-grey w3-padding-48 w3-large">
  </footer>
</body>

</html>