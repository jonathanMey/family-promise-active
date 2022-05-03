<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

if(isset($_GET["submitChangeSched"])) {

  $sql = "UPDATE Pick SET status = 'Scheduled' WHERE PickID = ".$_GET["changeID"]."";
  //X debug   
  //echo $sql;
  $conn->query($sql);
  $combinenowtime = date('Y-m-d H:i:s', strtotime(date('Y-m-d')." ".date('H:i')));
  $combinedDT = date('Y-m-d H:i:s', strtotime($_GET["scheduleAppointmentDate"]." ".$_GET["scheduleAppointmentTime"]));
  $sql = "UPDATE PickInfo SET AppointmentDateTime='".$combinedDT."', ScheduleDateTime = '".$combinenowtime."' WHERE PickInfoID = (SELECT PickinfoID FROM Pick WHERE PickID = ".$_GET["changeID"].")";
  //X debug   
  //echo $sql;
  $conn->query($sql);
}

if(isset($_GET["submitChangePick"])) {

  $sql = "UPDATE Pick SET status = 'Pickedup' WHERE PickID = ".$_GET["changeID"]."";
  //X debug   
  //echo $sql;
  $conn->query($sql);
  $combinenowtime = date('Y-m-d H:i:s', strtotime(date('Y-m-d')." ".date('H:i')));
  $sql = "UPDATE PickInfo SET PickupDateTime='".$combinenowtime."' WHERE PickInfoID = (SELECT PickinfoID FROM Pick WHERE PickID = ".$_GET["changeID"].")";
  //X debug   
  //echo $sql;
  $conn->query($sql);

  $sql = "UPDATE DonDetails SET receipt='".$_GET["receipt"]."' WHERE DonDetailsID = (SELECT DonDetailsID FROM Don WHERE PickID = ".$_GET["changeID"].")";
  //X debug   
  //echo $sql;
  $conn->query($sql);
}

if(isset($_GET["submitChangeDrop"])) {

  $sql = "UPDATE Pick SET status = 'Completed' WHERE PickID = ".$_GET["changeID"]."";
  //X debug   
  // echo $sql;
  $conn->query($sql);
  $combinenowtime = date('Y-m-d H:i:s', strtotime(date('Y-m-d')." ".date('H:i')));
  $sql = "UPDATE PickInfo SET DropOffDateTime='".$combinenowtime."' WHERE PickInfoID = (SELECT PickinfoID FROM Pick WHERE PickID = ".$_GET["changeID"].")";
  //X debug   
  //echo $sql;
  $conn->query($sql);

  $sql = "UPDATE DonDetails SET destination='".$_GET["destination"]."', whenDonated='".$combinenowtime."' WHERE DonDetailsID = (SELECT DonDetailsID FROM Don WHERE PickID = ".$_GET["changeID"].")";
  //X debug   
  //echo $sql;
  $conn->query($sql);
}



?>

<section class="viewTable-section">
<p class="viewDescription">ACTIVE PICKUPS</p>  
<?php
  $sql = "SELECT p.PickID, r.name, r.phone, p.street, p.status, i.priority 
  FROM Don d, Donor r, Pick p, PickInfo i 
  WHERE d.DonorInfoID = r.DonorID 
  AND d.PickID = p.PickID 
  AND p.PickinfoID = i.PickInfoID "; 

  if(isset($_GET["pcode"])) {
    $sql = $sql."AND p.PickID = ".$_GET["pcode"]." ";
  }
  
  $sql = $sql."AND p.status IN ('Requested', 'Scheduled', 'Pickedup')";
  $sql = $sql." ORDER BY p.status";
  //X debug
  //echo $sql;
  // display search results
  $res = $conn->query($sql);
  echo '<div class="viewTable-container">';
  if($res) {
    
    echo '<table class="viewTable" id="viewStatusTable" name="viewStatusTable">';
    echo '<tr class="headerRow"><th>Name</th><th>Contact Number</th><th>Address</th><th>Status</th></tr>';

    while ($row = $res->fetch_assoc()) {
      if($row["status"] == Requested) {
        $statusChange = "ScheduleAppointment";
      } elseif($row["status"] == Scheduled) {
        $statusChange = "ConfirmPickup";
      } elseif($row["status"] == Pickedup) {
        $statusChange = "FinalizeDropoff";
      }

      echo '<form class="changeTableForm" action="changeStatus.php" method="get">';
      echo '<input type="hidden" name="PID" value="'.$row["PickID"].'">';
      if($row["priority"] == 1) {
        echo '<tr class="high"><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.$row["name"].'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["phone"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["street"])).'</a></td><td><input type="submit" name="'.$statusChange.'" value="'.$statusChange.'"></td></tr>';
      } elseif($row["priority"] == 2) {
        echo '<tr class="mid"><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.$row["name"].'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["phone"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["street"])).'</a></td><td><input type="submit" name="'.$statusChange.'" value="'.$statusChange.'"></td></tr>';
      } elseif($row["priority"] == 3) {
        echo '<tr class="low"><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.$row["name"].'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["phone"])).'</a></td><td><a href="addPickupForm.php?pcode='.$row["PickID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["street"])).'</a></td><td><input type="submit" name="'.$statusChange.'" value="'.$statusChange.'"></td></tr>';
      }
      echo '</form>';
    }
    echo '</table>';
  }
  // close connection
  
  
  echo '</div>';

?>
</section>
<?php


if(isset($_GET["ScheduleAppointment"])) {
echo '<section class="viewForm-section">';
  
  $id = $_GET["PID"];
  $sql = "SELECT r.name 
  FROM Donor r, Don d 
  WHERE d.PickID = $id 
  AND d.DonorInfoID = r.DonorID";
  //X debug
  //echo $sql;
  $res = $conn->query($sql);
  $row = $res->fetch_assoc();
  //echo $row["name"];

  echo '<form class="view-form" action="changeStatus.php" name="scheduleAppointment" method="get">';
    
    echo '<input type="hidden" name="changeID" value="'.$id.'">';
    echo '<div class="viewForm-input">';
    
    echo '<h3 class="datelabel">Schedule Pickup Appointment for: '.$row["name"].'</h3>';          
    echo 'Date: <input class="dateTime" type="date" name="scheduleAppointmentDate" value="'.date('Y-m-d').'"><br>';
    echo 'Time: <input class="dateTime" type="time" name="scheduleAppointmentTime" value="'.date('H:i').'"><br>';
    
    

    echo '</div>';
    echo '<input type="submit" class="regularSubmit" value="Finalize Appointment" name="submitChangeSched"><br><br>';
  echo '</form>';
echo '</section>';
} else if(isset($_GET["ConfirmPickup"])) {
echo '<section class="viewForm-section">';

  $id = $_GET["PID"];
  $sql = "SELECT r.name 
  FROM Donor r, Don d 
  WHERE d.PickID = $id 
  AND d.DonorInfoID = r.DonorID";
  //X debug
  //echo $sql;
  $res = $conn->query($sql);
  $row = $res->fetch_assoc();

  echo '<form class="view-form" action="changeStatus.php" name="ConfirmPickup" method="get">';
  
    echo '<input type="hidden" name="changeID" value="'.$id.'">';
    echo '<div class="viewForm-input">';
    
    echo '<h3 class="datelabel">Confirm Pickup is Loaded for: '.$row["name"].'</h3>'; 
    echo '<label> Reciept: </label>';
    echo '<input type="radio" id="yes" name="receipt" value="1" required>';
    echo '<label for="yes">Yes </label>';
    echo '<input type="radio" id="no" name="receipt" value="0" required>';
    echo '<label for="no">No </label>';          
    echo '</div>';
    echo '<input type="submit" class="regularSubmit" value="Confirm Pickup" name="submitChangePick"><br><br>';
  echo '</form>';
echo '</section>';
} else if(isset($_GET["FinalizeDropoff"])) {
  echo '<section class="viewForm-section">';
  
  $id = $_GET["PID"];
  $sql = "SELECT r.name 
  FROM Donor r, Don d 
  WHERE d.PickID = $id 
  AND d.DonorInfoID = r.DonorID";
  //X debug
  //echo $sql;
  $res = $conn->query($sql);
  $row = $res->fetch_assoc();

    echo '<form class="view-form" action="changeStatus.php" name="CompleteDropoff" method="get">';
      echo '<input type="hidden" name="changeID" value="'.$id.'">';
      echo '<div class="viewForm-input">';
      echo '<h3 class="datelabel">Finalize Dropoff for: '.$row["name"].'</h3>';
      echo '<label> Destination: </label>';
      echo '<input type="radio" id="store" name="destination" value="2" required>';
      echo '<label for="store">Store </label>';
      echo '<input type="radio" id="warehouse" name="destination" value="1" required>';
      echo '<label for="warehouse">Warehouse </label>'; 
      echo '</div>';
      echo '<input type="submit" class="regularSubmit" value="Complete Pickup" name="submitChangeDrop"><br><br>';
    echo '</form>';
  echo '</section>';
}
?>
<?php
$conn->close();
?>
</body>
</html>