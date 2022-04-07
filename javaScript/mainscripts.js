function show_mobileMenu() {
  const mobileBtn = document.getElementById('mobileNavView')
      nav = document.querySelector('nav')
      mobileBtnExit = document.getElementById('mobileNavExit');

  nav.classList.add('menu-btn');
}

function hide_mobileMenu() {
  const mobileBtn = document.getElementById('mobileNavView')
      nav = document.querySelector('nav')
      mobileBtnExit = document.getElementById('mobileNavExit');
  nav.classList.remove('menu-btn');
}


//autofill function for datalists
function autofill_requestName() {
  var input, filter, datalist, option, i, txtValue;
  input = document.getElementById("requestName");
  filter = input.value.toUpperCase();
  datalist = document.getElementById("potentialDonors");
  option = datalist.getElementsByTagName("option");
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].value;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        option[i].style.display = "";
    } else {
        option[i].style.display = "none";
    }
  }
}

//autofill function for datalists
function autofill_requestPhone() {
  var input, filter, datalist, option, i, txtValue;
  input = document.getElementById("requestPhone");
  filter = input.value.toUpperCase();
  datalist = document.getElementById("potentialPhone");
  option = datalist.getElementsByTagName("option");
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].value;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        option[i].style.display = "";
    } else {
        option[i].style.display = "none";
    }
  }
}

//autofill function for datalists
function autofill_requestEmail() {
  var input, filter, datalist, option, i, txtValue;
  input = document.getElementById("requestEmail");
  filter = input.value.toUpperCase();
  datalist = document.getElementById("potentialEmail");
  option = datalist.getElementsByTagName("option");
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].value;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        option[i].style.display = "";
    } else {
        option[i].style.display = "none";
    }
  }
}

//autofill function for datalists
function autofill_requestStreetAddress() {
  var input, filter, datalist, option, i, txtValue;
  input = document.getElementById("requestStreetAddress");
  filter = input.value.toUpperCase();
  datalist = document.getElementById("potentialStreetAddress");
  option = datalist.getElementsByTagName("option");
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].value;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        option[i].style.display = "";
    } else {
        option[i].style.display = "none";
    }
  }
}

//autofill function for datalists
function autofill_requestCityAddress() {
  var input, filter, datalist, option, i, txtValue;
  input = document.getElementById("requestCityAddress");
  filter = input.value.toUpperCase();
  datalist = document.getElementById("potentialCityAddress");
  option = datalist.getElementsByTagName("option");
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].value;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        option[i].style.display = "";
    } else {
        option[i].style.display = "none";
    }
  }
}

//autofill function for datalists
function autofill_requestZipAddress() {
  var input, filter, datalist, option, i, txtValue;
  input = document.getElementById("requestZipAddress");
  filter = input.value.toUpperCase();
  datalist = document.getElementById("potentialZipAddress");
  option = datalist.getElementsByTagName("option");
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].value;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        option[i].style.display = "";
    } else {
        option[i].style.display = "none";
    }
  }
}

//autofill function for datalists
function autofill_requestStateAddress() {
  var input, filter, datalist, option, i, txtValue;
  input = document.getElementById("requestStateAddress");
  filter = input.value.toUpperCase();
  datalist = document.getElementById("potentialStateAddress");
  option = datalist.getElementsByTagName("option");
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].value;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        option[i].style.display = "";
    } else {
        option[i].style.display = "none";
    }
  }
}

//calculate the total number of items
function calculate_requestTotalItems() {
  var numLarge = document.getElementById('numLargeItems').value 
      numMedium = document.getElementById('numMediumItems').value
      numSmall = document.getElementById('numSmallItems').value
      numTotal = document.getElementById('numTotalItems')
      multTrips = document.getElementById('requestMultTrips');

  numTotal.value = Number(numLarge) + Number(numMedium) + Number(numSmall);
  
  if(numLarge >= 10 || numTotal >=50) {
      multTrips.checked = true;
  }

}

//autofill function for Tables
function autofill_viewTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("viewUsersName");
  filter = input.value.toUpperCase();
  table = document.getElementById("viewTable");
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

//autofill function for Tables
function autofill_viewDonorTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("viewDonorsName");
  filter = input.value.toUpperCase();
  table = document.getElementById("viewDonorsTable");
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

//autofill function for Tables
function autofill_viewPickupTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("viewPickupStreet");
  filter = input.value.toUpperCase();
  table = document.getElementById("viewPickupTable");
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

//autofill function for Tables
function autofill_viewDonationsTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("viewDonationsDonor");
  filter = input.value.toUpperCase();
  table = document.getElementById("viewDonationsTable");
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

//autofill function for datalists
function autofill_input(thisID,thisDatalist) {
  var input, filter, datalist, option, i, txtValue;
  input = document.getElementById(thisID);
  filter = input.value.toUpperCase();
  datalist = thisDatalist;
  option = datalist.getElementsByTagName('option');
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].value;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
        option[i].style.display = "";
    } else {
        option[i].style.display = "none";
    }
  }
}

function check_vip() {
  var addDonorIP = document.getElementById('addDonorIP');
  
  if(addDonorIP.checked == true) {
    addDonorIP.value = "1";
  } else {
    addDonorIP.value = "0";
  }
  
}

function check_priority(value) {
  var highP = document.getElementById('highPriority');
  var midP = document.getElementById('midPriority');
  var lowP = document.getElementById('lowPriority');
  alert(value);
  if(value == 1) {
    highP.selected = true;
  } else if(value == 2) {
    midP.selected = true;
  } else if (value == 3) {
    lowP.selected == true;
  }
}

function check_HomeAddress() {
  var home = document.getElementById('requestHomeAddress');
  
  if(home.checked == true) {
    home.value = "1";
  } else {
    home.value = "0";
  }
  
}

