# dbms-group7-project


New repository for the implementation

Here is the function for auto updating a table while filling it out, can be used on other things as well such as search options
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<?php
//Check to see if donor exists already
  $check = "SELECT DonorID, name, phone FROM Donor WHERE name = '".$_GET["requestName"]."' AND phone = '".$_GET["requestPhone]."'";
  $res = $conn->query($check);
  if($res) {
    $ExistingDonorID = $_GET["DonorID"];
  } 
?>


ALTER TABLE Don AUTO_INCREMENT=1;
ALTER TABLE DonDetails AUTO_INCREMENT=1;
ALTER TABLE Pick AUTO_INCREMENT=1;
ALTER TABLE PickInfo AUTO_INCREMENT=1;
ALTER TABLE Donor AUTO_INCREMENT=2;