<?php
//Page setup
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';
//$addDonor;
//ACTION: Submit EDIT pick up donation form
if (isset($_GET["submitEditPDonationForm"])){
  
  $combinedDTR = date('Y-m-d H:i:s', strtotime($_GET["rDate"]." ".$_GET["rTime"]));
  $combinedDTS = date('Y-m-d H:i:s', strtotime($_GET["sDate"]." ".$_GET["sTime"]));
  $combinedDTP = date('Y-m-d H:i:s', strtotime($_GET["pDate"]." ".$_GET["pTime"]));
  $combinedDTD = date('Y-m-d H:i:s', strtotime($_GET["dDate"]." ".$_GET["dTime"]));
  $combinedDTC = date('Y-m-d H:i:s', strtotime($_GET["cDate"]." ".$_GET["cTime"]));

  $sql = "UPDATE PickInfo
  SET RequestedDateTime='".$combinedDTR."',
  ScheduleDateTime='".$combinedDTS."',
  PickupDateTime='".$combinedDTP."',
  DropOffDateTime='".$combinedDTD."',
  CancelledDateTime='".$combinedDTC."',
  numItems='".$_GET["requestTotalItems"]."',
  notes='".str_replace("'","''",$_GET["requestNotes"])."'
  WHERE PickInfoID = (SELECT PickID FROM Don Where DonID=".$_GET["ocode"].") ";
  //X debug   
  //echo $sql;
  $conn->query($sql);

  $sql="UPDATE DonDetails
  SET qty = '".$_GET["requestTotalItems"]."',
  isDecor=CASE WHEN '".$_GET["requestIsDecor"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsDecor"]."' = '' THEN 0 END END,
  isFurniture=CASE WHEN '".$_GET["requestIsFurniture"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsFurniture"]."' = '' THEN 0 END END,
  isKitchen=CASE WHEN '".$_GET["requestIsKitchen"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsKitchen"]."' = '' THEN 0 END END,
  isEntertainment=CASE WHEN '".$_GET["requestIsEntertainment"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsEntertainment"]."' = '' THEN 0 END END,
  isOutdoor=CASE WHEN '".$_GET["requestIsOutdoor"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsOutdoor"]."' = '' THEN 0 END END,
  isMisc=CASE WHEN '".$_GET["requestIsMisc"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsMisc"]."' = '' THEN 0 END END,
  receipt='".$_GET["receipt"]."',
  destination='".$_GET["destination"]."',
  notes='".str_replace("'","''",$_GET["requestNotes"])."'
  whenDonated='".$combinedDTD."',
  WHERE DonDetailsID = (SELECT DonDetailsID FROM Don WHERE DonID=".$_GET["ocode"].")";
  //X debug
  //echo $sql;
  $conn->query($sql);

}

//ACTION: Submit EDIT drop off donation form
if(isset($_GET["submitEditDDonationForm"])) {

  $combinedDT = date('Y-m-d H:i:s', strtotime($_GET["wDate"]." ".$_GET["wTime"]));

  $sql="UPDATE DonDetails
  SET qty = '".$_GET["requestTotalItems"]."',
  isDecor=CASE WHEN '".$_GET["requestIsDecor"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsDecor"]."' = '' THEN 0 END END,
  isFurniture=CASE WHEN '".$_GET["requestIsFurniture"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsFurniture"]."' = '' THEN 0 END END,
  isKitchen=CASE WHEN '".$_GET["requestIsKitchen"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsKitchen"]."' = '' THEN 0 END END,
  isEntertainment=CASE WHEN '".$_GET["requestIsEntertainment"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsEntertainment"]."' = '' THEN 0 END END,
  isOutdoor=CASE WHEN '".$_GET["requestIsOutdoor"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsOutdoor"]."' = '' THEN 0 END END,
  isMisc=CASE WHEN '".$_GET["requestIsMisc"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsMisc"]."' = '' THEN 0 END END,
  receipt='".$_GET["receipt"]."',
  destination='".$_GET["destination"]."',
  notes='".str_replace("'","''",$_GET["requestNotes"])."',
  whenDonated='".$combinedDT."'
  WHERE DonDetailsID = (SELECT DonDetailsID FROM Don WHERE DonID=".$_GET["ocode"].")";
  //X debug
  //echo $sql;
  $conn->query($sql);
}

//ACTION: submit ADD drop off donation page 
if(isset($_GET["submitAddDonationForm"])){  
  
  //Insert PickInfo
  $combinenowtime = date('Y-m-d H:i:s', strtotime(date('Y-m-d')." ".date('H:i')));
  $sql = "INSERT INTO DonDetails (qty, isDecor, isFurniture, isKitchen, isEntertainment, isOutdoor, isMisc, receipt, destination, notes, whenDonated) 
  VALUES ('".$_GET["requestTotalItems"]."',
  CASE WHEN '".$_GET["requestIsDecor"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsDecor"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsFurniture"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsFurniture"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsKitchen"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsKitchen"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsEntertainment"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsEntertainment"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsOutdoor"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsOutdoor"]."' = '' THEN 0 END END,
  CASE WHEN '".$_GET["requestIsMisc"]."' = 'on' THEN 1 ELSE CASE WHEN '".$_GET["requestIsMisc"]."' = '' THEN 0 END END,
  '".$_GET["receipt"]."',
  '".$_GET["destination"]."', 
  '".str_replace("'","''",$_GET["requestNotes"])."',
  '".$combinenowtime."')";

  //X debug
  echo $sql;
  
  $conn->query($sql);

  $name = $_GET["donName"];
  $phone = $_GET["donPhone"];
  $check = "SELECT DonorID, name, phone FROM Donor WHERE name = '".$_GET["donName"]."' AND phone = '".$_GET["donPhone"]."'";
  $res = $conn->query($check);

  //X debug 
  echo $check;
  
  if($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $DonorID = $row["DonorID"];
  } else {
    
    $sql = "INSERT INTO Donor (name, email, phone, gender, age_group, street, city, state, zip, heard, Vip, notes)  
    VALUES(CASE WHEN '".$_GET["addDonorName"]."' = '' THEN NULL ELSE '".$_GET["addDonorName"]."' END, 
    CASE WHEN '".$_GET["addDonorEmail"]."' = '' THEN NULL ELSE '".$_GET["addDonorEmail"]."' END, 
    CASE WHEN '".$_GET["addDonorPhone"]."' = '' THEN NULL ELSE '".$_GET["addDonorPhone"]."' END, 
    CASE WHEN '".$_GET["addDonorGender"]."' = '' THEN NULL ELSE '".$_GET["addDonorGender"]."' END, 
    CASE WHEN '".$_GET["addDonorAge"]."' = '' THEN NULL ELSE '".$_GET["addDonorAge"]."' END, 
    CASE WHEN '".$_GET["addDonorStreet"]."' = '' THEN NULL ELSE '".$_GET["addDonorStreet"]."' END, 
    CASE WHEN '".$_GET["addDonorCity"]."' = '' THEN NULL ELSE '".$_GET["addDonorCity"]."' END,
    CASE WHEN '".$_GET["addDonorState"]."' = '' THEN NULL ELSE '".$_GET["addDonorState"]."' END, 
    CASE WHEN '".$_GET["addDonorZip"]."' = '' THEN NULL ELSE '".$_GET["addDonorZip"]."' END, 
    CASE WHEN '".$_GET["addDonorHeard"]."' = '' THEN NULL ELSE '".$_GET["addDonorHeard"]."' END, 
    CASE WHEN '".$_GET["addDonorIP"]."' = '' THEN NULL ELSE '".$_GET["addDonorIP"]."' END, 
    CASE WHEN '".$_GET["addDonorNotes"]."' = '' THEN NULL ELSE '".$_GET["addDonorNotes"]."' END)";
  
    //X debug   
    echo $sql;

    $conn->query($sql);
    
    $getMaxID = "SELECT MAX(DonorID) FROM Donor";
    $res = $conn->query($getMaxID);
    $row = $res->fetch_assoc();
    $DonorID = $row["MAX(DonorID)"];  
  }


  //Insert Don
  $getMaxID = "SELECT MAX(DonDetailsID) FROM DonDetails";
  $res = $conn->query($getMaxID);
  $row = $res->fetch_assoc();
  $DonDetailsID = $row["MAX(DonDetailsID)"];
  
  $sql = "INSERT INTO Don(DonorInfoID, EmpID, DonDetailsID) 
  VALUES ('".$DonorID."',
  '".$_SESSION["UserID"]."', 
  '".$DonDetailsID."')";
  //X debug   
  echo $sql;
  //echo 'UserID: '.$_SESSION["UserID"];
  $conn->query($sql);

}

// Retrieve selected Donation id
if(isset($_GET["ocode"])) {

  //Check type
  $dtype = "SELECT PickID
                FROM Don 
                WHERE DonID ='".$_GET["ocode"]."'";

  $res = $conn->query($dtype);

  //X debug
  //echo $dtype;

  $row = $res->fetch_assoc();

  //X debug
  //echo $row["PickID"];

  //If Drop off Donation
  if ($row["PickID"] === NULL) {

    $sql = "SELECT o.*, r.name, r.phone, e.fname, e.lname, e.role FROM DonDetails o, Employee e, Don d, Donor r WHERE d.DonID ='".$_GET["ocode"]."' AND d.DonorInfoID = r.DonorID AND d.DonDetailsID = o.DonDetailsID AND d.EmpID = e.Employeeid";

    //X debug
    //echo $sql;
    $isPickup = FALSE;
  
  //If Pickup Donation
  } else {

    $sql = "SELECT i.*, o.*, p.status, r.name, r.phone, e.fname, e.lname, e.role FROM DonDetails o, Employee e, Pick p, PickInfo i, Don d, Donor r WHERE d.DonID ='".$_GET["ocode"]."' AND p.PickinfoID = i.PickInfoID AND d.PickID = p.PickID AND d.DonorInfoID = r.DonorID AND d.DonDetailsID = o.DonDetailsID AND d.EmpID = e.Employeeid";

    //X debug
    //echo $sql;
    $isPickup = TRUE;
  }
 
  $res = $conn->query($sql);
    
  //X debug 
  //echo $sql;
  
  //Store
  $odata = $res->fetch_assoc();
}

?>
<section class="addForm-section">
  <div class="add-form">
    <div class="addForm-header">
      <img class="addFormHeader-logo" src="Images/horizontalLogo.png" alt="Family Promise Logo">
      <h2>DONATION INFORMATION FORM</h2>
      <hr>
    </div>
    <?php
    //If ocode is NOT set
    if(!isset($_GET["ocode"])) {

      //yes_no donor form
      echo '<form class="addForm-choose" action="addDonationForm.php" name="addDonationFormChoose" method="get">';
        echo '<label>Add Donor Information?</label><br>';
        echo '<input type="hidden" name="choice" value="set">';
        echo '<input type="submit" class="regularSubmit" id="submitChooseYesBtn" name="submitChooseYesBtn" value="Credit a Donor">';
        echo '<input type="submit" class="regularSubmit" id="submitChooseNoBtn" name="submitChooseNoBtn" value="Mark as Anonymous">';
      echo '</form><hr>';

      //If YES
      if(isset($_GET["submitChooseYesBtn"])) {
        //Initial Info form
        $creditDonor = TRUE;
        echo '<form class="addForm-check" action="addDonationForm.php" name="addDonationFormCheck" method="get">';
          
          //name
          echo '<label for="requestDDName">*Name:</label><br>';
          echo '<input type="text" id="requestDDName" onkeyup="autofill_input(this.getAttribute("Id"),document.getElementById("potentialDonorNames").Id))" name="requestDDName" value="'.$ddata["name"].'" placeholder="FirstName LastName..." list="potentialDonorNames" maxlength="25" required><br>';          
          echo '<datalist id="potentialDonorNames">';
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
          echo '<label for="requestDDPhone">*Phone Number:</label><br>';
          echo '<input type="tel" id="requestDDPhone" onkeyup="autofill_input(this.getAttribute("Id"),document.getElementById("potentialDonorsPhone").Id))" name="requestDDPhone" value="'.$ddata["phone"].'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialDonorsPhone" maxlength="20" required><br>';
          echo '<datalist id="potentialDonorsPhone">';
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
          echo '<input type="submit" class="regularSubmit" value="Continue" name="submitContinueDonationForm">';

        echo '</form>';
      }
      
      //Find Donor
      $name = $_GET["requestDDName"];
      $phone = $_GET["requestDDPhone"];
      $check = "SELECT DonorID, name, phone FROM Donor WHERE name = '".$_GET["requestDDName"]."' AND phone = '".$_GET["requestDDPhone"]."'";
      $res = $conn->query($check);

      //X debug 
      //echo $check;
      
      if($row = $res->fetch_assoc()) {
        $donorFound = TRUE;
      } else if($creditDonor == TRUE) {
        $donorFound = FALSE;
      }

      //Beginning of the Donation form
      echo '<form class="addForm-input" action="addDonationForm.php" name="addDonationForm" method="get">';

    

      //If Donor is Found
      if($donorFound == TRUE & isset($_GET["submitContinueDonationForm"])) {
        $existingDonorID = $row["DonorID"];
        //echo $existingDonorID;
        //echo '<form id="addFormFound" class="addForm-found" action="addDonationForm.php" name="addDonationFormFound" method="get">';
        //echo '<input type="hidden" name="dcode" value="'.$existingDonorID.'">';
        echo '<label for="creditDonor">Donor Found!</label><br>';
        //echo '<input type="submit" id="creditDonor" class="regularSubmit" value="Credit Donor & Continue Form" name="submitCreditDonorForm">';
        //echo '</form>';
      
        //retrieve donor info
        $sql = "SELECT * FROM Donor WHERE DonorID='".$_GET["dcode"]."'";
        // select data about the donor from the donor table
        $res = $conn->query($sql);
        
        //X debug 
        //echo $sql;

        //Store donor ID	
        $ddata = $res->fetch_assoc();

        //name
        echo '<label for="donName">Name</label><br>';
        echo '<input type="text" id="donName" name="donName" value="'.$name.'" placeholder="Enter Donor Name..." list="potentialDonors" maxlength="25" required><br>';
        
        //phone  
        echo '<label for="donPhone">Phone</label><br>';
        echo '<input type="tel" id="donPhone" name="donPhone" value="'.$phone.'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialPhone" maxlength="20" required><br>';
      

      //If Donor is not Found
      } else if ($donorFound == FALSE && isset($_GET["submitContinueDonationForm"])) {

        //Empty Donor Information Form
        echo '<div class="addForm-input">';

          echo '<fieldset class="info" name="DonorInfo">';
          
          //start of the donor information form
            echo '<legend>New Donor information</legend>';

            //name
            echo '<label for="addDonorName">*Name:</label><br>';
            echo '<input type="text" id="addDonorName" name="addDonorName" value="'.$name.'" placeholder="FirstName LastName..." list="potentialDonorNames" maxlength="25"><br>';
          
            //phone
            echo '<label for="addDonorPhone">*Phone Number:</label><br>';
            echo '<input type="tel" id="addDonorPhone" name="addDonorPhone" value="'.$phone.'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialDonorsPhone" maxlength="20"><br>';
              
            //email
            echo '<label for="addDonorEmail">Email Address:</label><br>';
            echo '<input type="email" id="addDonorEmail" onkeyup="autofill_input(this.getAttribute("Id"),document.getElementById("potentialDonorsEmail").Id))" name="addDonorEmail" placeholder="johndoe@gmail.com..." list="potentialDonorsEmail" maxlength="50"><br>';
            
              echo '<datalist id="potentialDonorsEmail">';
                //create query for potential donors
                $sql = "SELECT email, name FROM Donor";

                //X debug
                //echo $sql;

                //run the query
                $res = $conn->query($sql);
                while ($row = $res->fetch_assoc()) {
                  echo '<option value="'.$row["email"].'" label="'.$row["name"].'"></option>';
                }
              echo '</datalist>';

            //gender
            echo '<label for="addDonorMale">Male:</label>';
            echo '<input type="radio" id="addDonorMale" name="addDonorGender" value="M"><br>'; 
            echo '<label for="addDonorFemale">Female:</label>';
            echo '<input type="radio" id="addDonorFemale" name="addDonorGender" value="F"><br>'; 
                

            //age group
            echo '<label for="addDonorAge">Age group:</label><br>';
            echo '<select id="addDonorAge" name="addDonorAge">';
            echo '<option value="" label=""></option>';
            echo '<option value="1" label="0-20">0-20</option>';
            echo '<option value="2" label="20-30">20-30</option>';
            echo '<option value="3" label="30-40">30-40</option>';
            echo '<option value="4" label="40-60">40-60</option>';
            echo '<option value="5" label="60-70">60-70</option>';
            echo '<option value="6" label="70+">70+</option>';
            echo '</select><br>';

            //heard
            echo '<label for="addDonorHeard">Heard about us through:</label><br>';
            echo '<select id="addDonorHeard" name="addDonorHeard">';
            echo '<option value="" label=""></option>';
            echo '<option value="1" label="Church">Church</option>';
            echo '<option value="2" label="Friends">Friends</option>';            
            echo '<option value="3" label="Online">Online</option>';
            echo '<option value="4" label="Newspaper">Newspaper</option>';
            echo '<option value="5" label="Other">Other</option>';
            echo '</select><br>' ;
      
            //street
            echo '<label for="addDonorStreet">Street:</label><br>';
            echo '<input type="text" id="addDonorStreet" name="addDonorStreet" onkeyup="autofill_input(this.getAttribute("Id"),potentialDonors)" placeholder="Enter Street..." list="potentialDonors" maxlength="80"><br>';

              echo '<datalist id="potentialDonors">';
                //create query for potential donors
                $sql = "SELECT name, street FROM Donor";

                //X debug
                //echo $sql;

                //run the query
                $res = $conn->query($sql);
                while ($row = $res->fetch_assoc()) {
                  echo '<option value="'.$row["street"].'" label="'.$row["name"].'"></option>';
                }
                echo '</datalist>';

            //city
            echo '<label for="addDonorCity">City:</label><br>';
            echo '<input type="text" id="addDonorCity" name="addDonorCity" onkeyup="autofill_input(this.getAttribute("Id"),potentialDonors)" placeholder="Enter City Name ..." list="potentialDonors" maxlength="50"><br>';

            echo '<datalist id="potentialDonors">';
                //create query for potential donors
                $sql = "SELECT name, city, state FROM Donor";

                //X debug
                //echo $sql;

                //run the query
                $res = $conn->query($sql);
                while ($row = $res->fetch_assoc()) {
                  echo '<option value="'.$row["city"].'" label="'.$row["name"].'\n'.$row["city"].'"></option>';
                }
                echo '</datalist>';

            //state
            echo '<label for="addDonorState">State:</label><br>';
            echo '<input type="text" id="addDonorState" name="addDonorState" onkeyup="autofill_input(this.getAttribute("Id"),potentialDonors)" placeholder="Enter State Abreviation ..." list="potentialDonors" maxlength="2"><br>';

            echo '<datalist id="potentialDonors">';
                //create query for potential donors
                $sql = "SELECT name, city, state FROM Donor";

                //X debug
                //echo $sql;

                //run the query
                $res = $conn->query($sql);
                while ($row = $res->fetch_assoc()) {
                  echo '<option value="'.$row["state"].'" label="'.$row["name"].'\n'.$row["city"].'"></option>';
                }
                echo '</datalist>';
            //zip
            echo '<label for="addDonorZip">Zipcode:</label><br>';
            echo '<input type="number" id="addDonorZip" name="addDonorZip" onkeyup="autofill_input(this.getAttribute("Id"),potentialDonors)" placeholder="Enter Zipcode..." list="potentialDonors" maxlength="10"><br>';
          
            echo '<datalist id="potentialDonors">';
                //create query for potential donors
                $sql = "SELECT phone, zip FROM Donor";

                //X debug
                //echo $sql;

                //run the query
                $res = $conn->query($sql);
                while ($row = $res->fetch_assoc()) {
                  echo '<option value="'.$row["zip"].'" label="'.$row["phone"].'"></option>';
                }
                echo '</datalist>';

            //important
            echo '<label for="addDonorIP">Flag Important</label>';
            echo '<input type="checkbox" id="addDonorIP" name="addDonorIP" onclick="check_vip()" value=""><br>';
            
            //notes
            $formatnotes = str_ireplace(array("<br />","<br>","<br/>","<br />","&lt;br /&gt;","&lt;br/&gt;","&lt;br&gt;"),"\n",$ddata["notes"]);
            echo '<label for="addDonorNotes">DONOR NOTES</label><br>';          
            echo '<textarea class="notes" id="addDonorNotes" name="addDonorNotes" rows="20" cols="30" placeholder="Enter Special Pickup instructions or directions..." maxlength="255">'.$formatnotes.'</textarea><br>';
          
          echo '</fieldset>';
        echo '</div>';  
      //If NO
      } else if (isset($_GET["submitChooseNoBtn"])) {
        
        //Anonymous information
        //name
        echo '<label for="addDonorName">*Name: Anonymous</label><br>';
        echo '<input type="hidden" id="donName" name="donName" value="Anonymous" maxlength="25"><br>';
      
        //phone
        echo '<input type="hidden" id="donPhone" name="donPhone" value="0000000000" pattern="[0-9]{10}" maxlength="20"><br>';
      }
    //If ocode IS set
    } else {
      //Beginning of the Donation form
      echo '<form class="addForm-input" action="addDonationForm.php" name="addDonationForm" method="get">';
    }
    
    if(isset($_GET["ocode"])) {
      echo '<input type="hidden" name="ocode" value="'.$_GET["ocode"].'">';
    }

    //Donation Form
    if(isset($_GET["submitContinueDonationForm"]) || isset($_GET["submitChooseNoBtn"])) {
      
      echo '<fieldset class="info">';
      echo '<legend>New Donation Information</legend><br>';
    } else if(isset($_GET["ocode"])) {
        if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
          echo '<fieldset class="info" disabled>';
          echo '<legend>Donation Information</legend><br>';
        } else {
          echo '<fieldset class="info">';
          echo '<legend>Donation Information</legend><br>';
        }
    }

    // If displaying a pickup order
    if($isPickup == TRUE) {
      if (isset($_GET["submitContinueDonationForm"]) || isset($_GET["submitChooseNoBtn"]) || isset($_GET["ocode"])) {
        
        //info
        if(isset($_GET["ocode"])) {
          
          //name
          echo '<label for="requestName">Name</label><br>';
          echo '<input type="text" id="donName" name="donName" value="'.$odata["name"].'" placeholder="Enter Donor Name..." list="potentialDonors" maxlength="25" required><br>';
          
          //phone  
          echo '<label for="requestPhone">Phone</label><br>';
          echo '<input type="tel" id="donPhone" name="donPhone" value="'.$odata["phone"].'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialPhone" maxlength="20" required><br>';
        } 

        //times of scheduling
        echo '<br><label> Time log: </label><br>';
        if($odata["status"] == Requested || Scheduled || Pickedup || Completed) {
          $date =  date("Y-m-d", strtotime($odata["RequestedDateTime"]));
          $time =  date("H:i", strtotime($odata["RequestedDateTime"]));
          echo 'Time Requested:  <input class="dateTime" type="date" name="rDate" value="'.$date.'">';
          echo ', <input class="dateTime" type="time" name="rTime" value="'.$time.'"><br>';
        } 
        if($odata["status"] == Scheduled || Pickedup || Completed) {
          $date =  date("Y-m-d", strtotime($odata["ScheduleDateTime"]));
          $time =  date("H:i", strtotime($odata["ScheduleDateTime"]));
          echo 'Time Scheduled: <input class="dateTime" type="date" name="sDate" value="'.$date.'">';
          echo ', <input class="dateTime" type="time" name="sTime" value="'.$time.'"><br>';
        } 
        if($odata["status"] == Pickedup || Completed) {
          $date =  date("Y-m-d", strtotime($odata["PickupDateTime"]));
          $time =  date("H:i", strtotime($odata["PickupDateTime"]));
          echo 'Time Picked up: <input class="dateTime" type="date" name="pDate" value="'.$date.'">';
          echo ', <input class="dateTime" type="time" name="pTime" value="'.$time.'"><br>';
        } 
        if($odata["status"] == Completed) {
          $date =  date("Y-m-d", strtotime($odata["DropOffDateTime"]));
          $time =  date("H:i", strtotime($odata["DropOffDateTime"]));
          echo 'Time Completed: <input class="dateTime" type="date" name="dDate" value="'.$date.'">';
          echo ', <input class="dateTime" type="time" name="dTime" value="'.$time.'"><br>';
        } 
        if($odata["status"] == Cancelled) {
          $date =  date("Y-m-d", strtotime($odata["CancelledDateTime"]));
          $time =  date("H:i", strtotime($odata["CancelledDateTime"]));
          echo 'Time Cancelled: <input class="dateTime" type="date" name="cDate" value="'.$date.'">';
          echo ', <input class="dateTime" type="time" name="cTime" value="'.$time.'"><br>';
        }
        
        //notes
        echo '<br><label for="requestNotes">PICKUP NOTES</label><br>';
        echo '<textarea class="notes" id="requestNotes" name="requestNotes" rows="20" cols="30"  placeholder="Enter Special Pickup instructions or directions..." maxlength="255">'.$odata["notes"].'</textarea><br><hr>';
      }
    }
    // If a Dropoff order
    if($isPickup == FALSE) {
      if(isset($_GET["submitContinueDonationForm"]) || isset($_GET["submitChooseNoBtn"]) || isset($_GET["ocode"])) {
        
        //info
        if(isset($_GET["ocode"])) {
          
          //name
          echo '<label for="requestName">Name</label><br>';
          echo '<input type="text" id="donName" name="donName" value="'.$odata["name"].'" placeholder="Enter Donor Name..." list="potentialDonors" maxlength="25" required><br>';
          
          //phone  
          echo '<label for="requestPhone">Phone</label><br>';
          echo '<input type="tel" id="donPhone" name="donPhone" value="'.$odata["phone"].'" placeholder="Enter as: 8651234567" pattern="[0-9]{10}" list="potentialPhone" maxlength="20" required><br>';
         

          //time of dropoff
          $date =  date("Y-m-d", strtotime($odata["whenDonated"]));
          $time =  date("H:i", strtotime($odata["whenDonated"]));
          echo '<br>Donated on: <input class="dateTime" type="date" name="wDate" value="'.$date.'">';
          echo ', <input class="dateTime" type="time" name="wTime" value="'.$time.'"><br>';
        }
        //notes
        echo '<br><label for="requestNotes">Donation NOTES</label><br>';
        echo '<textarea class="notes" id="requestNotes" name="requestNotes" rows="20" cols="30"  placeholder="Enter Special donation notes..." maxlength="255">'.$odata["notes"].'</textarea><br>';

      }
    }

    // For all donations
    if(isset($_GET["submitContinueDonationForm"]) || isset($_GET["submitChooseNoBtn"]) || isset($_GET["ocode"])) {

      //total numItems
      if (isset($_GET["ocode"])){ 
        if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
          echo '<br><label for="numTotalItems"># Total Items</label><br>';
          echo '<input type="number" id="numTotalItems" name="requestTotalItems" min="0" step="1" value="'.$odata["qty"].'" disabled><br>';
        } else {
          echo '<label for="numTotalItems"># Total Items</label><br>';
          echo '<input type="number" id="numTotalItems" name="requestTotalItems" min="0" step="1" value="'.$odata["qty"].'"><br>';
        }
      } else {
        echo '<label for="numTotalItems"># Total Items</label><br>';
        echo '<input type="number" id="numTotalItems" name="requestTotalItems" min="0" step="1" value="'.$odata["qty"].'"><br>';
      }

      //Categories
      echo '<br><label>Categories:</label><br>';
      if($odata["isDecor"] == 1) {
        echo '<input type="checkbox" id="requestIsDecor" name="requestIsDecor" checked>';
        echo '<label for="requestIsDecor">Decor</label><br>';
      } else {
        echo '<input type="checkbox" id="requestIsDecor" name="requestIsDecor">';
        echo '<label for="requestIsDecor">Decor</label><br>';
      }
      if($odata["isFurniture"] == 1) {
        echo '<input type="checkbox" id="requestIsFurniture" name="requestIsFurniture" checked>';
        echo '<label for="requestIsFurniture">Furniture</label><br>';
      } else {
        echo '<input type="checkbox" id="requestIsFurniture" name="requestIsFurniture">';
        echo '<label for="requestIsFurniture">Furniture</label><br>';
      }
      if($odata["isKitchen"] == 1) {
        echo '<input type="checkbox" id="requestIsKitchen" name="requestIsKitchen" checked>';
        echo '<label for="requestIsKitchen">Kitchen</label><br>';
      } else {
        echo '<input type="checkbox" id="requestIsKitchen" name="requestIsKitchen">';
        echo '<label for="requestIsKitchen">Kitchen</label><br>';
      }
      if($odata["isEntertainment"] == 1) {
        echo '<input type="checkbox" id="requestIsEntertainment" name="requestIsEntertainment" checked>';
        echo '<label for="requestIsEntertainment">Entertainment</label><br>';
      } else {
        echo '<input type="checkbox" id="requestIsEntertainment" name="requestIsEntertainment">';
        echo '<label for="requestIsEntertainment">Entertainment</label><br>';
      }
      if($odata["isOutdoor"] == 1) {
        echo '<input type="checkbox" id="requestIsOutdoor" name="requestIsOutdoor" checked>';
        echo '<label for="requestIsOutdoor">Outdoor</label><br>';
      } else {
        echo '<input type="checkbox" id="requestIsOutdoor" name="requestIsOutdoor">';
        echo '<label for="requestIsOutdoor">Outdoor</label><br>';
      }
      if($odata["isMisc"] == 1) {
        echo '<input type="checkbox" id="requestIsMisc" name="requestIsMisc" checked>';
        echo '<label for="requestIsMisc">Misc</label><br>';
      } else {
        echo '<input type="checkbox" id="requestIsMisc" name="requestIsMisc">';
        echo '<label for="requestIsMisc">Misc</label><br>';
      }
      
      //receipt
      echo '<br><label> Reciept: </label>';
      if(isset($_GET["ocode"])) {
        if($odata["receipt"] == 1) {
          echo '<input type="radio" id="yes" name="receipt" value="1" required checked>';
          echo '<label for="yes">Yes </label>';
          echo '<input type="radio" id="no" name="receipt" value="0" required>';
          echo '<label for="no">No </label>'; 
        } else if($odata["receipt"] == 0) {
          echo '<input type="radio" id="yes" name="receipt" value="1" required>';
          echo '<label for="yes">Yes </label>';
          echo '<input type="radio" id="no" name="receipt" value="0" required checked>';
          echo '<label for="no">No </label>';
        } 
      } else {
        echo '<input type="radio" id="yes" name="receipt" value="1" required>';
        echo '<label for="yes">Yes </label>';
        echo '<input type="radio" id="no" name="receipt" value="0" required>';
        echo '<label for="no">No </label>'; 
      }
      
      //Destination
      echo '<br><br><label> Destination: </label>';
      if($odata["destination"] == 1) {
        echo '<input type="radio" id="store" name="destination" value="2" required>';
        echo '<label for="store">Store </label>';
        echo '<input type="radio" id="warehouse" name="destination" value="1" required checked>';
        echo '<label for="warehouse">Warehouse </label>'; 
      } else if($odata["destination"] == 2){
        echo '<input type="radio" id="store" name="destination" value="2" required checked>';
        echo '<label for="store">Store </label>';
        echo '<input type="radio" id="warehouse" name="destination" value="1" required>';
        echo '<label for="warehouse">Warehouse </label>'; 
      } else {
        echo '<input type="radio" id="store" name="destination" value="2" required>';
        echo '<label for="store">Store </label>';
        echo '<input type="radio" id="warehouse" name="destination" value="1" required>';
        echo '<label for="warehouse">Warehouse </label>'; 
      }

      if (isset($_GET["ocode"])){         
        //Employee
        echo '<br><br><label for="requestEmpName">Representative Name:</label><br>';
        echo '<input type="text" id="donEmpName" name="donEmpName" value="'.$odata["fname"].' '.$odata["lname"].'"><br>';
        
      }
      
    }

    //named submit button Submitting for editing a donation
    if (isset($_GET["ocode"])){
      if($isPickup) {
        //Admin & Employee
        if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
          
        } else {
          echo '<input type="submit" class="stickySubmit" value="Update pick up donation" name="submitEditPDonationForm">';
        }
      } else {
        //Admin & Employee
        if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
          
        } else {
          echo '<input type="submit" class="stickySubmit" value="Update drop off donation" name="submitEditDDonationForm">';
        }
      }  
    //named submit button for ADDING a donation
    } else if(isset($_GET["submitContinueDonationForm"]) || isset($_GET["submitChooseNoBtn"])){
      
      echo '<input type="submit" class="stickySubmit" value="Add Donation" name="submitAddDonationForm">';
    }
    echo '</fieldset>';
    echo '</form>';
    
    ?>
  </div>
</section>


</body>
</html>