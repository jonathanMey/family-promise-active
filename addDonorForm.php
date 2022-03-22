<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

if (isset($_GET["submitEditDonorForm"])){
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
  //debug   
  //echo $sql;
  $conn->query($sql);
}


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
   
    //debug   
    //echo $sql;

    $conn->query($sql);
  }


if(isset($_GET["dcode"])) {
  $sql = "SELECT * FROM Donor WHERE DonorID='".$_GET["dcode"]."'";
  // select data about the country from the country table
  $res = $conn->query($sql);
  
  //debug 
  //echo $sql;

  // call it $cdata instead of $row to help distinguish it from the results of other queries you will be running to generate the form	
  $ddata = $res->fetch_assoc();
}
?>


<section class="addForm-section">
  <form class="add-form" action="addDonorForm.php" name="addDonorForm" method="get">
    <div class="addForm-header">
      <img class="addFormHeader-logo" src="Images/horizontalLogo.png" alt="Family Promise Logo">
      <h2>DONOR INFORMATION FORM</h2>
      <hr>
    </div>

    
    <div class="addForm-input">

    
    
      <?php

      if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
        echo '<fieldset class="info" name="DonorInfo" disabled>';
      } else {
        echo '<fieldset class="info" name="DonorInfo">';
      }
      if (isset($_GET["dcode"])){ 	
      echo '<input type="hidden" name="dcode" value="'.$_GET["dcode"].'">';
      }
      ?>
      
      <?php
        
        if(isset($_GET["dcode"])) {
          echo '<legend>' .$ddata["name"].' information</legend>';
        } else {
          echo '<legend>New Donor information</legend>';
        }
        //name
        echo '<label for="addDonorName">Name:</label><br>';
        echo '<input type="text" id="addDonorName" onkeyup="autofill_input(this.getAttribute("Id"),document.getElementById("potentialDonorNames").Id))" name="addDonorName" value="'.$ddata["name"].'" placeholder="FirstName LastName..." list="potentialDonorNames" maxlength="25"><br>';
        
        echo '<datalist id="potentialDonorNames">';
            //create query for potential donors
            $sql = "SELECT name FROM Donor";

            //debug
            //echo $sql;

            //run the query
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
              echo '<option value="'.$row["name"].'"></option>';
            }
          echo '</datalist>';
        
        //email
        echo '<label for="addDonorEmail">Email Address:</label><br>';
        echo '<input type="email" id="addDonorEmail" onkeyup="autofill_input(this.getAttribute("Id"),document.getElementById("potentialDonorsEmail").Id))" name="addDonorEmail" value="'.$ddata["email"].'" placeholder="johndoe@gmail.com..." list="potentialDonorsEmail" maxlength="50"><br>';
        
          echo '<datalist id="potentialDonorsEmail">';
            //create query for potential donors
            $sql = "SELECT email, name FROM Donor";

            //debug
            //echo $sql;

            //run the query
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
              echo '<option value="'.$row["email"].'" label="'.$row["name"].'"></option>';
            }
          echo '</datalist>';

        //phone
        echo '<label for="addDonorPhone">Phone Number:</label><br>';
        echo '<input type="tel" id="addDonorPhone" onkeyup="autofill_input(this.getAttribute("Id"),document.getElementById("potentialDonorsPhone").Id))" name="addDonorPhone" value="'.$ddata["phone"].'" placeholder="Enter as: 865-123-4567" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" list="potentialDonorsPhone" maxlength="20"><br>';
        
          echo '<datalist id="potentialDonorsPhone">';
            //create query for potential donors
            $sql = "SELECT name, phone FROM Donor";

            //debug
            //echo $sql;

            //run the query
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
              echo '<option value="'.$row["phone"].'" label="'.$row["name"].'"></option>';
            }
            echo '</datalist>';

        // gender
        
          if($ddata['gender'] == 'M') {
            echo '<label for="addDonorMale">Male:</label>';
            echo '<input type="radio" id="addDonorMale" name="addDonorGender" value="M" checked><br>';
            } else {
            echo '<label for="addDonorMale">Male:</label>';
            echo '<input type="radio" id="addDonorMale" name="addDonorGender" value="M"><br>'; 
            }
            if($ddata['gender'] == 'F') {
              echo '<label for="addDonorFemale">Female:</label>';
              echo '<input type="radio" id="addDonorMale" name="addDonorGender" value="F" checked><br>';
              } else {
              echo '<label for="addDonorFemale">Female:</label>';
              echo '<input type="radio" id="addDonorFemale" name="addDonorGender" value="F"><br>'; 
            }

          //age group
          echo '<label for="addDonorAge">Age group:</label><br>';
          echo '<select id="addDonorAge" name="addDonorAge">';
          if($ddata['age_group'] == '') {
          echo '<option value="" label="" selected></option>';
          } else {
            echo '<option value="" label=""></option>';
          }
          if($ddata['age_group'] == 1) {
          echo '<option value="1" label="0-20" selected></option>';
          } else {
            echo '<option value="1" label="0-20"></option>';
          }
          if($ddata['age_group'] == 2) {
          echo '<option value="2" label="20-30" selected></option>';
          } else {
          echo '<option value="2" label="20-30"></option>';
          }
          if($ddata['age_group'] == 3) {
          echo '<option value="3" label="30-40" selected></option>';
          } else {
          echo '<option value="3" label="30-40"></option>';
          } 
          if($ddata['age_group'] == 4) {
          echo '<option value="4" label="40-60" selected></option>';
          } else {
          echo '<option value="4" label="40-60"></option>';
          }
          if($ddata['age_group'] == 5) {
          echo '<option value="5" label="60-70" selected></option>';
          } else {
          echo '<option value="5" label="60-70"></option>';
          } 
          if($ddata['age_group'] == 6) {
          echo '<option value="6" label="70+" selected></option>';
          } else {
          echo '<option value="6" label="70+"></option>';
          }
          echo '</select><br>';

          //heard
          echo '<label for="addDonorHeard">Heard about us through:</label><br>';
          echo '<select id="addDonorHeard" name="addDonorHeard">';
          if($ddata['heard'] == '') {
          echo '<option value="" label="" selected></option>';
          } else {
            echo '<option value="" label=""></option>';
          }
          if($ddata['heard'] == 1) {
          echo '<option value="1" label="Church" selected></option>';
          } else {
            echo '<option value="1" label="Church"></option>';
          }
          if($ddata['heard'] == 2) {
          echo '<option value="2" label="Friends" selected></option>';
          } else {
          echo '<option value="2" label="Friends"></option>';
          }
          if($ddata['heard'] == 3) {
          echo '<option value="3" label="Online" selected></option>';
          } else {
          echo '<option value="3" label="Online"></option>';
          } 
          if($ddata['heard'] == 4) {
          echo '<option value="4" label="Newspaper" selected></option>';
          } else {
          echo '<option value="4" label="Newspaper"></option>';
          }
          if($ddata['heard'] == 5) {
          echo '<option value="5" label="Other" selected></option>';
          } else {
          echo '<option value="5" label="Other"></option>';
          }
          echo '</select><br>' ;
   
        echo '<label for="addDonorStreet">Street:</label><br>';
        echo '<input type="text" id="addDonorStreet" name="addDonorStreet" onkeyup="autofill_input(this.getAttribute("Id"),potentialDonors)" value="'.$ddata["street"].'" placeholder="Enter Street..." list="potentialDonors" maxlength="80"><br>';

           echo '<datalist id="potentialDonors">';
            //create query for potential donors
            $sql = "SELECT name, street FROM Donor";

            //debug
            //echo $sql;

            //run the query
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
              echo '<option value="'.$row["street"].'" label="'.$row["name"].'"></option>';
            }
            echo '</datalist>';

        echo '<label for="addDonorZip">Zipcode:</label><br>';
        echo '<input type="number" id="addDonorZip" name="addDonorZip" onkeyup="autofill_input(this.getAttribute("Id"),potentialDonors)" value="'.$ddata["zip"].'" placeholder="Enter Zipcode..." list="potentialDonors" maxlength="10"><br>';
       
        echo '<datalist id="potentialDonors">';
            //create query for potential donors
            $sql = "SELECT phone, zip FROM Donor";

            //debug
            //echo $sql;

            //run the query
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
              echo '<option value="'.$row["zip"].'" label="'.$row["phone"].'"></option>';
            }
            echo '</datalist>';

        echo '<label for="addDonorState">State:</label><br>';
        echo '<input type="text" id="addDonorState" name="addDonorState" onkeyup="autofill_input(this.getAttribute("Id"),potentialDonors)" value="'.$ddata["state"].'" placeholder="Enter State Abreviation ..." list="potentialDonors" maxlength="2"><br>';

        echo '<datalist id="potentialDonors">';
            //create query for potential donors
            $sql = "SELECT name, state FROM Donor";

            //debug
            //echo $sql;

            //run the query
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
              echo '<option value="'.$row["state"].'" label="'.$row["name"].'"></option>';
            }
            echo '</datalist>';
            
            //important
            echo '<label for="addDonorIP">Flag Inportant</label>';
            if($ddata["Vip"] == 1) {
            echo '<input type="checkbox" id="addDonorIP" name="addDonorIP" onclick="check_vip()" value="1" checked><br>';
            } else if($ddata["Vip"] == 0) {
            echo '<input type="checkbox" id="addDonorIP" name="addDonorIP" onclick="check_vip()" value="0"><br>';
            } else {
            echo '<input type="checkbox" id="addDonorIP" name="addDonorIP" onclick="check_vip()" value=""><br>';
            }


            //notes
            $formatnotes = str_ireplace(array("<br />","<br>","<br/>","<br />","&lt;br /&gt;","&lt;br/&gt;","&lt;br&gt;"),"\n",$ddata["notes"]);
            echo '<label for="addDonorNotes">DONOR NOTES</label><br>';          
            echo '<textarea class="notes" id="addDonorNotes" name="addDonorNotes" rows="20" cols="30" placeholder="Enter Special Pickup instructions or directions..." maxlength="255">'.$formatnotes.'</textarea><br>';
      
      
           echo '</fieldset>';
      ?>
      
      
      <?php



    //named submit button so we can tell when the form has been submitted

    if (isset($_GET["dcode"])){
      if($_SESSION['Accesslvl'] == 4 || $_SESSION['Accesslvl'] == 2 ) {
        
      } else {
        echo '<input type="submit" class="stickySubmit" value="Update '.$ddata["name"].'" name="submitEditDonorForm">';
      }    
    }
    else{
      //named submit button so we can tell when the form has been submitted
      echo '<input type="submit" class="stickySubmit" value="Add Donor" name="submitAddDonorForm">';
    }
    ?>
  </form>
</section>


</body>
</html>