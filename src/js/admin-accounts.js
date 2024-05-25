function getStaffInfo(id){
  $.ajax({
    url: 'ajax.php?action=getStaffinfo&staff_id=' + id,
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data){

        let formattedDateOfBirth = (new Date(data.DateofBirth)).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

        document.querySelector('#Staff_name').textContent = data.First_Name +' ' + data.Middle_Name + ' ' + data.Last_Name;
        document.querySelector('#Staff_speciality').textContent = data.speciality;
        document.querySelector('#Staff_contact_number').textContent = data.Contact_Number;
        document.querySelector('#Staff_email').textContent = data.Email;


        document.querySelector('#Staff_sex').textContent = data.Sex;
        document.querySelector('#Staff_address').textContent = data.Address;
        document.querySelector('#Staff_dateOfBirth').textContent = formattedDateOfBirth;

      }
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });

}
function getPatientInfo(id){
  $.ajax({
    url: 'ajax.php?action=getPatientInfo&online_user_id=' + id,
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data){
        let dob = new Date(data.DateofBirth);

        let ageDate = new Date(Date.now() - dob.getTime());
        let age = Math.abs(ageDate.getUTCFullYear() - 1970);


        let formattedDateOfBirth = (new Date(data.DateofBirth)).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

        document.querySelector('#patient_name').textContent = data.First_Name +' ' + data.Middle_Name + ' ' + data.Last_Name;
        document.querySelector('#patient_Account_created').textContent = data.account_created;
        document.querySelector('#patient_contactNumber').textContent = data.Contact_Number;
        document.querySelector('#patient_email').textContent = data.Email;
        document.querySelector('#patient_age').textContent = age;
        document.querySelector('#patient_sex').textContent = data.Sex;
        document.querySelector('#patient_address').textContent = data.Address;
        document.querySelector('#patient_Date_ofBirth').textContent = formattedDateOfBirth;

      }
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });

}
function getVisibleTableId() {
  let logs_tbl = document.getElementById('patientList');
  if (!logs_tbl.classList.contains('hidden')) {
    return 'accounts_table_patient';
  } else {
    return 'accounts_table_doctor';
  }
}


function switchTable() {
  let select = document.querySelector("select[name='chooseAccount']");
  let doctorTable = document.getElementById("doctorsList");
  let patientTable = document.getElementById("patientList");
  let title = document.getElementById('accounts_title');

  if (select.value === "Doctor Accounts") {
    title.innerHTML = 'Doctor Accounts'
    patientTable.classList.add('hidden');
    doctorTable.classList.remove('hidden')
  } else if (select.value === "Patient Accounts") {
    title.innerHTML = 'Patient Accounts'
    doctorTable.classList.add('hidden');
    patientTable.classList.remove('hidden');
  }
}