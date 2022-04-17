<?php
//page verification
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

//ACTION: Submit Edit User form
if (isset($_GET["submitEditUserForm"])){
  //$combinedDT = date('Y-m-d H:i:s', strtotime($_GET["cdate"]." ".$_GET["ctime"]));
  
  $sql = "UPDATE Employee
  SET fname='".$_GET["addUserFname"]."',
  lname=CASE WHEN '".$_GET["addUserLname"]."' = '' THEN NULL ELSE '".$_GET["addUserLname"]."' END,
  username='".$_GET["addUserUsername"]."',
  password='".$_GET["addUserPassword"]."',
  role='".$_GET["addUserRole"]."',
  accesslvl='".$_GET["addUserAccesslvl"]."'
  WHERE Employeeid=".$_GET["ecode"]."";
  //X debug   
  //echo $sql;
  $conn->query($sql);
}

//ACTION: Submit Add User From
if(isset($_GET["submitAddUserForm"])){
    
    $sql = "INSERT INTO Employee(fname,lname,username,password,role,accesslvl) 
    VALUES('".$_GET["addUserFname"]."',
    CASE WHEN '".$_GET["addUserLname"]."' = '' THEN NULL ELSE '".$_GET["addUserLname"]."' END,
    '".$_GET["addUserUsername"]."',
    '".$_GET["addUserPassword"]."',
    '".$_GET["addUserRole"]."',
    '".$_GET["addUserAccesslvl"]."')";
    //X debug   
    //echo $sql;
    $conn->query($sql);
}

// Retrieve ID information for selected employee
if(isset($_GET["ecode"])) {
  $sql = "SELECT * FROM Employee WHERE Employeeid='".$_GET["ecode"]."'";
  // select data 
  $res = $conn->query($sql);
  //X debug 
  //echo $sql;

  // store selected employee id
  $edata = $res->fetch_assoc();
}
?>


<section class="addForm-section">
  <form class="add-form" action="addUserForm.php" name="addUserForm" method="get">
    <div class="addForm-header">
      <img class="addUserFormHeader-logo" src="Images/horizontalLogo.png" alt="Family Promise Logo">
      <h2>USER INFORMATION FORM</h2>
      <hr>
    </div>
    <div class="addForm-input">
      <?php
      if (isset($_GET["ecode"])){ 	
      echo '<input type="hidden" name="ecode" value="'.$_GET["ecode"].'">';
      }
      ?>
      <fieldset class="info" name="userInfo">
        <?php
        echo '<legend>New User information</legend>';
        echo '<label for="addUserFname">First Name</label><br>';
        echo '<input type="text" id="addUserFname" name="addUserFname" value="'.$edata["fname"].'" placeholder="First Name..." maxlength="25" required><br>';
        echo '<label for="addUserLname">Last Name</label><br>';
        echo '<input type="text" id="addUserLname" name="addUserLname" value="'.$edata["lname"].'" placeholder="Last Name..." maxlength="25" ><br>';
        echo '<label for="addUserUsername">Username</label><br>';
        echo '<input type="text" id="addUserUsername" name="addUserUsername" value="'.$edata["username"].'" placeholder="Username..." maxlength="80" required><br>';
        echo '<label for="addUserPassword">Password</label><br>';
        echo '<input type="text" id="addUserPassword" name="addUserPassword" value="'.$edata["password"].'" placeholder="Password..." maxlength="80" required><br>';
        ?>
      </fieldset>
      <fieldset class="accessInfo">

        <legend>Access Details</legend>
        <label for="addUserChoose">Role</label>
        <div id="addUserChoose" class="addUserFormRole-container">
          <?php
          if($edata['role'] == 'Admin') {
          echo '<label for="addUserAdmin"><img style="width:3em;height:3em;" src="Images/adminIcon.png"></label>';
          echo '<input type="radio" id="addUserAdmin" name="addUserRole" value="Admin" checked required>';
          } else {
            echo '<label for="addUserAdmin"><img style="width:3em;height:3em;" src="Images/adminIcon.png"></label>';
            echo '<input type="radio" id="addUserAdmin" name="addUserRole" value="Admin" required>';   
          }
          if($edata['role'] == 'Truck') {
          echo '<label for="addUserTruck"><img style="width:3em;height:3em;" src="Images/truckIcon.png"></label>';
          echo '<input type="radio" id="addUserTruck" name="addUserRole" value="Truck" checked>';
          } else {
          echo '<label for="addUserTruck"><img style="width:3em;height:3em;" src="Images/truckIcon.png"></label>';
          echo '<input type="radio" id="addUserTruck" name="addUserRole" value="Truck">';
          }
          if($edata['role'] == 'Employee') {
          echo '<label for="addUserEmployee"><img style="width:3em;height:3em;" src="Images/employeeIcon.png"></label>';
          echo '<input type="radio" id="addUserEmployee" name="addUserRole" value="Employee" checked>';
          } else {
          echo '<label for="addUserEmployee"><img style="width:3em;height:3em;" src="Images/employeeIcon.png"></label>';
          echo '<input type="radio" id="addUserEmployee" name="addUserRole" value="Employee">';
          } 
          if($edata['role'] == 'Volunteer') {
          echo '<label for="addUserVolunteer"><img style="width:3em;height:3em;" src="Images/volunteerIcon.png"></label>';
          echo '<input type="radio" id="addUserVolunteer" name="addUserRole" value="Volunteer" checked>';
          } else {
          echo '<label for="addUserVolunteer"><img style="width:3em;height:3em;" src="Images/volunteerIcon.png"></label>';
          echo '<input type="radio" id="addUserVolunteer" name="addUserRole" value="Volunteer">';
          }
          ?>
          </div>
        <label for="addUserAccesslvl">Access Level</label><br>
        <select id="addUserAccesslvl" name="addUserAccesslvl" required>
        <?php
          if($edata['accesslvl'] == 1) {
          echo '<option value="1" label="1) Up to Admin access" selected>level 1</option>';
          } else {
            echo '<option value="1" label="1) Up to Admin access">level 1</option>';
          }
          if($edata['accesslvl'] == 2) {
          echo '<option value="2" label="2) Up to Truck access" selected>level 2</option>';
          } else {
          echo '<option value="2" label="2) Up to Truck access">level 2</option>';
          }
          if($edata['accesslvl'] == 3) {
          echo '<option value="3" label="3) Up to Employee access" selected>level 3</option>';
          } else {
          echo '<option value="3" label="3) Up to Employee access">level 3</option>';
          } 
          if($edata['accesslvl'] == 4) {
          echo '<option value="4" label="4) Volunteer access" selected>level 4</option>';
          } else {
          echo '<option value="4" label="4) Volunteer access">level 4</option>';
          }
        ?>
        </select>
      </fieldset>
    </div>
    <?php
    //decide which form submit to show
    if (isset($_GET["ecode"])){
      //named submit button for EDITING selected employee
      echo '<input type="submit" class="stickySubmit" value="Update '.$edata["fname"].'" name="submitEditUserForm">';
    }
    else{
      //named submit button for ADDING selected employee
      echo '<input type="submit" class="stickySubmit" value="Add User" name="submitAddUserForm">';
    }
    ?>
  </form>
</section>


</body>
</html>