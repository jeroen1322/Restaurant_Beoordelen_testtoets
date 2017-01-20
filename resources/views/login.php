<?php
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];

if(!empty($_POST)){
  if($email && $wachtwoord != ''){
    //Pak het wachtwoordid dat bij de ingevoerde email hoort
    $stmt = DB::conn()->prepare("SELECT wachtwoordid, achternaam, email, id FROM Klant WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->bind_result($wachtwoordid, $naam, $email, $klantId);
    $stmt->fetch();
    $stmt->close();

    $stmt = DB::conn()->prepare("SELECT wachtwoord FROM Wachtwoord WHERE id=?");
    $stmt->bind_param('i', $wachtwoordid);
    $stmt->execute();
    $stmt->bind_result($ww);
    $stmt->fetch();
    $stmt->close();

    // Controlleer het opgehaalde wachtwoord met het ingevoerde wachtwoord overeenkomt
    if (password_verify($wachtwoord, $ww)) {
        $_SESSION['login'] = array();
        $_SESSION['login'][] = $klantId; //Zet de session die we kunnen checken in de functie isIngelogd();
        $_SESSION['login'][] = $naam;
        header("Refresh:0; url=/");
    } else {
        echo '<div class="alert">Deze email en wachtwoord combinatie is niet bij ons geregistreerd.</div>';
    }

    DB::conn()->close();
  }else{
    echo '<div class="alert">Controleer of u alle velden correct heeft ingevuld.</div>';
  }
}
?>
<div class="panel panel-default">
  <div class="panel-body login-panel">
    <h1>LOGIN</h1>
    <form method="post">
      <input type="email" name="email" placeholder="Email" class="form-control">
      <input type="password" name="wachtwoord" placeholder="Wachtwoord" class="form-control">
      <input type="submit" name="submit" class="btn btn-primary form-knop" value="LOGIN">
    </form>
  </div>
</div>
