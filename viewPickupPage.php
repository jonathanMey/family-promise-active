<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

if(isset($_GET["submitAddPickupForm"])){
  
  header("location: addPickupForm.php");
}

?>

<section class="viewForm-section">
  <form class="view-form" action="viewPickupPage.php" name="viewPickupForm" method="get">
    <div class="viewForm-input">
    <?php
    if (isset($_GET["viewPickupStreet"])) {
      echo '<label for="viewPickupStreet">Search by Pickup Street Address:</label><br>';
      echo '<input type="text" id="viewPickupStreet" onkeyup="autofill_viewPickupTable()" name="viewPickupStreet" value="'.$_GET["viewPickupStreet"].'"><br>';
    } else {
      echo '<label for="viewPickupStreet">Search by Pickup Street:</label><br>';
      echo '<input type="text" id="viewPickupStreet" onkeyup="autofill_viewPickupTable()" name="viewPickupStreet" placeholder="Search for Pickups..."><br>';
    }
    ?>

    <label for="viewPickupStatus">Refine by Status:</label><br>
    <select id="viewPickupStatus" name="viewPickupStatus">
    <option value=""></option>
    <?php
    $res = $conn->query("SELECT DISTINCT status FROM Pick ORDER BY 1");
    while ($row = $res->fetch_assoc()) {
      if($_GET["viewPickupStatus"] == $row["status"]) {
        echo '<option value="'.$row["status"].'" selected>'.$row["status"].'</option>';
      } else {
        echo '<option value="'.$row["status"].'">'.$row["status"].'</option>';
      }
    }
    ?>
    </select><br>
    </div>
    <input type="submit" class="regularSubmit" value="Search Pickups" name="submitViewPickupForm"><br><br>
    <input type="submit" class="regularSubmit" value="Request a Pickup" name="submitAddPickupForm"><br><br>
  </form>
</section>
<section class="viewTable-section">
<p class="viewDescription">PICKUPS</p>  
<?php
  $sql = "SELECT p.PickID, r.name, p.street, p.status, i.priority, i.multTrips FROM Pick p, PickInfo i, Don d, Donor r WHERE p.PickinfoID = i.PickInfoID AND p.PickID = d.PickID AND d.DonorInfoID = r.DonorID";

  $sql = $sql ." HAVING p.street LIKE '%".$_GET["viewPickupStreet"]."%'";

  if (isset($_GET["viewPickupStatus"]) && !empty($_GET["viewPickupStatus"])) {
    $sql= $sql." AND p.status = '".$_GET["viewPickupStatus"]."'";
  }
  $sql = $sql." ORDER BY p.status";
  //debug
  //echo $sql;
  // display search results
  $res = $conn->query($sql);
  echo '<div class="viewTable-container">';
  if($res) {
    $n = 0;
    echo '<table class="viewTable" id="viewPickupTable" name="viewPickupTable">';
    echo '<thead>';
    echo '<tr class="headerRow"><th>Name</th><th>Street</th><th>Status</th><th>Priority Level</th><th>Multiple Trips</th></tr>';
    echo '</thead>';
    $priority;
    $trips;
    echo '<tbody>';
    while ($row = $res->fetch_assoc()) {
      if($row["priority"] == 1) {
        $priority = "High";
      } elseif($row["priority"] == 2) {
        $priority = "Mid";
      } elseif($row["priority"] == 3) {
        $priority = "Low";
      }
      if($row["multTrips"] == 1) {
        $trips = "Yes";
      } elseif($row["multTrips"] == 0) {
        $trips = "No";
      }

      if($n%2==0){
        echo '<tr class="evenRow"><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["name"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.$row["street"].'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["status"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$priority)).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$trips)).'</a></td></tr>';
      } else {
        echo '<tr class="oddRow"><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["name"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.$row["street"].'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["status"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$priority)).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$trips)).'</a></td></tr>';
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