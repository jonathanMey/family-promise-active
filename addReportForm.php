<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';
?>

<section class="viewForm-section">
  <form class="view-form" action="addReportForm.php" name="addReportForm" method="get">
    <div class="viewForm-input">
    <?php
    
    echo '<label for="startDate">Beginning Date:</label><br>';
    echo 'Date: <input class="dateTime" type="date" name="startDate" value="'.date('Y-m-d').'"><br>';
    echo '<label for="endDate">Ending Date:</label><br>';
    echo 'Date: <input class="dateTime" type="date" name="endDate" value="'.date('Y-m-d').'"><br>';       
    ?>

    </select><br>
    </div>
    <input type="submit" class="regularSubmit" value="Create Report" name="submitReportForm"><br><br>
  </form>
</section>

<?php /*
<section class="viewForm-section">
<p class="viewDescription">Report</p>  
<?php
  $sql = "SELECT p.PickID, p.street, p.status, i.priority, i.multTrips FROM Pick p, PickInfo i WHERE p.PickinfoID = i.PickInfoID";

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
    echo '<tr class="headerRow"><th>Name</th><th>Street</th><th>Status</th><th>Priority Level</th><th>Multiple Trips</th></tr>';
    $priority;
    $trips;
    
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
        echo '<tr class="evenRow"><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.$row["street"].'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["status"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$priority)).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$trips)).'</a></td></tr>';
      } else {
        echo '<tr class="oddRow"><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.$row["street"].'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["status"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$priority)).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$trips)).'</a></td></tr>';
      }
      $n++;
    }
    echo '</table>';
  }
  // close connection
  $conn->close();
  
  echo '</div>';

?>
</section>
*/ ?>
 </body>
</html>