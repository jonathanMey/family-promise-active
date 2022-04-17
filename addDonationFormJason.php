<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

$sql = "SELECT username,Employeeid FROM Employee WHERE username = '".$_SESSION['Username']."'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);
$chosenEmp = $row['Employeeid'];

$sql = "SELECT Count(*),DonorID FROM Donor WHERE name = '".$_GET["addDonorName"]."' OR phone = '"._GET["addDonorPhone"]."' OR email = '"._GET["addDonorEmail"]."' OR street = '"._GET["addDonorStreet"]."'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_BOTH);

$count = $row['Count(*)'];
$chosendonor = $row['DonorID'];

?>

<div class="addDonation-body">
  <section class="form-section">
     <form class="addDonation-form" action="addDonationForm.php">
      <div class="form-header">
      <img class="addFormHeader-logo" src="Images/horizontalLogo.png" alt="Family Promise Logo">
     <h2>ADD Donation FORM</h2>
     <hr>
   </div>	

<div class="form-input">

<div id="checkdonor">
<fieldset id="checkfordonor">
<legend> Add First Time Donor? </legend>
<div id="donoryes" onclick="donorCheck(this);"> Yes </div>
<div id="donorno" onclick="donorCheck(this);"> Not now </div>
<div id="donoradded">Donor has been added</div>
</fieldset>
</div>


<div id="addDonationcInfo">
<section class="addForm-section">
  <form class="add-form" action="addDonorForm.php" name="addDonorForm" method="get">
    <div class="addForm-header">
      <h2>DONOR INFORMATION FORM</h2>
      <hr>
    </div>

    <div class="addForm-input">
    <fieldset class="info" name="DonorInfo">
      <?php
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
        echo '<input type="text" id="addDonorName" onkeyup="autofill_input(this.getAttribute("Id"),document.getElementById("potentialDonorsName"))" name="addDonorName" value="'.$ddata["name"].'" placeholder="FirstName LastName..." list="potentialDonorsName" maxlength="25"><br>';
        
        echo '<datalist id="potentialDonorNames">';
            //create query for potential donors
            $sql = "SELECT name, phone FROM Donor";

            //debug
            //echo $sql;

            //run the query
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
            echo '<option value="'.$row["name"].'" label="'.$row["phone"].'"></option>';
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
        echo '<input type="tel" id="addDonorPhone" onkeyup="autofill_input(this.getAttribute("Id"),document.getElementById("potentialDonorsPhone")" name="addDonorPhone" value="'.$ddata["phone"].'" placeholder="Enter as: 865-123-4567" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" list="potentialDonorsPhone" maxlength="20"><br>';
        
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
            $sql = "SELECT name, zip FROM Donor";

            //debug
            //echo $sql;

            //run the query
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
              echo '<option value="'.$row["zip"].'" label="'.$row["name"].'"></option>';
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
            echo '<label for="addDonorIP">Flag Important</label>';
            if($ddata['Vip' == 1]) {
            echo '<input type="checkbox" id="addDonorIP" name="addDonorIP" value="1" checked><br>';
            } else {
            echo '<input type="checkbox" id="addDonorIP" name="addDonorIP" value="0"><br>';
            }

            //notes
            $formatnotes = str_ireplace(array("<br />","<br>","<br/>","<br />","&lt;br /&gt;","&lt;br/&gt;","&lt;br&gt;"),"\n",$ddata["notes"]);
            echo '<label for="requestNotes">DONOR NOTES</label><br>';          
            echo '<textarea class="notes" id="addDonorNotes" name="addDonorNotes" rows="20" cols="30" placeholder="Enter Special Pickup instructions or directions..." maxlength="255">'.$formatnotes.'</textarea><br>';

      ?>

<?php
       echo '<input type="submit" onclick="hide(this);" class="stickySubmit" value="Add Donor" name="submitAddDonorForm">';
?>

</fieldset>
</form>
</section>
</div>
</form>
</section>
</div>


<div class="addDonation-body">
  <section class="form-section">
     <form class="addDonation-form" action="addDonationForm.php" name="submitRequestForm" method="get">
      <div class="form-header">
        <div class="time-container">
           <h3 class="itemDonated">Time of Donation:</h3>
	   <?php 
        echo 'Date: <input class="dateTime" type="date" name="whenDonatedDate" value="'.date('Y-m-d').'"><br>';
        echo 'Time: <input class="dateTime" type="time" name="whenDonatedTime" value="'.date('H:i').'">'; 
        ?>

        </div>
     <h2>ADD Donation FORM cont.</h2>
     <hr>
   </div>	
<div class="form-input">

<fieldset class="numItemsForm">
        <legend>Item Categories</legend>
	<div id= "Decor" onclick="showIt(this);"> Decor </div>
   	<div id= "Furniture" onclick="showIt(this);"> Furniture </div>
   	<div id= "Kitchen" onclick="showIt(this);"> Kitchen </div>
   	<div id= "Entertainment" onclick="showIt(this);"> Entertainment </div>
   	<div id= "Outdoor" onclick="showIt(this);"> Outdoor </div>
   	<div id= "Misc" onclick="showIt(this);"> Misc </div>
</fieldset>

<fieldset id = "Decorcont">
	<label for="decoramnt">Decor Amount:</label><br>
	<input type = "number" id="dreq" class="amount" name="decoramnt"><br>

	<label for= "decornotes">Notes:</label><br>
	<input type = "text" class="notes" maxlength = "255" name="decornotes">
</fieldset>

<fieldset id= "Furniturecont">
	<label for="furnitureamnt">Furniture Amount:</label><br>
	<input type = "number" id="freq" class="amount" name="furnitureamnt"><br>

	<label for= "furniturenotes">Notes:</label><br>
	<input type = "text" class="notes" maxlength = "255" name="furniturenotes">

</fieldset>

<fieldset id= "Kitchencont">
	<label for="kitchenamnt">Kitchen Amount:</label><br>
	<input type = "number" id="kreq" class="amount" name="kitchenamnt"><br>

	<label for= "kitchennotes">Notes:</label><br>
	<input type = "text" class="notes" maxlength = "255" name="kitchennotes">
</fieldset>

<fieldset id= "Entertainmentcont">
	<label for="entertainmentamnt">Entertainment Amount:</label><br>
	<input type = "number" id="ereq" class="amount" name="entertainmentamnt"><br>
	<label for= "entertainmentnotes">Notes:</label><br>
	<input type = "text" class="notes" maxlength = "255" name="entertainmentnotes">
</fieldset>

<fieldset id= "Outdoorcont">
	<label for="outdooramnt">Outdoor Amount:</label><br>
	<input type = "number" id="oreq" class="amount" name="outdooramnt"><br>
	<label for= "outdoornotes">Notes:</label><br>
	<input type = "text" maxlength = "255" class="notes" name="outdoornotes">
</fieldset>

<fieldset id= "Misccont">
	<label for="miscamnt">Misc Amount:</label><br>
	<input type = "number" id="mreq" class="amount" name="miscamnt"><br>
	<label for= "miscnotes">Notes:</label><br>
	<input type = "text" maxlength = "255" class="notes" name="miscnotes">
</fieldset>

<div id="dest">
<fieldset class="PriorityForm">
        <legend>Destination</legend>
        <label for="Destination">Store</label>
        <input type="radio" id="Destination" name="Destination" value="2"><br>
        <label for="Destination">Warehouse</label>
        <input type="radio" id="Destination" name="Destination" value="1"><br>
        </fieldset>
</div>
<div id="receit">
<fieldset class="PriorityForm">
        <legend>Receipt?</legend>
        <label for="receipt">Yes</label>
        <input type="radio" id="receipt" name="receipt" value="1" required><br>
        <label for="receipt">No</label>
        <input type="radio" id="receipt" name="receipt" value="0"><br>
        </fieldset>
</div>
      <input type="submit" id= "recDon" onclick="checkSub(this);" value="Record Donation" name="submitRequestForm">

      </div>
      </form>
    </section>

</div>

<!-- Once the items are selected put those down below to add quantity and notes -->
<!-- Probably js -->


<script>
var Decor = new Boolean(false);
var Furniture = new Boolean(false);
var Kitchen = new Boolean(false);
var Entertainment = new Boolean(false);
var Outdoor = new Boolean(false);
var Misc = new Boolean(false);

function hide(element){
<?php

$sql = "SELECT Count(*),DonorID FROM Donor WHERE name = '".$_GET["addDonorName"]."' OR phone = '"._GET["addDonorPhone"]."' OR email = '"._GET["addDonorEmail"]."' OR street = '"._GET["addDonorStreet"]."'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_BOTH);
$count = $row['Count(*)'];

if($count > 0){
$chosendonor = $row['DonorID'];
}

else{
$sql = "INSERT INTO Donor (name, email, phone, gender, age_group, street,city, zip, heard, Vip, notes)  
    VALUES(CASE WHEN '".$_GET["addDonorName"]."' = '' THEN NULL ELSE '".$_GET["addDonorName"]."' END, 
    CASE WHEN '".$_GET["addDonorEmail"]."' = '' THEN NULL ELSE '".$_GET["addDonorEmail"]."' END, 
    CASE WHEN '".$_GET["addDonorPhone"]."' = '' THEN NULL ELSE '".$_GET["addDonorPhone"]."' END, 
    CASE WHEN '".$_GET["addDonorGender"]."' = '' THEN NULL ELSE '".$_GET["addDonorGender"]."' END, 
    CASE WHEN '".$_GET["addDonorAge"]."' = '' THEN NULL ELSE '".$_GET["addDonorAge"]."' END, 
    CASE WHEN '".$_GET["addDonorStreet"]."' = '' THEN NULL ELSE '".$_GET["addDonorStreet"]."' END, 
    CASE WHEN '".$_GET["addDonorCity"]."' = '' THEN NULL ELSE '".$_GET["addDonorCity"]."' END, 
    CASE WHEN '".$_GET["addDonorZip"]."' = '' THEN NULL ELSE '".$_GET["addDonorZip"]."' END, 
    CASE WHEN '".$_GET["addDonorHeard"]."' = '' THEN NULL ELSE '".$_GET["addDonorHeard"]."' END, 
    CASE WHEN '".$_GET["addDonorIP"]."' = '' THEN NULL ELSE '".$_GET["addDonorIP"]."' END, 
    CASE WHEN '".$_GET["addDonorNotes"]."' = '' THEN NULL ELSE '".$_GET["addDonorNotes"]."' END)";
  $conn->query($sql);

$sql = "SELECT Count(*),DonorID FROM Donor WHERE name = '".$_GET["addDonorName"]."' OR phone = '"._GET["addDonorPhone"]."' OR email = '"._GET["addDonorEmail"]."' OR street = '"._GET["addDonorStreet"]."'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_BOTH);
$chosendonor = $row['DonorID'];

}

?>
document.getElementById("donoradded").style.display = "inline-block";
document.getElementById("addDonationcInfo").style.display ="none";
document.getElementById("recDon").style.display = "block";
document.getElementById("donorno").style.display = "none";

}

function checkSub(element)
{
if(Decor == false && Furniture == false && Kitchen == false && Entertainment == false && Outdoor == false && Misc == false){
window.alert("Please select an Item");
}
if(Decor == true && Furniture == false && Kitchen == false && Entertainment == false && Outdoor == false && Misc == false){
<?php
$chosenPrID = 1;
$chosenqty = $_GET["decoramnt"];
$chosennotes = $_GET["decornotes"];
?>
}
else if(Furniture == true && Decor == false && Kitchen == false && Entertainment == false && Outdoor == false && Misc == false){
<?php
$chosenPrID = 2;
$chosenqty = $_GET["furnitureamnt"];
$chosennotes = $_GET["furniturenotes"];
?>
}
else if(Kitchen == true && Furniture == false && Decor == false && Entertainment == false && Outdoor == false && Misc == false){
<?php
$chosenPrID = 3;
$chosenqty = $_GET["kitchenamnt"];
$chosennotes = $_GET["kitchennotes"];

?>
}
else if(Entertainment == true && Furniture == false && Kitchen == false && Decor == false && Outdoor == false && Misc == false){
<?php
$chosenPrID = 4;
$chosenqty = $_GET["entertainmentamnt"];
$chosennotes = $_GET["entertainmentnotes"];

?>
}

else if(Outdoor == true && Furniture == false && Kitchen == false && Entertainment == false && Decor == false && Misc == false){
<?php
$chosenPrID = 5;
$chosenqty = $_GET["outdooramnt"];
$chosennotes = $_GET["outdoornotes"];

?>
}
else if(Misc == true && Furniture == false && Kitchen == false && Entertainment == false && Outdoor == false && Decor == false){
<?php
$chosenPrID = 6;
$chosenqty = $_GET["miscamnt"];
$chosennotes = $_GET["miscnotes"];

?>
}
else{
<?php
/*
$chosenPrID = 7;
$chosenqty = $_GET["decoramnt"] + $_GET["furnitureamnt"] + $_GET["kitchenamnt"] + 
$_GET["entertainmentamnt"] + $_GET["outdooramnt"] + $_GET["miscamnt"];

$chosennotes = $_GET["decornotes"] + $_GET["furniturenotes"] + $_GET["kitchennotes"] + 
$_GET["entertainmentnotes"] + $_GET["outdoornotes"] + $_GET["miscnotes"];
*/
?>
}

<?php

$combinedDT = date('Y-m-d H:i:s', strtotime($_GET["whenDonatedDate"]." ".$_GET["whenDonatedTime"]));
$chosenPrID = 4;
$chosenamnt = 14;
$chosennotes = 'Okay';

$sql = "INSERT INTO DonDetails (PrID, qty, whenDonated, notes) VALUES ('".$chosenPrID."', '".$chosenqty."', '".$combinedDT."' , '".$chosennotes."')";
$conn->query($sql);

$sql = "Select * FROM DonDetails WHERE whenDonated = '".$combinedDT."'";

$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);
$DonDetailsID = $row['DonDetailsID'];


$sql = "INSERT INTO Don (DonorInfoID, EmpID, DonDetailsID, receipt, destination) VALUES ('".$chosendonor."', '".$chosenEmp."','".$DonDetailsID."','".$_GET["receipt"]."','".$_GET["destination"]."')";
$conn->query($sql);

?>
}


function donorCheck(element){
	if(element.id == "donoryes"){

	document.getElementById(element.id).style.display = "none";
	document.getElementById("donorno").style.display = "inline-block";
	document.getElementById("addDonationcInfo").style.display ="block";
	document.getElementById("recDon").style.display = "none";
	}
	else if(element.id == "donorno"){
	document.getElementById(element.id).style.display = "none";
	document.getElementById("donoryes").style.display = "inline-block";
	document.getElementById("addDonationcInfo").style.display ="none";
	document.getElementById("recDon").style.display = "block";
	}
}


function showIt(element){

if(element.id == "Decor") {
	if(Decor == true)
	{
	dreq.required = false;
	Decorcont.style.display = "none";
	document.getElementById(element.id).style.borderColor = "var(--scBlue)";
	Decor = false;
	}

	else{
	dreq.required = true;
	Decorcont.style.display = "inline-block";
	document.getElementById(element.id).style.borderColor = "var(--scPurple)";
	Decor = true;
	}
} 

else if (element.id == "Furniture"){
if(Furniture == true)
	{
	freq.required = false;
	Furniturecont.style.display = "none";
	document.getElementById(element.id).style.borderColor = "var(--scBlue)";
	Furniture = false;
	}

	else{
	freq.required = true;
	Furniturecont.style.display = "inline-block";
	document.getElementById(element.id).style.borderColor = "var(--scPurple)";
	Furniture = true;
	}
}
else if (element.id == "Kitchen"){
if(Kitchen == true)
	{
	kreq.required = false;
	Kitchencont.style.display = "none";
	document.getElementById(element.id).style.borderColor = "var(--scBlue)";
	Kitchen = false;
	}

	else{
	kreq.required = true;
	Kitchencont.style.display = "inline-block";
	document.getElementById(element.id).style.borderColor = "var(--scPurple)";
	Kitchen = true;
	}


}
else if (element.id == "Entertainment"){
if(Entertainment == true)
	{
	ereq.required = false;
	Entertainmentcont.style.display = "none";
	document.getElementById(element.id).style.borderColor = "var(--scBlue)";
	Entertainment = false;
	}

	else{
	ereq.required = true;
	Entertainmentcont.style.display = "inline-block";
	document.getElementById(element.id).style.borderColor = "var(--scPurple)";
	Entertainment = true;
	}
}
else if (element.id == "Outdoor"){
if(Outdoor == true)
	{
	oreq.required = false;
	Outdoorcont.style.display = "none";
	document.getElementById(element.id).style.borderColor = "var(--scBlue)";
	Outdoor = false;
	}

	else{
	oreq.required = true;
	Outdoorcont.style.display = "inline-block";	
	document.getElementById(element.id).style.borderColor = "var(--scPurple)";
	Outdoor = true;
	}

}
else if(element.id == "Misc"){
if(Misc == true)
	{
	mreq.required = false;
	Misccont.style.display = "none";
	document.getElementById(element.id).style.borderColor = "var(--scBlue)";
	Misc = false;
	}

	else{
	mreq.required = true;
	Misccont.style.display = "inline-block";
	document.getElementById(element.id).style.borderColor = "var(--scPurple)";
	Misc = true;
	}
}

}

function submitForms(){


}

</script>

</body>
</html>