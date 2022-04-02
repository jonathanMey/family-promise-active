<?php
  
  include 'databaseInfo/variablesGroup.php';
  // make a connection to the database
  $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  // print an error if connection was unsuccessful
  if(!$conn ) {
    die('Could not connect: '.mysqli_error());
  }
  //read login information
  if (isset($_POST["username"]) && !empty($_POST["username"])){ 
    $sql = "SELECT Employeeid, username,password,role,accesslvl FROM Employee WHERE username = '".$_POST["username"]."'";
    $res = $conn->query($sql);
    $account = $_POST["account"];
    if($res) {
      $row = $res->fetch_assoc();
      $access = $row["accesslvl"];
      //X debug
      //echo ''.$account.', username: '.$row["username"].'';
      
      // check if password in the database matches the one entered by the user
      if($account >= $row["accesslvl"]) {
        if($row['password'] == $_POST["password"]){
          // start the session and store username and access level as session variables
          session_start();
                  
          $_SESSION['Username'] = $row["username"]; 
          $_SESSION['Accesslvl'] = $row['accesslvl'];
          $_SESSION['Account'] = $account;
          $_SESSION['UserID'] = $row["Employeeid"];  
          //X debug
          //echo ''.$account.', account: '.$_SESSION["Account"].' UserID: '.$_SESSION["UserID"].' Accesslevel: '.$_SESSION["Accesslvl"];

          // redirect to the home page after successful login	
          header("location: index.php");
        }else {
          ?><script> alert("The password you entered is not valid");</script><?php
        }
      } else {
        ?><script> alert("Permission Denied");</script><?php
      }
    } else {
      // if the query returned no rows, print "The username you entered is not valid."
      ?><script> alert("Unable to retrieve user credetials");</script><?php
    }
  }
  
?>


<!DOCTYPE html>
<html class="loginHtml">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/loginStyles.css">
  <script src="javaScript/loginScript.js"></script>
  </head>
  <body class="loginBody">
    <div id="select-container" class="login-select-container">
      <div id="btn-container" class="account-btns-container">
        <button type="button" name="volunteerBtn" onclick="click_account(this.getAttribute('Name'))"><img src="Images/volunteerIcon.png" alt="Volunteer Icon"><h2>Volunteer</h2></button>
        <button type="button" name="truckBtn" onclick="click_account(this.getAttribute('Name'))"><img src="Images/truckIcon.png" alt="Pickup Icon"><h2>Truck</h2></button>
        <button type="button" name="employeeBtn" onclick="click_account(this.getAttribute('Name'))"><img src="Images/employeeIcon.png" alt="employee Icon"><h2>Employee</h2></button>
        <button type="button" name="adminBtn" onclick="click_account(this.getAttribute('Name'))"><img src="Images/adminIcon.png" alt="Admin Icon"><h2>Admin</h2></button>
      </div>
      <div class="login-brandmessage-container">
        <h1>We are Family Promise</h1>
        <h2>Transforming the lives of families experiencing homelessness. Because every child deserves a home.</h2>
        <img src="Images/horizontalLogo.png" alt="Horizontal Family Promise Logo">
      </div>
    </div>
    <div id="info-container" class="login-container hidden">
      <button class="goback" type="button" name="backAccountsBtn" onclick="click_backAccounts()"><img src="Images/exitIcon.png" alt="go back"></button>    
      <img class="accountIcon" id="login-icon" src="Images/adminIcon.png" alt="Avatar">
      <h2 id="smallAccountName">Account</h2>
      <form  id="loginForm" class="loginForm" action="login.php" method="post">
      <input id="accountID" class="accountInput" type="number" name="account">
      <input class="loginInput" id="usernamefield" type="text" name="username" placeholder="Enter username" required>
      <input class="loginInput" type="password" name="password" placeholder="Enter Password" required>
      <input class="submitInput" type="submit" value="Login" name="submitLoginForm" autofocus>
      </form> 
    </div>   
  </body>
</html>