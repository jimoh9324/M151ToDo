<?php
include('dbconnector.inc.php');

//Session wird gestartet
session_start();
session_regenerate_id(true);


if ($_POST) {
  $oldpassword = $_POST['oldpassword'];
  $newpassword = $_POST['newpassword'];



  $userid = $_SESSION['userid'];

  // SELECT Query erstellen, email und passwort mit Datenbank vergleichen
  $query = 'SELECT * FROM users WHERE userid=? LIMIT 1';
  // prepare()
  $stmt = $mysqli->prepare($query);
  // bind_param()
  $stmt->bind_param('s', $userid);
  // execute()
  $stmt->execute();
  // Passwort auslesen und mit dem eingegeben Passwort vergleichen
  $result = $stmt->get_result();

  $row = $result->fetch_assoc();

  if (password_verify($oldpassword, $row['password'])) {
    if (isset($_POST['newpassword']) && !empty(trim($_POST['newpassword']))) {
      $password = trim($_POST['oldpassword']);
      $newpassword = $_POST['newpassword'];
      //entspricht das passwort unseren vorgaben? (minimal 8 Zeichen, Zahlen, Buchstaben, keine Zeilenumbrüche, mindestens ein Gross- und ein Kleinbuchstabe)
      if (!preg_match("/(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $newpassword)) {
        $error .= "Passwort: Mindestlänge 8, min. 1 Gross- und Kleinbuchstabe, Zahl und ein Sonderzeichen";
      } else {
        $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $query = 'UPDATE `users` SET `password` = ? WHERE `userid` = ?';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('si', $newpassword, $row['userid']);
        $stmt->execute();
        $message = "Passwort erfolgreich geändert!";
      }
    } else {
      $error = "das Kennwort ist falsch";
    }
  }
}

?>
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Passwort ändern</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

  <div class="container">
    <h1>Passwort ändern</h1>
    <p>
      Das regelmässige Ändern Ihres Passwortes, erhöht die Sicherheit ihres Kontos.
    </p>
    <?php
    // Ausgabe der Fehlermeldungen
    if (!empty($error)) {
      echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
    } else if (!empty($message)) {
      echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
    }
    ?>
    <form action="" method="post">
      <!-- altes Passwort -->
      <div class="form-group">
        <label for="password">Altes Passwort *</label>
        <input type="password" name="oldpassword" class="form-control" id="oldpassword" placeholder="Bitte geben Sie hier ihr aktuelles Passwort ein" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute." required="true">
      </div>

      <!-- neues Passwort -->
      <div class="form-group">
        <label for="password">Neues Passwort *</label>
        <input type="password" name="newpassword" class="form-control" id="newpassword" placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute." required="true">
      </div>
      <button type="submit" name="button" value="submit" class="btn btn-info">Passwort ändern</button>
      <button type="reset" name="button" value="reset" class="btn btn-warning">Leeren</button>
      <a class="btn btn-warning" href="todo.php" role="button">Zurück</a>
    </form>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>