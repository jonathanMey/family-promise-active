<?php
//Page verification
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

//ACTION: Submit edit form 
if (isset($_GET["submitEditPickupForm"])){
  //$combinedDT = date('Y-m-d H:i:s', strtotime($_GET["cdate"]." ".$_GET["ctime"]));
  
  $combinedDT = date('Y-m-d H:i:s', strtotime($_GET["requestDate"]." ".$_GET["requestTime"]));
  $sql = "UPDATE Pick
  SET street='".$_GET["requestStreetAddress"]."',
  city='".$_GET["requestCityAddress"]."',
  state='".$_GET["requestStateAddress"]."',
  zip='".$_GET["requestZipAddress"]."'
  WHERE PickID=".$_GET["pcode"]."";
  //X debug   
  //echo $sql;
  $conn->query($sql);

  $sql = "UPDATE PickInfo
  SET RequestedDateTime='$combinedDT',
  numItems='".$_GET["requestTotalItems"]."',
  timeFrame='".str_replace("'","''",$_GET["requestTimeFrame"])."',
  priority='".$_GET["requestPriorityLvl"]."',
  notes='".str_replace("'","''",$_GET["requestNotes"])."'
  WHERE PickInfoID = (SELECT PickinfoID FROM Pick Where PickID=".$_GET["pcode"].") ";
  //X debug   
  //echo $sql;
  $conn->query($sql);

  $sql = "UPDATE Donor
  SET name='".$_GET["requestName"]."',
  phone='".$_GET["requestPhone"]."',
  email='".$_GET["requestemail"]."'
  WHERE DonorID = (SELECT DonorInfoID 
                    FROM Don d 
                    Where d.PickID=".$_GET["pcode"].")";
  //X debug   
  //echo $sql;
  $conn->query($sql);
}

//ACTION: submit Request form
if(isset($_GET['submitRequestForm'])){

  $combinedDT = date('Y-m-d H:i:s', strtotime($_GET["requestDate"]." ".$_GET["requestTime"]));
  $sql = "INSERT INTO PickInfo (RequestedDateTime, numItems, multTrips, timeFrame, priority, notes) 
  VALUES ('".$combinedDT."', '".$_GET["requestTotalItems"]."', 
  CASE WHEN '".$_GET["requestMultTrips"]."' = 'on' THEN 1 ELSE 0 END, 
  '".str_replace("'","''",$_GET["requestTimeFrame"])."', 
  '".$_GET["requestPriorityLvl"]."', 
  '".str_replace("'","''",$_GET["requestNotes"])."')";

  //X debug
  //echo $sql;
  
  $conn->query($sql);
  $getMaxID = "SELECT MAX(PickInfoID) FROM PickInfo";
  $res = $conn->query($getMaxID);
  $row = $res->fetch_assoc();
  $PickInfoID = $row["MAX(PickInfoID)"]; 
  $sql = "INSERT INTO Pick(PickinfoID, status, street, city, state, zip) 
  VALUES ('".$PickInfoID."', 
  'Requested', 
  '".$_GET["requestStreetAddress"]."', 
  '".$_GET["requestCityAddress"]."',
  '".$_GET["requestStateAddress"]."',
  '".$_GET["requestZipAddress"]."')";
  //X debug
  //echo $sql;
  $conn->query($sql);
  $getMaxID = "SELECT MAX(PickID) FROM Pick";
  $res = $conn->query($getMaxID);
  $row = $res->fetch_assoc();
  $PickID = $row["MAX(PickID)"]; 
  //Check to see if donor exists already
  $check = "SELECT DonorID, name, phone 
  FROM Donor 
  WHERE name = '".$_GET["requestName"]."' 
  AND phone = '".$_GET["requestPhone"]."'";
  //X debug
  //echo $check;
  $res = $conn->query($check);
  if($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $DonorID = $row["DonorID"];
  } else {
    if($_GET["requestHomeAddress"] == 1) {
      $sql = "INSERT INTO Donor(name, email, phone, street, city, state, zip) 
      VALUES('".$_GET["requestName"]."', 
      '".$_GET["requestEmail"]."', 
      '".$_GET["requestPhone"]."', 
      '".$_GET["requestStreetAddress"]."', 
      '".$_GET["requestCityAddress"]."', 
      '".$_GET["requestStateAddress"]."', 
      '".$_GET["requestZipAddress"]."')";
      //X debug   
      echo $sql;
      $conn->query($sql);
    } else {
      $sql = "INSERT INTO Donor(name, email, phone) 
      VALUES ('".$_GET["requestName"]."', 
      '".$_GET["requestEmail"]."', 
      '".$_GET["requestPhone"]."')";
      //X debug   
      echo $sql;
      $conn->query($sql);
    } 
    $getMaxID = "SELECT MAX(DonorID) FROM Donor";
    $res = $conn->query($getMaxID);
    $row = $res->fetch_assoc();
    $DonorID = $row["MAX(DonorID)"];  
  }
  //echo 'DonorID: '.$DonorID; 
  $sql = "INSERT INTO DonDetails(qty, isDecor, isFurniture, isKitchen, isEntertainment, isOutdoor, isMisc, notes) 
  VALUES('".$_GET["requestTotalItems"]."', 
  CASE WHEN '".$_GET["requestIsDecor"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsDecor"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsFurniture"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsFurniture"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsKitchen"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsKitchen"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsEntertainment"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsEntertainment"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsOutdoor"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsOutdoor"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsMisc"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsMisc"]."' = '' THEN 0 END END,
  '".str_replace("'","''",$_GET["requestNotes"])."')";

  //X debug
  echo $sql;
  $conn->query($sql);
  $getMaxID = "SELECT MAX(DonDetailsID) FROM DonDetails";
  $res = $conn->query($getMaxID);
  $row = $res->fetch_assoc();
  $DonDetailsID = $row["MAX(DonDetailsID)"];
  
  $sql = "INSERT INTO Don(PickID, DonorInfoID, EmpID, DonDetailsID) 
  VALUES ('".$PickID."', 
  '".$DonorID."',
   '".$_SESSION["UserID"]."', 
   '".$DonDetailsID."')";
  //X debug   
  echo $sql;
  //echo 'UserID: '.$_SESSION["UserID"];
  $conn->query($sql); 
}


//Retreive selected Pickup ID
if(isset($_GET["pcode"])) {
  $sql = "SELECT p.*, i.*, r.name, r.phone, r.email 
  FROM Pick p, PickInfo i, Don d, Donor r 
  WHERE p.PickID ='".$_GET["pcode"]."' 
  AND p.PickinfoID = i.PickInfoID 
  AND d.PickID = p.PickID 
  AND d.DonorInfoID = r.DonorID";
  // select data about the country from the country table
  $res = $conn->query($sql);
  
  //X debug 
  //echo $sql;
  
  //Store
  $pdata = $res->fetch_assoc();
 //echo $pdata["CancelledDateTime"];
 
}
?>


<div class="requestPickup-body">
  <section class="form-section">
    <div class="requestPickup-form" action="addPickupForm.php" name="requestForm" method="get">
      <div class="form-header">
        <div class="time-container">
        <?php 
          if(isset($_GET["pcode"])) {
            echo '<h3 class="datelabel">'.$pdata["status"].' ON:</h3>'; 
            if($pdata["status"] == Requested) {
              $date =  date("Y-m-d", strtotime($pdata["RequestedDateTime"]));
              $time =  date("H:i", strtotime($pdata["RequestedDateTime"]));
              echo 'Date: <input class="dateTime" type="date" name="requestDate" value="'.$date.'"><br>';
              echo 'Time: <input class="dateTime" type="time" name="requestTime" value="'.$time.'">';
            } else if($pdata["status"] == Scheduled) {
              $date =  date("Y-m-d", strtotime($pdata["ScheduleDateTime"]));
              $time =  date("H:i", strtotime($pdata["ScheduleDateTime"]));
              echo 'Date: <input class="dateTime" type="date" name="requestDate" value="'.$date.'"><br>';
              echo 'Time: <input class="dateTime" type="time" name="requestTime" value="'.$time.'">';
            } else if($pdata["status"] == Pickedup) {
              $date =  date("Y-m-d", strtotime($pdata["PickupDateTime"]));
              $time =  date("H:i", strtotime($pdata["PickupDateTime"]));
              echo 'Date: <input class="dateTime" type="date" name="requestDate" value="'.$date.'"><br>';
              echo 'Time: <input class="dateTime" type="time" name="requestTime" value="'.$time.'">';
            } else if($pdata["status"] == Completed) {
              $date =  date("Y-m-d", strtotime($pdata["DropOffDateTime"]));
              $time =  date("H:i", strtotime($pdata["DropOffDateTime"]));
              echo 'Date: <input class="dateTime" type="date" name="requestDate" value="'.$date.'"><br>';
              echo 'Time: <input class="dateTime" type="time" name="requestTime" value="'.$time.'">';
            } else if($pdata["status"] == Cancelled) {
              $date =  date("Y-m-d", strtotime($pdata["CancelledDateTime"]));
              $time =  date("H:i", strtotime($pdata["CancelledDateTime"]));
              echo 'Date: <input class="dateTime" type="date" name="requestDate" value="'.$date.'"><br>';
              echo 'Time: <input class="dateTime" type="time" name="requestTime" value="'.$time.'">';
            }
          } else {
            echo '<h3 class="datelabel">TODAYS DATE</h3>';          
            echo 'Date: <input class="dateTime" type="date" name="requestDate" value="'.date('Y-m-d').'"><br>';
            echo 'Time: <input class="dateTime" type="time" name="requestTime" value="'.date('H:i').'">';
          } 
        ?>
        </div>
        <img src="Images/stackedLogo.png" alt="Family Promise Logo">
        <h2>DONATION PICK-UP INFORMATION FORM</h2>
        <hr>
      </div>
      <div class="form-input">
        <?php      
        if (!isset($_GET["pcode"])) { 
          echo '<form action="addPickupForm.php" name="requestFormCheck" method="get">';
            //name
            echo '<label for="requestPName">Name</label><br>';
            echo '<input type="text" id="requestPName" onkeyup="autofill_requestName()" name="requestPName" value="'.$pdata["name"].'" placeholder="Enter Donor Name..." list="potentialDonors" maxlength="25" required><br>';
              echo '<datalist id="potentialDonors">';
              //create query for potential donors
              $sql = "SELECT name, phone FROM Donor";

              //X debug
              //echo $sql;

              //run the query
              $res = $conn->query($sql);
              
              while ($row = $res->fetch_assoc()) {
                echo '<option value="'.$row["name"].'" label="'.$row["phone"].'"></option>';
              }
            echo '</datalist>';

            //phone  
            echo '<label for="requestPPhone">Phone</label><br>';
            echo '<input type="tel" id=requestPPhone onkeyup="autofill_requestPhone()" name="requestPPhone" value="'.$pdata["phone"].'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialPhone" required><br>';
              echo '<datalist id="potentialPhone">';
                //create query for potential donors
                $sql = "SELECT name, phone FROM Donor";

                //X debug
                //echo $sql;

                //run the query
                $res = $conn->query($sql);
                while ($row = $res->fetch_assoc()) {
                  echo '<option value="'.$row["phone"].'" label="'.$row["name"].'"></option>';
                }
              
            echo '</datalist>';

            //submit
            echo '<input type="submit" class="regularSubmit" value="Continue" name="submitContinueRequestForm">';
          echo '</form>';
        }     

        //continuation of the request form
        $dpname = $_GET["requestPName"];
        $dpphone = $_GET["requestPPhone"];  
        //check search
        $check = "SELECT DonorID, name, phone FROM Donor WHERE name = '".$_GET["requestPName"]."' AND phone = '".$_GET["requestPPhone"]."'";
        $res = $conn->query($check);

        //X debug 
        //echo $check;

        if($row = $res->fetch_assoc()) {
          $existingDonorPID = $row["DonorID"];
          echo '<form id="requestFormFound" class="requestForm-found" action="addPickupForm.php" name="addPickupFormFound" method="get">';
            echo '<input type="hidden" name="dpcode" value="'.$existingDonorPID.'">';
            echo '<label for="autofillPickup">Donor Found! </label>';
            echo '<input type="submit" id="autofillPickup" class="regularSubmit" value="Autofill" name="submitAutofillPickupForm">';
          echo '</form>'; 
        }
          //retrieve info
        if(isset($_GET["dpcode"])) {
          $sql = "SELECT * FROM Donor WHERE DonorID='".$_GET["dpcode"]."'";
          // select data about the donor from the donor table
          $res = $conn->query($sql);
          
          //X debug 
          //echo $sql;

          //Store donor ID	
          $ddata = $res->fetch_assoc();
        }
          
        //rest of the form
        if(isset($_GET["submitAutofillPickupForm"]) || isset($_GET["pcode"]) || isset($_GET["submitContinueRequestForm"])) {  
          echo '<form action="addPickupForm.php" name="requestForm" method="get">';  
          //start if the request Form
          if (isset($_GET["pcode"])){ 	
            if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 3 || $_SESSION['Accesslvl'] == 1) {
              echo '<fieldset class="Status" disabled>';
            } else {
              echo '<fieldset class="Status">';
              echo '<label><a href="changeStatus.php?pcode='.$_GET["pcode"].'">Change Status</a></label>';
            }
              echo '<legend>Status: '.$pdata["status"].'</legend>';
            echo '</fieldset>';
          }

          if (isset($_GET["pcode"])){ 
            if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
              echo '<fieldset class="contactInfo" disabled>';
            } else {
              echo '<fieldset class="contactInfo">';
            }
          } else {
            echo '<fieldset class="contactInfo">';
          }

            if (isset($_GET["pcode"])){ 	
            echo '<input type="hidden" name="pcode" value="'.$_GET["pcode"].'">';
            }
            
              echo '<legend> Contact Information </legend>';

              //contact information
              if(isset($_GET["pcode"])) {
                //name
                echo '<label for="requestName">Name</label><br>';
                echo '<input type="text" id="requestName" onkeyup="autofill_requestName()" name="requestName" value="'.$pdata["name"].'" placeholder="Enter Donor Name..." list="potentialDonors" maxlength="25" required><br>';
                
                //phone  
                echo '<label for="requestPhone">Phone</label><br>';
                echo '<input type="tel" id="requestPhone" onkeyup="autofill_requestPhone()" name="requestPhone" value="'.$pdata["phone"].'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialPhone" required><br>';
                
                //email
                echo '<label for="requestEmail">Email</label><br>';
                echo '<input type="email" id="requestEmail" onkeyup="autofill_requestEmail()" name="requestEmail" value="'.$pdata["email"].'" placeholder="Enter Email..." list="potentialEmail"><br>';
                  echo '<datalist id="potentialEmail">';
                  
                    //create query for potential donors
                    $sql = "SELECT name, email FROM Donor";

                    //X debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["email"].'" label="'.$row["name"].'"></option>';
                    }
                  
                echo '</datalist>';
              } else if(isset($_GET["dpcode"])) {
                //name
                echo '<label for="requestName">Name</label><br>';
                echo '<input type="text" id="requestName" name="requestName" value="'.$ddata["name"].'" placeholder="Enter Donor Name..." list="potentialDonors" maxlength="25" required><br>';
                
                //phone  
                echo '<label for="requestPhone">Phone</label><br>';
                echo '<input type="tel" id="requestPhone" name="requestPhone" value="'.$ddata["phone"].'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialPhone" maxlength="20" required><br>';
                
                //email
                echo '<label for="requestEmail">Email</label><br>';
                echo '<input type="email" id="requestEmail" name="requestEmail" value="'.$ddata["email"].'" placeholder="Enter Email..." list="potentialEmail"><br>';
              } else {
                //name
                echo '<label for="requestName">Name</label><br>';
                echo '<input type="text" id="requestName" name="requestName" value="'.$dpname.'" placeholder="Enter Donor Name..." list="potentialDonors" maxlength="25" required><br>';
                
                //phone  
                echo '<label for="requestPhone">Phone</label><br>';
                echo '<input type="tel" id="requestPhone" name="requestPhone" value="'.$dpphone.'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialPhone" maxlength="20" required><br>';
                
                //email
                echo '<label for="requestEmail">Email</label><br>';
                echo '<input type="email" id="requestEmail" name="requestEmail" value="'.$ddata["email"].'" placeholder="Enter Email..." list="potentialEmail"><br>';
              }
            echo '</fieldset>';
            
            if (isset($_GET["pcode"])){ 
              if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
                echo '<fieldset class="contactInfo" disabled>';
              } else {
                echo '<fieldset class="contactInfo">';
              }
            } else {
              echo '<fieldset class="contactInfo">';
            }
              //time frame
              echo '<label for="requestTimeFrame">TimeFrame</label><br>';
              echo '<textarea id="requestTimeFrame" name="requestTimeFrame" rows="2" cols="30"  placeholder="(By friday) (Whenever) (On Date)" maxlength="255" required>'.$pdata["timeFrame"].'</textarea><br>';
            echo '</fieldset>';

            if (isset($_GET["pcode"])){ 
              if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
                echo '<fieldset class="contactInfo" disabled>';
              } else {
                echo '<fieldset class="contactInfo">';
              }
            } else {
              echo '<fieldset class="contactInfo">';
            }

              if (!isset($_GET["dpcode"])) {
                //ishomeAddress
                if(!isset($_GET["pcode"])) { 
                  echo '<label for="requestHomeAddress">Home Address?</label><br>';    
                  echo '<input type="checkbox" id="requestHomeAddress" name="requestHomeAddress" onclick="check_HomeAddress()"><br>';
                }
              } 
              if(!isset($_GET["dpcode"])) {
                //Address Information
                echo '<legend>Address of Pickup</legend>';
                //street
                echo '<label for="requestStreetAddress">Street</label><br>';
                echo '<input type="text" id="requestStreetAddress" name="requestStreetAddress" onkeyup="autofill_requestStreetAddress()" value="'.$pdata["street"].'" placeholder="Enter Street..." list="potentialStreetAddress" maxlength="80" required><br>';
                  echo '<datalist id="potentialStreetAddress"><br>';
                  
                    //create query for potential donors
                    $sql = "SELECT name, phone, street, zip FROM Donor";

                    //X debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["street"].'" label="'.$row["name"].', '.$row["zip"].'"></option>';
                    }                 
                  echo '</datalist>';

                //city
                echo '<label for="requestCityAddress">City</label><br>';
                echo '<input type="text" id="requestCityAddress" name="requestCityAddress" onkeyup="autofill_requestCityAddress()" value="'.$pdata["city"].'" placeholder="Enter City..." list="potentialCityAddress" maxlength="20" required><br>';
                  echo '<datalist id="potentialCityAddress">';
                    
                    //create query for potential donors
                    $sql = "SELECT name, phone, city, street, zip, state FROM Donor";

                    //debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["city"].'" label="'.$row["name"].', '.$row["zip"].'"></option>';
                    } 
                  echo '</datalist>';
            
                //state
                echo '<label for="requestStateAddress">State</label><br>';
                echo '<input type="text" id="requestStateAddress" name="requestStateAddress" onkeyup="autofill_requestStateAddress()" value="'.$pdata["state"].'" placeholder="Enter State..." list="potentialStateAddress" maxlength="2" required><br>';
                  echo '<datalist id="potentialStateAddress">';
                  
                    //create query for potential donors
                    $sql = "SELECT name, phone, street, zip, state FROM Donor";

                    //X debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["state"].'" label="'.$row["name"].', '.$row["zip"].'"></option>';
                    }
                  echo '</datalist>';

                //zipcode
                echo '<label for="requestZipAddress">Zipcode</label><br>';
                echo '<input type="number" id="requestZipAddress" name="requestZipAddress" onkeyup="autofill_requestZipAddress()" value="'.$pdata["zip"].'" placeholder="Enter Zipcode..." list="potentialZipAddress" maxlength="10" required><br>';
                  echo '<datalist id="potentialZipAddress">';
                  
                    //create query for potential donors
                    $sql = "SELECT name, phone, street, zip, state FROM Donor";

                    //X debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["zip"].'" label="'.$row["street"].', '.$row["state"].'"></option>';
                    }
                  echo '</datalist>';
              } else if(isset($_GET["dpcode"])){
                //Address Information
                echo '<legend>Address of Pickup</legend>';
                //street
                echo '<label for="requestStreetAddress">Street</label><br>';
                echo '<input type="text" id="requestStreetAddress" name="requestStreetAddress" onkeyup="autofill_requestStreetAddress()" value="'.$ddata["street"].'" placeholder="Enter Street..." list="potentialStreetAddress" maxlength="80" required><br>';
                  echo '<datalist id="potentialStreetAddress"><br>';
                  
                    //create query for potential donors
                    $sql = "SELECT name, phone, street, zip FROM Donor";

                    //X debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["street"].'" label="'.$row["name"].', '.$row["zip"].'"></option>';
                    }                 
                  echo '</datalist>';

                //city
                echo '<label for="requestCityAddress">City</label><br>';
                echo '<input type="text" id="requestCityAddress" name="requestCityAddress" onkeyup="autofill_requestCityAddress()" value="'.$ddata["city"].'" placeholder="Enter City..." list="potentialCityAddress" maxlength="20" required><br>';
                  echo '<datalist id="potentialCityAddress">';
                    
                    //create query for potential donors
                    $sql = "SELECT name, phone, city, street, zip, state FROM Donor";

                    //debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["city"].'" label="'.$row["name"].', '.$row["zip"].'"></option>';
                    } 
                  echo '</datalist>';
            
                //state
                echo '<label for="requestStateAddress">State</label><br>';
                echo '<input type="text" id="requestStateAddress" name="requestStateAddress" onkeyup="autofill_requestStateAddress()" value="'.$ddata["state"].'" placeholder="Enter State..." list="potentialStateAddress" maxlength="2" required><br>';
                  echo '<datalist id="potentialStateAddress">';
                  
                    //create query for potential donors
                    $sql = "SELECT name, phone, street, zip, state FROM Donor";

                    //X debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["state"].'" label="'.$row["name"].', '.$row["zip"].'"></option>';
                    }
                  echo '</datalist>';

                //zipcode
                echo '<label for="requestZipAddress">Zipcode</label><br>';
                echo '<input type="number" id="requestZipAddress" name="requestZipAddress" onkeyup="autofill_requestZipAddress()" value="'.$ddata["zip"].'" placeholder="Enter Zipcode..." list="potentialZipAddress" maxlength="10" required><br>';
                  echo '<datalist id="potentialZipAddress">';
                  
                    //create query for potential donors
                    $sql = "SELECT name, phone, street, zip, state FROM Donor";

                    //X debug
                    //echo $sql;

                    //run the query
                    $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()) {
                      echo '<option value="'.$row["zip"].'" label="'.$row["street"].', '.$row["state"].'"></option>';
                    }
                  echo '</datalist>';
              
              }      
            echo '</fieldset>';

            echo '<fieldset class="numItemsForm">';
            echo '<legend>Items to Pickup</legend>';
            //numitems
            if(!isset($_GET["pcode"])) {
              
                echo '<label for="numLargeItems"># Large items</label>';
                echo '<input type="number" id="numLargeItems" name="requestLargeItems" onchange="calculate_requestTotalItems()" min="0" step="1" value="0"><br>';
                echo '<label for="numMediumItems"># Medium items</label>';
                echo '<input type="number" id="numMediumItems" name="requestMediumItems" onchange="calculate_requestTotalItems()" min="0" step="5" value="0"><br>';
                echo '<label for="numSmallItems"># Small items</label>';
                echo '<input type="number" id="numSmallItems" name="requestSmallItems" onchange="calculate_requestTotalItems()" min="0" step="10" value="0"><br><hr>';
            } 

            //total numItems
            if (isset($_GET["pcode"])){ 
              if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
                echo '<label for="numTotalItems"># Total Items</label><br>';
                echo '<input type="number" id="numTotalItems" name="requestTotalItems" min="0" step="1" value="'.$pdata["numItems"].'" required disabled><br><hr>';
              } else {
                echo '<label for="numTotalItems"># Total Items</label><br>';
                echo '<input type="number" id="numTotalItems" name="requestTotalItems" min="0" step="1" value="'.$pdata["numItems"].'" required><br><hr>';
              }
            } else {
              echo '<label for="numTotalItems"># Total Items</label><br>';
              echo '<input type="number" id="numTotalItems" name="requestTotalItems" min="0" step="1" value="'.$pdata["numItems"].'" required><br><hr>';
            }  
            
            
            if(!isset($_GET["pcode"])) {
              //isMultipleTrips  
              echo '<label for="requestMultTrips">Multiple Trips</label>';     
              echo '<input type="checkbox" id="requestMultTrips" name="requestMultTrips"><br>';
            
            }

            //Categories
            echo '<hr><label>Categories</label><br>';

            if($pdata["isDecor"] == 1) {
              echo '<input type="checkbox" id="requestIsDecor" name="requestIsDecor" checked>';
              echo '<label for="requestIsDecor">Decor</label><br>';
            } else if($pdata["isDecor"] == 0){
              echo '<input type="checkbox" id="requestIsDecor" name="requestIsDecor">';
              echo '<label for="requestIsDecor">Decor</label><br>';
            } else {
              echo '<input type="checkbox" id="requestIsDecor" name="requestIsDecor">';
              echo '<label for="requestIsDecor">Decor</label><br>';
            }
            if($pdata["isFurniture"] == 1) {
              echo '<input type="checkbox" id="requestIsFurniture" name="requestIsFurniture" checked>';
              echo '<label for="requestIsFurniture">Furniture</label><br>';
            } else if($pdata["isFurniture"] == 0){
              echo '<input type="checkbox" id="requestIsFurniture" name="requestIsFurniture">';
              echo '<label for="requestIsFurniture">Furniture</label><br>';
            } else {
              echo '<input type="checkbox" id="requestIsFurniture" name="requestIsFurniture">';
              echo '<label for="requestIsFurniture">Furniture</label><br>';
            }
            if($pdata["isKitchen"] == 1) {
              echo '<input type="checkbox" id="requestIsKitchen" name="requestIsKitchen" checked>';
              echo '<label for="requestIsKitchen">Kitchen</label><br>';
            } else if($pdata["isKitchen"] == 0){
              echo '<input type="checkbox" id="requestIsKitchen" name="requestIsKitchen">';
              echo '<label for="requestIsKitchen">Kitchen</label><br>';
            } else {
              echo '<input type="checkbox" id="requestIsKitchen" name="requestIsKitchen">';
              echo '<label for="requestIsKitchen">Kitchen</label><br>';
            }
            if($pdata["isEntertainment"] == 1) {
              echo '<input type="checkbox" id="requestIsEntertainment" name="requestIsEntertainment" checked>';
              echo '<label for="requestIsEntertainment">Entertainment</label><br>';
            } else if($pdata["isEntertainment"] == 0){
              echo '<input type="checkbox" id="requestIsEntertainment" name="requestIsEntertainment">';
              echo '<label for="requestIsEntertainment">Entertainment</label><br>';
            } else {
              echo '<input type="checkbox" id="requestIsEntertainment" name="requestIsEntertainment">';
              echo '<label for="requestIsEntertainment">Entertainment</label><br>';
            }
            if($pdata["isOutside"] == 1) {
              echo '<input type="checkbox" id="requestIsOutdoor" name="requestIsOutdoor" checked>';
              echo '<label for="requestIsOutdoor">Outside</label><br>';
            } else if($pdata["isOutside"] == 0){
              echo '<input type="checkbox" id="requestIsOutdoor" name="requestIsOutdoor">';
              echo '<label for="requestIsOutdoor">Outside</label><br>';
            } else {
              echo '<input type="checkbox" id="requestIsOutdoor" name="requestIsOutdoor">';
              echo '<label for="requestIsOutdoor">Outside</label><br>';
            }
            if($pdata["isMisc"] == 1) {
              echo '<input type="checkbox" id="requestIsMisc" name="requestIsMisc" checked>';
              echo '<label for="requestIsMisc">Misc</label><br>';
            } else if($pdata["isMisc"] == 0){
              echo '<input type="checkbox" id="requestIsMisc" name="requestIsMisc">';
              echo '<label for="requestIsMisc">Misc</label><br>';
            } else {
              echo '<input type="checkbox" id="requestIsMisc" name="requestIsMisc">';
              echo '<label for="requestIsMisc">Misc</label><br>';
            }
            echo '</fieldset>';  


            if (isset($_GET["pcode"])){ 
              if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
                echo '<fieldset class="contactInfo" disabled>';
              } else {
                echo '<fieldset class="contactInfo">';
              }
            } else {
              echo '<fieldset class="contactInfo">';
            }

            //priority
            echo '<fieldset class="PriorityForm">';
              echo '<legend>Priority Level</legend>';
              //echo '<label style="display:none" id="'.$pdata["priority"].'"></label>';
              if($pdata["priority"] == 1) {
              echo '<label for="topPriority">Top Priority</label>';
              echo '<input type="radio" id="topPriority" name="requestPriorityLvl" value="1" required checked><br>';
              echo '<label for="midPriority">Mid Priority</label>';
              echo '<input type="radio" id="midPriority" name="requestPriorityLvl" value="2"><br>';
              echo '<label for="lowPriority">Low Priority</label>';
              echo '<input type="radio" id="lowPriority" name="requestPriorityLvl" value="3"><br>';
              } else if($pdata["priority"] == 2) {
              echo '<label for="topPriority">Top Priority</label>';
              echo '<input type="radio" id="topPriority" name="requestPriorityLvl" value="1" required><br>';
              echo '<label for="midPriority">Mid Priority</label>';
              echo '<input type="radio" id="midPriority" name="requestPriorityLvl" value="2" checked><br>';
              echo '<label for="lowPriority">Low Priority</label>';
              echo '<input type="radio" id="lowPriority" name="requestPriorityLvl" value="3"><br>';
              } else if($pdata["priority"] == 3) {
              echo '<label for="topPriority">Top Priority</label>';
              echo '<input type="radio" id="topPriority" name="requestPriorityLvl" value="1" required ><br>';
              echo '<label for="midPriority">Mid Priority</label>';
              echo '<input type="radio" id="midPriority" name="requestPriorityLvl" value="2"><br>';
              echo '<label for="lowPriority">Low Priority</label>';
              echo '<input type="radio" id="lowPriority" name="requestPriorityLvl" value="3" checked><br>';
              } else {
              echo '<label for="topPriority">Top Priority</label>';
              echo '<input type="radio" id="topPriority" name="requestPriorityLvl" value="1" required><br>';
              echo '<label for="midPriority">Mid Priority</label>';
              echo '<input type="radio" id="midPriority" name="requestPriorityLvl" value="2"><br>';
              echo '<label for="lowPriority">Low Priority</label>';
              echo '<input type="radio" id="lowPriority" name="requestPriorityLvl" value="3"><br>';
              }
            echo '</fieldset>';
            
            //notes
            echo '<label for="requestNotes">PICKUP NOTES</label><br>';
            echo '<textarea class="notes" id="requestNotes" name="requestNotes" rows="20" cols="30"  placeholder="Enter Special Pickup instructions or directions..." maxlength="255">'.$pdata["notes"].'</textarea><br>';
            
            //submit
            if (isset($_GET["pcode"])){
              if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
                
              } else {
                echo '<input type="submit" class="stickySubmit" value="Update Pickup Info"  name="submitEditPickupForm">';
              }    
            }
            else{
              //named submit button so we can tell when the form has been submitted
              echo '<input type="submit" class="stickySubmit" value="Request Pickup" name="submitRequestForm">';
            }
          echo '</form>';  
        }
        ?>
      </div>
    </div>
  </section>
</div>
</body>
</html>