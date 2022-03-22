function click_account(nameOfButton) {

  let selectCtn = document.getElementById('select-container')
      btnCtn = document.getElementById('btn-container')
      infoCtn = document.getElementById('info-container');

  var accountBtn = document.getElementsByName(nameOfButton);
  
  selectCtn.classList.add('hidden');
  infoCtn.classList.remove('hidden');

  change_account(nameOfButton);
}

function change_account(nameOfAccount) {
  switch(nameOfAccount) {
    case "volunteerBtn":
      document.getElementById('smallAccountName').innerHTML = "Volunteer";
      document.getElementById('login-icon').src = "Images/volunteerIcon.png";
      document.getElementById('accountID').value = Number(4);
      break;
    case "truckBtn":
      document.getElementById('smallAccountName').innerHTML = "Truck";
      document.getElementById('login-icon').src = "Images/truckIcon.png";
      document.getElementById('accountID').value = Number(2);
      break;
    case "employeeBtn":
      document.getElementById('smallAccountName').innerHTML = "Employee";
      document.getElementById('login-icon').src = "Images/employeeIcon.png";
      document.getElementById('accountID').value = Number(3);
      break;
    case "adminBtn":
      document.getElementById('smallAccountName').innerHTML = "Admin";
      document.getElementById('login-icon').src = "Images/adminIcon.png";
      document.getElementById('accountID').value = Number(1);
      break;
  }
  document.getElementById('usernameField').autofocus = true;
}

function click_backAccounts() {
  let selectCtn = document.getElementById('select-container')
      btnCtn = document.getElementById('btn-container')
      infoCtn = document.getElementById('info-container');

  selectCtn.classList.remove('hidden');
  infoCtn.classList.add('hidden');
}
