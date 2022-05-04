

<?php 
include "checkuser.php"; 
include 'schedule.php';
?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?php
        // create the arrays for titles and address in the proper order
        $pageTitles = array("Family Promise Home","Add Donation Form","Add Donor Form","Create Report","Request Pickup Form","Edit Donation Info","Edit Donor Info","View Donations","View Donors","Report Preview","Pickup Schedule","Edit Users", "View Users", "View Pickups", "Change Status");
        $allLinkAddresses = array("index.php","addDonationForm.php","addDonorForm.php","addReportForm.php","addPickupForm.php","editDonation.php","editDonor.php","viewDonationsPage.php","viewDonorsPage.php","viewReportPage.php","viewSchedulePage.php","addUserForm.php","viewUsersPage.php", "viewPickupPage.php", "changeStatus.php");
        // Display custom page titles of current page
        for ($i=0;$i<count($pageTitles);$i++){
          if($allLinkAddresses[$i] == $current){
            echo '<title>'.$pageTitles[$i].'</title>';
          }
        }
        session_start();       
      ?>
      <script src="javaScript/mainscripts.js"></script>
      <link rel="stylesheet" href="css/MainStyles.css">
      <link rel="stylesheet" href="css/CalenderStyles.css">
    </head>
  <body class="body">

<div class="navbar">
  <div class="nav-container">
    <a class="logo" href="https://familypromise.org/">Family<span>Promise</span></a>
    <img id="mobileNavView" class="mobile-menu" onclick="show_mobileMenu()" src="Images/menuIcon.png" alt="Menu">
    <nav>
      <img id="mobileNavExit" class="mobile-menu-exit" onclick="hide_mobileMenu()" src="Images/exitIcon.png" alt="Menu exit">
      <?php
      //display and give user proper link addresses accourding to access lvl
        //admin level access = 1
        if($_SESSION["Account"] == 1){
        $linkaddresses = array("index.php","addDonationForm.php","addDonorForm.php","addReportForm.php","addPickupForm.php","viewDonationsPage.php","viewDonorsPage.php","viewUsersPage.php", "viewPickupPage.php", "logout.php","viewReportPage.php","addUserForm.php");
        $linknames = array("Home","Add Donation","Add Donor","Create Report","Request Pickup","View Donations","View Donors","View Users", "View Pickups");
        //employee level access = 3
        }elseif($_SESSION["Account"] == 3){
        $linkaddresses = array("index.php","addDonationForm.php","addDonorForm.php","addPickupForm.php","viewDonationsPage.php","viewDonorsPage.php", "viewPickupPage.php", "logout.php");
        $linknames = array("Home","Add Donation","Add Donor","Request Pickup","View Donations","View Donors", "View Pickups");
        //truck level access = 2
        } elseif($_SESSION["Account"] == 2) {
        $linkaddresses = array("index.php","addPickupForm.php","viewDonationsPage.php","viewDonorsPage.php", "viewPickupPage.php", "changeStatus.php", "addDonorForm.php", "addDonationForm.php", "logout.php");
        $linknames = array("Home","Request Pickup","View Donations","View Donors", "View Pickups", "Active Pickups");
        //volunteer level access = 4
        } elseif($_SESSION["Account"] == 4) {
        $linkaddresses = array("index.php","addDonationForm.php","addDonorForm.php","addPickupForm.php","viewDonationsPage.php","viewDonorsPage.php","viewPickupPage.php","logout.php");
        $linknames = array("Home","Add Donation","Add Donor","Request Pickup","View Donations","View Donors", "View Pickups");
        }

        echo '<ul class="primary-nav">';

        for ($i=0;$i<count($linknames);$i++){
          if($linkaddresses[$i] == $active){
            echo '<li><a href="'.$linkaddresses[$i].'" class="active">'.$linknames[$i].'</a></li>';
          } else {
            echo '<li><a href="'.$linkaddresses[$i].'">'.$linknames[$i].'</a></li>';
          }
        }
        echo '</ul>';
        echo '<ul class="secondary-nav">';
        echo '<li class="logout"><a href="logout.php">Logout</a></li>';
        //admin level access = 1
        if($_SESSION["Account"] == 1){
          echo '<li style="float:right"><img src="Images/adminIcon.png" alt="Admin"></li>';
        //employee level access = 3
        }elseif($_SESSION["Account"] == 3){
          echo '<li style="float:right"><img src="Images/employeeIcon.png" alt="Employee"></li>';
        //truck level access = 2
        } elseif($_SESSION["Account"] == 2) {
          echo '<li style="float:right"><img src="Images/truckIcon.png" alt="Truck"></li>';
        //volunteer level access = 4
        } elseif($_SESSION["Account"] == 4) {
          echo '<li style="float:right"><img src="Images/volunteerIcon.png" alt="Volunteer"></li>';
        }
        echo '</ul>';
        
        // Double check that user is allowed on current page
        $allowed = false;
        for($i=0;$i<count($linkaddresses);$i++){
          if($current == $linkaddresses[$i]){
            $allowed = true;
          }
        }
        if($allowed == false){
          header("location: index.php");
        } 
        
      ?>
    </nav>
  </div>
</div>  
<?php

  //include the connection information
  include 'databaseInfo/variablesGroup.php';

  // make a connection to the database
  $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

  //set the timezone and display the date
  date_default_timezone_set("America/New_York");
  //echo "Local date and time: ".date("l jS \of F Y h:i:s A")."<br>";

  // print an error if connection was unsuccessful      
  if(!$conn ) {
    die('Could not connect: '.mysqli_error());
  }
  
?>
