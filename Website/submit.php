<!-- PHP Handler and website with MariaDB and Mysql for storing orders and displaying Code  -->
<!-- tinkered together by NoMoreNameToUse -->
<!DOCTYPE html>
<html>
<title>Rückmeldung: Nikolausaktion Gymnasium Rodenkirchen</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- declare dependencies from google and w3.css -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">

<!-- CSS declaration -->
<style>
  body,
  html {
    height: 100%;
    font-family: "Inconsolata", sans-serif;
  }

  .bgimg {
    background-position: center;
    background-size: cover;
    background-image: url("deko.jpg");
    min-height: 40%;
  }
</style>

<!-- Website -->
<body>
  <!-- Top bar  -->
  <div class="w3-top">
    <div class="w3-row w3-padding w3-black">
      <div class="w3-col s4">
        <a href="index.htm" class="w3-button w3-block w3-black">Registrierung</a>
      </div>
      <div class="w3-col s4">
        <a href="index.htm" class="w3-button w3-block w3-black">Über</a>
      </div>
      <div class="w3-col s4">
        <a href="http://www.gymnasium-rodenkirchen.de/" class="w3-button w3-block w3-black">Gymnasium Rodenkirchen</a>
      </div>
    </div>
  </div>

  <!-- Header -->
  <header class="bgimg w3-display-container w3-grayscale-min" id="home">
    <div class="w3-display-bottomleft w3-center w3-padding-large w3-hide-small">
  </header>

  <!-- Global background color and text declaration-->
  <div class="w3-sand w3-grayscale w3-large">

    <!-- feedback Container -->
    <div class="w3-container" id="feedback">
      <div class="w3-content" style="max-width:700px">
      <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Rückmeldung</span></h5>
      <!-- php code -->
            <?php
                //Mysql connection data
                $servername = "localhost";
	            	$username = "mysql";
	            	$password = "Halloworld2020";
                $dbname = "submissionDB";
                //get data with HTTP POST method
                $vornameEmpfaenger = ucfirst(test_input($_POST['VornameEmpfaenger']));
                $nachnameEmpfaenger = ucfirst(test_input($_POST['NachnameEmpfaenger']));
                $vornameSender= ucfirst(test_input($_POST['EigeneVorname']));
                $nachnameSender = ucfirst(test_input($_POST['EigeneNachname']));
                $Stufe = test_input($_POST['Stufe']);
                $Klasse = test_input($_POST['Klasse']);
                $email = test_input($_POST['Email']);
                //add slashes to the message to prevent any errors 
                $Nachricht = addslashes($_POST['Nachricht']);
                
                //test user input for security purposes 
                function test_input($data) {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
                }
                //get lengh of all dame added toghether and generate identification code
                $length = strlen($vornameEmpfaenger.$nachnameEmpfaenger.$vornameSender.$nachnameSender);
                $code = strtoupper($vornameEmpfaenger[0].$nachnameEmpfaenger[0].$vornameSender[0].$nachnameSender[0].$length);
                // Create connection with DB
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }
                //Insert data into DB
                $sql = "INSERT INTO submission (vornameZiel, nachnameZiel, vornameSender, nachnameSender, Stufe, Klasse, email, nachricht, code)
                VALUES ('$vornameEmpfaenger','$nachnameEmpfaenger','$vornameSender','$nachnameSender','$Stufe','$Klasse', '$email','$Nachricht','$code')";

                //Check if the registration is successful
                if ($conn->query($sql) === TRUE) {
                echo "<p>Bestellung erfolgreich eingetragen!</P>";
                echo "<p>Dein Code:<h1>"."$code"."</h1></p>";
                //Send Email
                if(empty($email) == FALSE){
                  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "Emailformat ist leider nicht gültig";
                  }else{
                    require_once "Mail.php";
                    //HIER EIGENE DATEN EINGEBEN
                    $from = "";
                    $to = "<$email>";
                    echo("$to");
                    $subject = "SV Nikoulausatkion Eingangsbestätigung";
                    $body = "ATUOMATISCH GESENDET \nBestätigung deine Bestellung:\n".$code."\nEmpfänger:".$vornameEmpfaenger." ".$nachnameEmpfaenger;
                    
                    //HIER EIGENE SMTP SERVICE EINGEBEN, ich habe gmail verwendet
                    $host = "ssl://smtp.gmail.com";
                    $port = "465";
                    //HIER EIGENE DATEN EINGEBEN
                    $username = "";
                    //HIER EIGENE DATEN EINGEBEN
                    $password = "space030504";
                    
                    $headers = array ('From' => $from,
                      'To' => $to,
                      'Subject' => $subject);
                    $smtp = Mail::factory('smtp',
                      array ('host' => $host,
                        'port' => $port,
                        'auth' => true,
                        'username' => $username,
                        'password' => $password));
                    
                    $mail = $smtp->send($to, $headers, $body);
                    
                    if (PEAR::isError($mail)) {
                      echo("<p>" . $mail->getMessage() . "</p>");
                     } else {
                      echo("<p>Eine Bestätigungsemail wurde erfolgreich an $email gesendet</p>");
                     }
                    } 
                }
                } else {
                echo "OOPS :C Es ist ein unerwartete Fehler aufgetreten: " . $sql . "<br>" . $conn->error;
                }
                //close connection with DB
                $conn->close();
            ?>
            <p><strong> Schreibe diesen Code bitte leserlich bei der Bezahlung auf den Briefumschlag! :D </strong></p>
            <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Abgabe</span></h5>
            <p><strong>Für die Unter- und Mittelstufe gehen wir in den Pausen, vom 24.11.20 bis zum 01.12.20, zu allen Klassen und sammeln die Umschläge ein.
             Die Oberstufe kann ihre Umschläge im gleichen Zeitraum im Oberstufensekretariat abgeben.</strong></p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="w3-center w3-light-grey w3-padding-48 w3-large">
  </footer>

</body>

</html>
