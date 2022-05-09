<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';


?>
  <div class="home-body">
    
    <section class="quickactions-section">
      <div class="quickactions-list">
        <ul>
          <?php 

          //admin level access = 1
          if($_SESSION["Account"] == 1){
            echo '<a href="addReportForm.php"><li class="section-right"><img src="Images/reportIcon.png" alt="Create Report"><h2>Create Report</h2></li></a>';
            echo '<a href="viewUsersPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Users"><h2>Access Users</h2></li></a>';
          //employee level access = 3
          }elseif($_SESSION["Account"] == 3){
            echo '<a href="viewDonationsPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Donations"><h2>Access Donations</h2></li></a>';
            echo '<a href="viewPickupPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Pickups"><h2>Access Pickups</h2></li></a>';
            echo '<a href="viewDonorsPage.php"><li class="section-right"><img src="Images/formIcon.png" alt="Record Donor"><h2>Access Donors</h2></li></a>';            
          //truck level access = 2
          } elseif($_SESSION["Account"] == 2) {
            echo '<a href="viewPickupPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Pickups"><h2>Access Pickups</h2></li></a>';
            echo '<a href="changeStatus.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Pickups"><h2>Active Pickups</h2></li></a>';
          //volunteer level access = 4
          } elseif($_SESSION["Account"] == 4) {
            echo '<a href="addDonationForm.php"><li class="section-left"><img src="Images/donationIcon.png" alt="Record Doonation"><h2>Record Donation</h2></li></a>';
            echo '<a href="addPickupForm.php"><li class="section-middle"><img src="Images/pickupIcon.png" alt="Request Pickup"><h2>Request Pickup</h2></li></a>';     
            echo '<a href="addDonorForm.php"><li class="section-right"><img src="Images/donorIcon.png" alt="Record Donor"><h2>Record Donor</h2></li></a>';
          }

          ?>
        </ul>
      </div>
    </section>
    <section class="advancedoptions-section">
      <div class="advancedoptions-list">
        <ul>
        <?php 
          //admin level access = 1
          if($_SESSION["Account"] == 1){
            echo '<a href="viewDonationsPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Donations"><h3>Access Donations</h3></li></a>';
            echo '<a href="viewPickupPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Pickups"><h3>Access Pickups</h3></li></a>';
            echo '<a href="viewDonorsPage.php"><li class="section-right"><img src="Images/formIcon.png" alt="Record Donor"><h3>Access Donors</h3></li></a>';
            echo '<a href="viewSchedulePage.php"><li class="section-right"><img src="Images/scheduleIcon.png" alt="View Schedule"><h3>View Schedule</h3></li></a>';
          //employee level access = 3
          }elseif($_SESSION["Account"] == 3){           
            echo '<a href="addDonationForm.php"><li class="section-left"><img src="Images/donationIcon.png" alt="Record Doonation"><h3>Record Donation</h3></li></a>';
            echo '<a href="addPickupForm.php"><li class="section-middle"><img src="Images/pickupIcon.png" alt="Request Pickup"><h3>Request Pickup</h3></li></a>';     
            echo '<a href="addDonorForm.php"><li class="section-right"><img src="Images/donorIcon.png" alt="Record Donor"><h3>Record Donor</h3></li></a>';           
          //truck level access = 2
          } elseif($_SESSION["Account"] == 2) {
            echo '<a href="addPickupForm.php"><li class="section-middle"><img src="Images/pickupIcon.png" alt="Request Pickup"><h3>Request Pickup</h3></li></a>';
            echo '<a href="viewDonorsPage.php"><li class="section-right"><img src="Images/formIcon.png" alt="Record Donor"><h3>Access Donors</h3></li></a>';
            echo '<a href="viewDonationsPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Donations"><h3>Access Donations</h3></li></a>';
          //volunteer level access = 4
          } elseif($_SESSION["Account"] == 4) {
            echo '<a href="viewDonationsPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Donations"><h3>Access Donations</h3></li></a>';
            echo '<a href="viewPickupPage.php"><li class="section-left"><img src="Images/formIcon.png" alt="Access Pickups"><h3>Access Pickups</h3></li></a>';
            echo '<a href="viewDonorsPage.php"><li class="section-right"><img src="Images/formIcon.png" alt="Record Donor"><h3>Access Donors</h3></li></a>';
          }

        ?>
        </ul>
      </div>
    </section>
  </div>
  </body>
</html>

