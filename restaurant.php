<div class="panel panel-default">
  <div class="panel-body">
  <?php

  $name = $this->naam;
  // echo $name;
  $stmt = DB::conn()->prepare("SELECT `id` FROM `Restaurant` WHERE `naam` LIKE ?");
  $stmt->bind_param('s', $name);
  $stmt->execute();
  $stmt->bind_result($result);
  $stmt->fetch();
  $stmt->close();

  if(!empty($_SESSION['login'])){

    if(!empty($result)){
      $stmt = DB::conn()->prepare("SELECT id, naam, adres, woonplaats, img FROM `Restaurant` WHERE id=?");
      $stmt->bind_param('s', $result);
      $stmt->execute();
      $stmt->bind_result($id, $naam, $adres, $woonplaats, $img);
      $stmt->fetch();
      $stmt->close();

      ?>
      <div class="restaurant">
        <div class="header">
          <img src="/logo/<?php echo $img ?>">
          <h1><b><?php echo $naam ?></h1>
          <ul class="list-group">
            <li class="list-group-item"><?php echo $adres ?></li>
            <li class="list-group-item"><?php echo $woonplaats ?></li>
          </ul>
        </div>
        <?php
        if(!empty($_POST)){
          $kwal_id = rand(1, 600);
          $stmt = DB::conn()->prepare("INSERT INTO `Kwaliteit_Eten` (id, beoordeling) VALUES (?, ?)");
          $stmt->bind_param('is', $kwal_id, $_POST['kwaliteit_eten']);
          $stmt->execute();
          $stmt->close();

          $ontvngst_id = rand(1, 600);
          $stmt = DB::conn()->prepare("INSERT INTO `Ontvangst_en_service` (id, beoordeling) VALUES (?, ?)");
          $stmt->bind_param('is', $ontvngst_id, $_POST['ontvangst_en_service']);
          $stmt->execute();
          $stmt->close();

          $inricht_id = rand(1, 600);
          $stmt = DB::conn()->prepare("INSERT INTO `Inrichting_en_Sfeer` (id, beoordeling) VALUES (?, ?)");
          $stmt->bind_param('is', $inricht_id, $_POST['inrichting_en_sfeer']);
          $stmt->execute();
          $stmt->close();

          $kwaliteit_id = rand(1, 600);
          $stmt = DB::conn()->prepare("INSERT INTO `Kwaliteit` (id, beoordeling) VALUES (?, ?)");
          $stmt->bind_param('is', $kwaliteit_id, $_POST['kwaliteit']);
          $stmt->execute();
          $stmt->close();

          $zou_je_id = rand(1, 600);
          $stmt = DB::conn()->prepare("INSERT INTO `Zou_Je_Terug_Komen` (id, beoordeling) VALUES (?, ?)");
          $stmt->bind_param('is', $zou_je_id, $_POST['zou_je_terug_komen']);
          $stmt->execute();
          $stmt->close();

          $beo_id = rand(1, 600);
          $klant_id = $_SESSION['login'][0];

          $commentaar = $_POST['commentaar'];
          $cijfer = $_POST['cijfer'];
          $stmt = DB::conn()->prepare("INSERT INTO `Beoordeling` (restaurant, klant, kwaliteit_eten, ontvangst_en_service, inrichting_en_sfeer, kwaliteit, zou_je_terug_komen, commentaar, cijfer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param('iiiiiiisi', $id, $klant_id, $kwal_id, $ontvngst_id, $inricht_id, $kwaliteit_id, $zou_je_id, $commentaar, $cijfer);
          $stmt->execute();
          $stmt->close();

          echo "<div class='succes'>BEOORDELING TOEGEVOEGD</div>";
          header("Refresh:0; url=/restaurant/" . $naam);
        }else{
         ?>
        <div class="beoordeling">
          <h1>BEOORDELING</h1><br>
          <form method="post" id="beoordeling">
            <h2>KWALITEIT ETEN</h2>
            <select name="kwaliteit_eten" class="form-control" form="beoordeling">
              <option value="5">Uitstekend</option>
              <option value="4">Goed</option>
              <option value="3">Redelijk</option>
              <option value="2">Teleurstellend</option>
              <option value="1">Zeer teleurstellend</option>
            </select>

            <h2>ONTVANGST EN SERVICE</h2>
            <select name="ontvangst_en_service" class="form-control" form="beoordeling">
              <option value="5">Uitstekend</option>
              <option value="4">Goed</option>
              <option value="3">Redelijk</option>
              <option value="2">Teleurstellend</option>
              <option value="1">Zeer teleurstellend</option>
            </select>

            <h2 class="titel">INRICHTING EN SFEER</h2>
            <select name="inrichting_en_sfeer" class="form-control" form="beoordeling">
              <option value="5">Uitstekend</option>
              <option value="4">Goed</option>
              <option value="3">Redelijk</option>
              <option value="2">Teleurstellend</option>
              <option value="1">Zeer teleurstellend</option>
            </select>

            <h2 class="titel">KWALITEIT</h2>
            <select name="kwaliteit" class="form-control" form="beoordeling">
              <option value="5">Uitstekend</option>
              <option value="4">Goed</option>
              <option value="3">Redelijk</option>
              <option value="2">Teleurstellend</option>
              <option value="1">Zeer teleurstellend</option>
            </select>

            <h2 class="titel">ZOU JE TERUG KOMEN?</h2>
            <select name="zou_je_terug_komen" class="form-control" form="beoordeling">
              <option value="4">Morgen</option>
              <option value="3">Zeker</option>
              <option value="2">Misschien</option>
              <option value="1">Nooit</option>
            </select>

            <h2 class="titel">COMMENTAAR</h2>
            <input type="text" name="commentaar" class="form-control" autocomplete="off" required>

            <h2 class="titel">CIJFER (1 t/m 10)</h2>
            <input type="number" name="cijfer" min="1" max="10" class="form-control">
            <br><br>

            <input type="submit" value="VERSTUUR" class="btn form_knop">
          </form>
          </div>
          <hr></hr>
          <h3 class="titel_beoordelingen"><b>BEOORDELINGEN<b></h3>
          <?php
          $stmt = DB::conn()->prepare("SELECT id FROM Beoordeling WHERE restaurant=?");
          $stmt->bind_param('i', $id);
          $stmt->execute();
          $stmt->bind_result($e);
          $beoordelingen = array();
          $tijden = array();

          while($stmt->fetch()){
            $beoordelingen[] = $e;
          }
          $stmt->close();

          if(!empty($beoordelingen)){
            ?>
            <div class="resultaten">

            <?php

            foreach($beoordelingen as $b){
              $stmt = DB::conn()->prepare("SELECT klant, kwaliteit_eten, ontvangst_en_service, inrichting_en_sfeer, kwaliteit, zou_je_terug_komen, commentaar, cijfer FROM Beoordeling WHERE id=?");
              $stmt->bind_param('i', $b);
              $stmt->execute();
              $stmt->bind_result($klant, $kwaliteit_eten, $ontvangst_en_service, $inrichting_en_sfeer, $kwaliteit, $zou_je_terug_komen, $commentr, $cfr);
              $stmt->fetch();
              $stmt->close();

              $stmt = DB::conn()->prepare("SELECT achternaam FROM Klant WHERE id=?");
              $stmt->bind_param('i', $klant);
              $stmt->execute();
              $stmt->bind_result($klantNaam);
              $stmt->fetch();
              $stmt->close();

              $stmt = DB::conn()->prepare("SELECT beoordeling FROM Kwaliteit_Eten WHERE id=?");
              $stmt->bind_param('i', $kwaliteit_eten);
              $stmt->execute();
              $stmt->bind_result($or_kwaliteit_eten);
              $stmt->fetch();
              $stmt->close();
              $stmt = DB::conn()->prepare("SELECT beoordeling FROM Ontvangst_en_service WHERE id=?");
              $stmt->bind_param('i', $ontvangst_en_service);
              $stmt->execute();
              $stmt->bind_result($or_ontvangst_en_service);
              $stmt->fetch();
              $stmt->close();
              $stmt = DB::conn()->prepare("SELECT beoordeling FROM Inrichting_en_Sfeer WHERE id=?");
              $stmt->bind_param('i', $inrichting_en_sfeer);
              $stmt->execute();
              $stmt->bind_result($or_inrichting_en_sfeer);
              $stmt->fetch();
              $stmt->close();
              $stmt = DB::conn()->prepare("SELECT beoordeling FROM Kwaliteit WHERE id=?");
              $stmt->bind_param('i', $kwaliteit);
              $stmt->execute();
              $stmt->bind_result($or_kwaliteit);
              $stmt->fetch();
              $stmt->close();
              $stmt = DB::conn()->prepare("SELECT beoordeling FROM Zou_Je_Terug_Komen WHERE id=?");
              $stmt->bind_param('i', $zou_je_terug_komen);
              $stmt->execute();
              $stmt->bind_result($or_zou_je_terug_komen);
              $stmt->fetch();
              $stmt->close();
              ?>
              <div class="beoordeling_resultaat" id="beoordelingen">
                <div class="klant" />
                  <p><?php echo $klantNaam ?></p>
                <div class="user"><img src="/user/user.jpg" class="foto_user"/></div>
                </div>
                <div class="beoordeling_onderdelen">
                  <div class="onderdeel">
                    <h3>Kwaliteit Eten</h3>
                  <?php
                  switch($or_kwaliteit_eten){
                    case 1:
                      echo "Zeer teleurstellend";
                      break;
                    case 2:
                      echo "Teleurstellend";
                      break;
                    case 3:
                      echo "Redelijk";
                      break;
                    case 4:
                      echo "Goed";
                      break;
                    case 5:
                      echo "Uitstekend";
                      break;
                  }
                  ?>
                </div>
                  <div class="onderdeel">
                    <h3>Ontvangst en Service</h3>
                  <?php
                  switch($or_ontvangst_en_service){
                    case 1:
                      echo "Zeer teleurstellend";
                      break;
                    case 2:
                      echo "Teleurstellend";
                      break;
                    case 3:
                      echo "Redelijk";
                      break;
                    case 4:
                      echo "Goed";
                      break;
                    case 5:
                      echo "Uitstekend";
                      break;
                  }
                  ?>
                </div>
                <div class="onderdeel">
                  <h3>Inrichting en Sfeer</h3>
                  <?php
                  switch($or_inrichting_en_sfeer){
                    case 1:
                      echo "Zeer teleurstellend";
                      break;
                    case 2:
                      echo "Teleurstellend";
                      break;
                    case 3:
                      echo "Redelijk";
                      break;
                    case 4:
                      echo "Goed";
                      break;
                    case 5:
                      echo "Uitstekend";
                      break;
                  }
                  ?>
                </div>
                <div class="onderdeel">
                  <h3>Kwaliteit Eten</h3>
                  <?php
                  switch($or_kwaliteit){
                    case 1:
                      echo "Zeer teleurstellend";
                      break;
                    case 2:
                      echo "Teleurstellend";
                      break;
                    case 3:
                      echo "Redelijk";
                      break;
                    case 4:
                      echo "Goed";
                      break;
                    case 5:
                      echo "Uitstekend";
                      break;
                  }
                  ?>
                </div>
                  <div class="onderdeel">
                    <h3>Kwaliteit Eten</h3>
                  <?php
                  switch($or_zou_je_terug_komen){
                    case 1:
                      echo "Nooit";
                      break;
                    case 2:
                      echo "Misschien";
                      break;
                    case 3:
                      echo "Zeker";
                      break;
                    case 4:
                      echo "Morgen";
                      break;
                  }
                  ?>
                </div>
                <div class="onderdeel">
                  <h3>Commentaar</h3>
                  <p>" <?php echo $commentr ?> "</p>
                </div>
                <div class="onderdeel">
                  <h3>Cijfer</h3>
                  <p><?php echo $cfr ?></p>
                </div>
                </div>
              </div>
            <?php
            }
          }else{
            echo "<div class='niks'>NOG GEEN BEOORDELINGEN</div>";
          }

          ?>
        </div>
      <?php
    }
  }else{
    echo "RESTAURANT NIET GEVONDEN";
  }
}else{
  echo "U MOET <a href='/login'>INGELOGD</a> ZIJN";
}
  DB::conn()->close();
  ?>
  </div>
</div>
