
let accountOwnerAddress;
function getUserInfo() {
  $.ajax({
    url: 'ajax.php?action=getUserInfo',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data) {
        document.querySelector('#personal-info input[name="first-name"]').value = data.First_Name;
        document.querySelector('#personal-info input[name="middle-name"]').value = data.Middle_Name;
        document.querySelector('#personal-info input[name="last-name"]').value = data.Last_Name;
        document.querySelector('#personal-info input[name="contact-number"]').value = data.Contact_Number;
        document.querySelector('#personal-info input[name="dob"]').value = data.DateofBirth;
        document.querySelector('#personal-info input[name="address"]').value = data.Address;
        accountOwnerAddress = data.Address;
        document.querySelector('#personal-info input[name="email"]').value = data.Email;
        document.querySelector('#personal-info select[name="sex"]').value = data.Sex;
        if (document.querySelector('#personal-info input[name="medicalCondition"]')){
          document.querySelector('#personal-info input[name="medicalCondition"]').value = data.Medical_condition;
        }
        if (document.querySelector('#personal-info input[name="weight"]')){
          document.querySelector('#personal-info input[name="weight"]').value = data.weight;
        }
        if (document.querySelector('#personal-info select[name="specialty"]')){
          document.querySelector('#personal-info select[name="specialty"]').value = data.speciality;

        }
      }
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}
function toggleDialog(id) {
  let dialog = document.getElementById(id);
  if (dialog) {
    if (dialog.hasAttribute('open')) {
      dialog.removeAttribute('open');
    } else {
      dialog.setAttribute('open', '');
    }
  }
}
document.addEventListener('submit', function(e) {
  e.preventDefault();
  let form_data = new FormData(e.target);
  let endpoint;
  let infoText;
  let tab;

  if (e.target.id === 'personal-info') {
    infoText = 'Information Updated';
    endpoint = 'editUserInfo';
  } else if (e.target.id === 'security-form') {
    infoText = 'Password Updated';
    endpoint = 'editUserInfo';
  } else if (e.target.id === 'cancel_appoinment') {
    endpoint = 'cancelAppointment';
    infoText = 'Appointment has been cancelled';
    tab = 'appointmentHistory';
  } else if (e.target.id === 'RelativeForm') {
    infoText = 'Account members has been updated';
    endpoint = 'AccountMemberPostReq';
    tab = 'AccountMembers';
    if (form_data.get('otherRelation').toLowerCase() === 'self' ){

      document.getElementById('memberErrorUpdatetext').innerHTML = "Self type relationship is invalid";
      toggleDialog('memberErrorUpdate');
      return;
    }


  } else {
    console.log('Form ID not recognized:', e.target.id);
    return; // Exit if form ID does not match
  }

  document.getElementById('textInfo').innerHTML = infoText;

  $.ajax({
    url: 'ajax.php?action=' + endpoint,
    type: 'POST',
    data: form_data,
    processData: false,
    contentType: false,
    success: function(response) {
      console.log('Server response:', response);
      if (parseInt(response) === 1) {
        toggleDialog('profileAlert');
        getUserInfo();
      } else if (parseInt(response) === 2) {
        toggleDialog('profileAlert');
        window.location.href = 'patient-profile.php?route=' + tab;
      } else {
        document.getElementById('errorAlert').innerHTML = response;
        toggleDialog('errorAlert');
      }
    },
    error: function(xhr, status, error) {
      console.log('AJAX error:', error);
      document.getElementById('errorAlert').innerHTML = 'An error occurred: ' + error;
      toggleDialog('errorAlert');
    }
  });
});

getUserInfo();