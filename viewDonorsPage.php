<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

if(isset($_GET["submitAddDonorsForm"])){
  
  header("location: addDonorForm.php");
}

?>

<section class="viewForm-section">
  <form class="view-form" action="viewDonorsPage.php" name="viewDonorsForm" method="get">
    <div class="viewForm-input">
    <?php
    if (isset($_GET["viewDonoraName"])) {
      echo '<label for="viewDonorsName">Search by Name:</label><br>';
      echo '<input type="text" id="viewDonorsName" onkeyup="autofill_viewDonorTable()" name="viewDonorsName" value="'.$_GET["viewDonorsName"].'"><br>';
    } else {
      echo '<label for="viewDonorsName">Search by Name:</label><br>';
      echo '<input type="text" id="viewDonorsName" onkeyup="autofill_viewDonorTable()" name="viewDonorsName" placeholder="Search for Donors..."><br>';
    }
    ?>

    <label for="viewDonorsAge">Refine by Age Group:</label><br>
    <select id="viewDonorsAge" name="viewDonorsAge">
    <option value=""></option>
    <?php
    $res = $conn->query("SELECT DISTINCT AgeGroupid,Agegroup FROM LookupAgeGroup ORDER BY 1");
    while ($row = $res->fetch_assoc()) {
      if($_GET["viewDonorsAge"] == $row["AgeGroupid"]) {
        echo '<option value="'.$row["AgeGroupid"].'" label="'.$row["Agegroup"].'"selected>'.$row["Agegroup"].'</option>';
      } else {
        echo '<option value="'.$row["AgeGroupid"].'" label="'.$row["Agegroup"].'">'.$row["Agegroup"].'</option>';
      }
    }
    ?>
    </select><br>
    </div>
    <input type="submit" class="regularSubmit" value="Search Donors" name="submitViewDonorsForm"><br><br>
    <input type="submit" class="regularSubmit" value="Add new Donor" name="submitAddDonorsForm"><br><br>
  </form>
</section>
<section class="viewTable-section">
<p class="viewDescription">DONORS</p>  
<?php
  $sql = "SELECT d.DonorID, d.name, d.phone, a.Agegroup, d.zip FROM Donor d LEFT OUTER JOIN LookupAgeGroup a on d.age_group = a.AgeGroupid";

  $sql = $sql." WHERE d.name LIKE '%".$_GET["viewDonorsName"]."%'";

  if (isset($_GET["viewDonorsAge"]) && !empty($_GET["viewDonorsAge"])) {
    $sql= $sql." AND a.AgeGroupid = '".$_GET["viewDonorsAge"]."'";
  }
  $sql = $sql." ORDER BY d.name";
  //debug
  //echo $sql;
  // display search results
  $res = $conn->query($sql);
  echo '<div class="viewTable-container">';
  if($res) {
    $n = 0;
    echo '<table class="viewTable" id="viewDonorsTable" name="viewDonorsTable">';
    echo '<tr class="headerRow"><th>Name</th><th>Age Group</th><th>Phone Number</th><th>Zipcode</th></tr>';
    while ($row = $res->fetch_assoc()) {
      if($n%2==0){
        echo '<tr class="evenRow"><td><a href="addDonorForm.php?dcode='.$row["DonorID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["name"])).'</a></td><td><a href="addDonorForm.php?dcode='.$row["DonorID"].'">'.$row["Agegroup"].'</a></td><td><a href="addDonorForm.php?dcode='.$row["DonorID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["phone"])).'</a></td><td><a href="addDonorForm.php?dcode='.$row["DonorID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["zip"])).'</a></td></tr>';
      } else {
        echo '<tr class="oddRow"><td><a href="addDonorForm.php?dcode='.$row["DonorID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["name"])).'</a></td><td><a href="addDonorForm.php?dcode='.$row["DonorID"].'">'.$row["Agegroup"].'</a></td><td><a href="addDonorForm.php?dcode='.$row["DonorID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["phone"])).'</a></td><td><a href="addDonorForm.php?dcode='.$row["DonorID"].'">'.utf8_encode(str_replace(chr(146),"'",$row["zip"])).'</a></td></tr>';
      }
      $n++;
    }
    echo '</table>';
  }
  // close connection
  $conn->close();
  
  echo '</div>';

?>
</section>

 </body>
</html>