<div class="panel panel-default">
  <div class="panel-body">
    <div class="form-group">
      <form method="post">
        <input type="text" class="form-control col-sm-8" placeholder="ZOEK RESTAURANT" name="zoek" autocomplete="off">
      </form>
    </div>
    <?php
    if(!empty($_POST['zoek'])){
      $restaurantZoekNaam = $_POST['zoek'];
      $restaurantZoekNaam = strtoupper($restaurantZoekNaam);
      ?>
      <h3><b><?php echo $restaurantZoekNaam ?></b></h3>
      <?php
      $stmt = DB::conn()->prepare("SELECT id FROM `Restaurant` WHERE naam LIKE ?");
      $stmt->bind_param('s', $restaurantZoekNaam);
      $stmt->execute();
      $stmt->bind_result($resultaat_id);
      $resultaten = array();
      while($stmt->fetch()){
        $resultaten[] = $resultaat_id;
      }
      $stmt->close();

      if(!empty($resultaten)){
        ?>
        <div class="resultaten">
          <table class="table">
            <tbody>
        <?php
        foreach($resultaten as $i){
          $stmt = DB::conn()->prepare("SELECT id, naam, adres, woonplaats, img FROM `Restaurant` WHERE id=?");
          $stmt->bind_param('i', $i);
          $stmt->execute();
          $stmt->bind_result($id, $naam, $adres, $woonplaats, $img);
          $stmt->fetch();
          $stmt->close();
          ?>

          <tr>
            <td><a href="/restaurant/<?php echo $naam ?>"><img src="/logo/<?php echo $img ?>" class="logo"/></a></td>
            <td><a href="/restaurant/<?php echo $naam ?>"><h4><b><?php echo $naam ?></b></h4></a><td>
            <td><h4><?php echo $adres ?></h4><td>
            <td><h4><?php echo $woonplaats ?></h4></td>
          </tr>
          </tbody>
          </table>

          <?php
        }
        ?>
        </div>
        <?php
      }else{
        echo 'NIETS GEVONDEN!';
      }
    }else{
    ?>
    <h3>ALLE RESTAURANTS</h3>
    <?php
    $stmt = DB::conn()->prepare("SELECT `id` FROM `Restaurant`");
    // $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->bind_result($result);
    $alleResultaten = array();
    while($stmt->fetch()){
      $alleResultaten[] = $result;
    }
    $stmt->close();
    ?>
    <div class="resultaten">
      <table class="table">
    <?php
    foreach($alleResultaten as $i){
      $stmt = DB::conn()->prepare("SELECT id, naam, adres, woonplaats, img FROM `Restaurant` WHERE id=?");
      $stmt->bind_param('i', $i);
      $stmt->execute();
      $stmt->bind_result($id, $naam, $adres, $woonplaats, $img);
      $stmt->fetch();
      $stmt->close();
      ?>

      <tr>
        <td><a href="/restaurant/<?php echo $naam ?>"><img src="/logo/<?php echo $img ?>" class="logo"/></a></td>
        <td><a href="/restaurant/<?php echo $naam ?>"><h4><b><?php echo $naam ?></b></h4></a><td>
        <td><h4><?php echo $adres ?></h4><td>
        <td><h4><?php echo $woonplaats ?></h4></td>
      </tr>
      <?php
    }
    ?>
  </tbody>
  </table>
  <?php
    }

    DB::conn()->close();
    ?>
  </div>
</div>
