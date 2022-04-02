<?php
$current = basename($_SERVER['PHP_SELF']);
$active = basename($_SERVER['PHP_SELF']);
include 'header.php';

if(isset($_GET["submitAddUserForm"])){
  
  header("location: addUserForm.php");
}

?>

<section class="viewForm-section">
  <form class="view-form" action="viewUsersPage.php" name="viewUsersForm" method="get">
    <div class="viewForm-input">
    <?php
    if (isset($_GET["viewUsersName"])) {
      echo '<label for="viewUsersName">Search by Name:</label><br>';
      echo '<input type="text" id="viewUsersName" onkeyup="autofill_viewTable()" name="viewUsersName" value="'.$_GET["viewUsersName"].'"><br>';
    } else {
      echo '<label for="viewUsersName">Search by Name:</label><br>';
      echo '<input type="text" id="viewUsersName" onkeyup="autofill_viewTable()" name="viewUsersName" placeholder="Search for User..."><br>';
    }
    ?>

    <label for="viewUsersRole">Refine by Role:</label><br>
    <select id="viewUsersRole" name="viewUsersRole">
    <option value=""></option>
    <?php
    $res = $conn->query("SELECT DISTINCT role FROM Employee ORDER BY role");
    while ($row = $res->fetch_assoc()) {
      if($_GET["viewUsersRole"] == $row["role"]) {
        echo '<option value="'.$row["role"].'" selected>'.$row["role"].'</option>';
      } else {
        echo '<option value="'.$row["role"].'">'.$row["role"].'</option>';
      }
    }
    ?>
    </select><br>
    </div>
    <input type="submit" class="regularSubmit" value="Search Users" name="submitViewUsersForm"><br><br>
    <input type="submit" class="regularSubmit" value="Add new User" name="submitAddUserForm"><br><br>
  </form>
</section>
<section class="viewTable-section">
<p class="viewDescription">USERS</p>  
<?php
  $sql = "SELECT Employeeid, fname, lname, role, accesslvl FROM Employee";

  $sql = $sql." WHERE fname LIKE '%".$_GET["viewUsersName"]."%'";

  if (isset($_GET["viewUsersRole"]) && !empty($_GET["viewUsersRole"])) {
    $sql= $sql." AND role = '".$_GET["viewUsersRole"]."'";
  }
  $sql = $sql." ORDER BY fname";
  //debug
  //echo $sql;
  // display search results
  $res = $conn->query($sql);
  echo '<div class="viewTable-container">';
  if($res) {
    $n = 0;
    echo '<table class="viewTable" id="viewTable" name="viewUsersTable">';
    echo '<thead>';
    echo '<tr class="headerRow"><th>First Name</th><th>Last Name</th><th>Role</th><th>Access Level</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $res->fetch_assoc()) {
      if($n%2==0){
        echo '<tr class="evenRow"><td><a href="addUserForm.php?ecode='.$row["Employeeid"].'">'.utf8_encode(str_replace(chr(146),"'",$row["fname"])).'</a></td><td><a href="addUserForm.php?ecode='.$row["Employeeid"].'">'.utf8_encode(str_replace(chr(146),"'",$row["lname"])).'</a></td><td><a href="addUserForm.php?ecode='.$row["Employeeid"].'">'.utf8_encode(str_replace(chr(146),"'",$row["role"])).'</a></td><td><a href="addUserForm.php?ecode='.$row["Employeeid"].'">'.utf8_encode(str_replace(chr(146),"'",$row["accesslvl"])).'</a></td></tr>';
      } else {
        echo '<tr class="oddRow"><td><a href="addUserForm.php?ecode='.$row["Employeeid"].'">'.utf8_encode(str_replace(chr(146),"'",$row["fname"])).'</a></td><td><a href="addUserForm.php?ecode='.$row["Employeeid"].'">'.utf8_encode(str_replace(chr(146),"'",$row["lname"])).'</a></td><td><a href="addUserForm.php?ecode='.$row["Employeeid"].'">'.utf8_encode(str_replace(chr(146),"'",$row["role"])).'</a></td><td><a href="addUserForm.php?ecode='.$row["Employeeid"].'">'.utf8_encode(str_replace(chr(146),"'",$row["accesslvl"])).'</a></td></tr>';
      }
      $n++;
    }
    echo '</tbody>';
    echo '</table>';
  }
  // close connection
  $conn->close();
  
  echo '</div>';

?>
</section>

 </body>
</html>