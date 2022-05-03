<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

//If adding new, Redirect to add donation page
if(isset($_GET["submitAddDonationsForm"])){
  
  header("location: addDonationForm.php");
}

?>


<section class="viewForm-section">
  <form class="view-form" action="viewDonationsPage.php" name="viewDonationsForm" method="get">
    <div class="viewForm-input">
    <?php
    if (isset($_GET["viewDonationsDonor"])) {
      echo '<label for="viewDonationsDonor">Search by Donations Donor:</label><br>';
      echo '<input type="text" id="viewDonationsDonor" onkeyup="autofill_viewDonationsTable()" name="viewDonationsDonor" value="'.$_GET["viewDonationsDonor"].'"><br>';
    } else {
      echo '<label for="viewDonationsDonor">Search by Donations Donor:</label><br>';
      echo '<input type="text" id="viewDonationsDonor" onkeyup="autofill_viewDonationsTable()" name="viewDonationsDonor" placeholder="Search for Donations..."><br>';
    }
    ?>

    <label for="viewDonationsDest">Refine by Destination:</label><br>
    <select id="viewDonationsDest" name="viewDonationsDest">
    <option value=""></option>
    <?php
    $res = $conn->query("SELECT DISTINCT Destination FROM LookupDestination ORDER BY 1");
    while ($row = $res->fetch_assoc()) {
      if($_GET["viewDonationsDest"] == $row["Destination"]) {
        echo '<option value="'.$row["Destination"].'" selected>'.$row["Destination"].'</option>';
      } else {
        echo '<option value="'.$row["Destination"].'">'.$row["Destination"].'</option>';
      }
    }
    ?>
    </select><br>
    </div>
    <input type="submit" class="regularSubmit" value="Search Donations" name="submitViewDonationsForm"><br><br>
    <input type="submit" class="regularSubmit" value="Add new Donation" name="submitAddDonationsForm"><br><br>
  </form>
</section>
<section class="viewTable-section">
<p class="viewDescription">DONATIONS</p>  
<?php

  


  $sql = "SELECT d.DonID, dr.name, dd.whenDonated, l.Destination 
  FROM Don d, Donor dr, DonDetails dd, LookupDestination l 
  WHERE d.DonorInfoID = dr.DonorID 
  AND d.DonDetailsID = dd.DonDetailsID 
  AND dd.destination = l.Destinationid";

  $sql = $sql." HAVING dr.name LIKE '%".$_GET["viewDonationsDonor"]."%'";

  if (isset($_GET["viewDonationsDest"]) && !empty($_GET["viewDonationsDest"])) {
    $sql= $sql." AND l.Destination = '".$_GET["viewDonationsDest"]."'";
  }
  $sql = $sql." ORDER BY dr.name";
  //X debug
  //echo $sql;
  // display search results
  $res = $conn->query($sql);
  echo '<div class="viewTable-container">';
  if($res) {
    $n = 0;
    echo '<table class="viewTable" id="viewDonationsTable" name="viewDonationsTable">';
    echo '<thead>';
    echo '<tr class="headerRow"><th>Donor</th><th>Type of Donation</th><th>Donated On</th><th>Destination</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $res->fetch_assoc()) {

      //Check type
      $dtype = "SELECT PickID
      FROM Don 
      WHERE DonID ='".$_GET["ocode"]."'";

      $subres = $conn->query($dtype);

      //X debug
      //echo $dtype;

      $subrow = $subres->fetch_assoc();

      //If Pickup Donation
      if ($subrow["PickID"] == NULL) {   
        $isPickup = TRUE;
        $donType="Pick up";
      //If Dropoff Donation
      } else {
        $isPickup = FALSE;
        $donType="Drop off";
      }

      if($n%2==0){
        echo '<tr class="evenRow"><td><a href="addDonationForm.php?ocode='.$row["DonID"].'">'.$row["name"].'</a></td><td><a href="addDonationForm.php?ocode='.$row["DonID"].'">'.utf8_encode(str_replace(chr(146),"'",$donType)).'</a></td><td><a href="addDonationForm.php?ocode='.$row["DonID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["whenDonated"])).'</a></td><td><a href="addDonationForm.php?ocode='.$row["DonID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["Destination"])).'</a></td></tr>';
      } else {
        echo '<tr class="oddRow"><td><a href="addDonationForm.php?ocode='.$row["DonID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["name"])).'</a></td><td><a href="addDonationForm.php?ocode='.$row["DonID"].'">'.utf8_encode(str_replace(chr(146),"'",$donType)).'</a></td><td><a href="addDonationForm.php?ocode='.$row["DonID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["whenDonated"])).'</a></td><td><a href="addDonationForm.php?ocode='.$row["DonID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["Destination"])).'</a></td></tr>';
      }
      $n++;
    }
    echo '</tbody>';
    echo '</table>';
  }
  // close connection
  $conn->close();
  
  echo '</div>';

?>
</section>

 </body>
</html>