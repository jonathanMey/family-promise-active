<?php
//Page setup
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';
//$addDonor;
//ACTION: Submit EDIT donation form TODO 
if (isset($_GET["submitEditDonationForm"])){
  //$combinedDT = date('Y-m-d H:i:s', strtotime($_GET["cdate"]." ".$_GET["ctime"]));
  
  //echo $_GET["addDonorIP"];

  $sql = "UPDATE Donor
  SET name=CASE WHEN '".$_GET["addDonorName"]."' = '' THEN NULL ELSE '".$_GET["addDonorName"]."' END,
  email=CASE WHEN '".$_GET["addDonorEmail"]."' = '' THEN NULL ELSE '".$_GET["addDonorEmail"]."' END,
  phone=CASE WHEN '".$_GET["addDonorPhone"]."' = '' THEN NULL ELSE '".$_GET["addDonorPhone"]."' END,
  gender=CASE WHEN '".$_GET["addDonorGender"]."' = '' THEN NULL ELSE '".$_GET["addDonorGender"]."' END,
  age_group=CASE WHEN '".$_GET["addDonorAge"]."' = '' THEN NULL ELSE '".$_GET["addDonorAge"]."' END,
  street=CASE WHEN '".$_GET["addDonorStreet"]."' = '' THEN NULL ELSE '".$_GET["addDonorStreet"]."' END,
  city=CASE WHEN '".$_GET["addDonorCity"]."' = '' THEN NULL ELSE '".$_GET["addDonorCity"]."' END,
  state=CASE WHEN '".$_GET["addDonorState"]."' = '' THEN NULL ELSE '".$_GET["addDonorState"]."' END,
  zip=CASE WHEN '".$_GET["addDonorZip"]."' = '' THEN NULL ELSE '".$_GET["addDonorZip"]."' END,
  heard=CASE WHEN '".$_GET["addDonorHeard"]."' = '' THEN NULL ELSE '".$_GET["addDonorHeard"]."' END,
  Vip=CASE WHEN '".$_GET["addDonorIP"]."' = '' THEN NULL ELSE '".$_GET["addDonorIP"]."' END,
  notes='".str_replace("'","''",$_GET["addDonorNotes"])."'
  WHERE DonorID=".$_GET["dcode"]."";
  //X debug   
  //echo $sql;

  $conn->query($sql);
}

//ACTION: submit ADD donor page TODO
if(isset($_GET["submitAddDonorForm"])){  
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
  //echo $sql;

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
  echo $dtype;

  $row = $res->fetch_assoc();

  //If Pickup Donation
  if ($row["PickID"] == NULL) {

    $sql = "SELECT i.*, p.status, r.name, r.phone, e.fname, e.lname, e.role FROM DonDetails o, Employee e, Pick p, PickInfo i, Don d, Donor r WHERE d.DonID ='".$_GET["ocode"]."' AND p.PickinfoID = i.PickInfoID AND d.PickID = p.PickID AND d.DonorInfoID = r.DonorID AND d.DonDetailsID = o.DonDetailsID AND d.EmpID = e.Employeeid";
    
    $isPickup = TRUE;
  
  //If Dropoff Donation
  } else {

    $sql = "SELECT i.*, p.status, r.name, r.phone, e.fname, e.lname, e.role FROM DonDetails o, Employee e, Pick p, PickInfo i, Don d, Donor r WHERE d.DonID ='".$_GET["ocode"]."' AND p.PickinfoID = i.PickInfoID AND d.PickID = p.PickID AND d.DonorInfoID = r.DonorID AND d.DonDetailsID = o.DonDetailsID AND d.EmpID = e.Employeeid";

    $isPickup = FALSE;
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
      echo '</form>';

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
      if($donorFound == TRUE && isset($_GET["submitContinueDonationForm"])) {
        $existingDonorID = $row["DonorID"];
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
                  echo '<option value="'.$row["city"].'" label="'.$row["name"].'\n'.$row["state"].'"></option>';
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
        echo '<label for="addDonorName">*Name:</label><br>';
        echo '<input type="hidden" id="addDonorName" name="addDonorName" value="Anonymous" maxlength="25"><br>';
      
        //phone
        echo '<label for="addDonorPhone">*Phone Number:</label><br>';
        echo '<input type="hidden" id="addDonorPhone" name="addDonorPhone" value="0000000000" pattern="[0-9]{10}" maxlength="20"><br>';
      }
    //If ocode IS set
    } else {

      //Beginning of the Donation form
      echo '<form class="addForm-input" action="addDonationForm.php" name="addDonationForm" method="get">';
    }
    
    //Donation Form
    if($isPickup == FALSE) {
      
    }

    //named submit button Submitting
    if (isset($_GET["dcode"])){
      //Admin & Employee
      if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
        
      } else {
        echo '<input type="submit" class="stickySubmit" value="Update '.$ddata["name"].'" name="submitEditDonorForm">';
      }    
    }
    else{
      //named submit button for ADDING a donor
      echo '<input type="submit" class="stickySubmit" value="Add Donor" name="submitAddDonorForm">';
    }
    
    echo '</form>';
    
    ?>
  </div>
</section>


</body>
</html>