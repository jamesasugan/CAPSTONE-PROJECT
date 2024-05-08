document.addEventListener('DOMContentLoaded', function () {
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('followUpDate').setAttribute('min', today);

  const editBtn = document.getElementById('editBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const updateBtn = document.getElementById('updateBtn');
  const form = document.getElementById('patientForm');
  const inputs = form.querySelectorAll(
    'input[type=text], input[type=date], input[type=time], select, input[type=file], input[type=radio], textarea',
  );

  // Enable editing
  editBtn.addEventListener('click', function (e) {
    e.preventDefault();
    updateBtn.classList.remove('hidden');
    cancelBtn.classList.remove('hidden');
    editBtn.classList.add('hidden');

    inputs.forEach((input) => {
      input.disabled = false;
    });
  });

  // Cancel editing
  cancelBtn.addEventListener('click', function (e) {
    e.preventDefault();
    resetPatientForm();
  });

  // Radio button change listeners for follow-up decision
  document
    .getElementById('yesFollowUp')
    .addEventListener('change', function () {
      document.getElementById('followUpDetails').classList.remove('hidden');
      document.getElementById('followUpDate').required = true;
      document.getElementById('followUpTime').required = true;
    });

  document.getElementById('noFollowUp').addEventListener('change', function () {
    document.getElementById('followUpDetails').classList.add('hidden');
    document.getElementById('followUpDate').required = false;
    document.getElementById('followUpTime').required = false;
  });
});

function resetPatientForm() {
  const form = document.getElementById('patientForm');
  const inputs = form.querySelectorAll(
    'input[type=text], input[type=date], input[type=time], select, input[type=file], input[type=radio], textarea',
  );

  const followUpDetails = document.getElementById('followUpDetails');
  const completedDetails = document.getElementById('completedDetails');
  const editBtn = document.getElementById('editBtn');
  const updateBtn = document.getElementById('updateBtn');
  const cancelBtn = document.getElementById('cancelBtn');

  form.reset(); // Reset form fields to their default values

  inputs.forEach((input) => {
    input.disabled = true; // Disable all inputs
  });

  // Hide the follow-up and completed sections
  followUpDetails.classList.add('hidden');
  completedDetails.classList.add('hidden');

  // Show/Hide buttons correctly
  editBtn.classList.remove('hidden');
  updateBtn.classList.add('hidden');
  cancelBtn.classList.add('hidden');
}

// Handle the modal close event
document
  .querySelector('.modal-action button')
  .addEventListener('click', function (e) {
    e.preventDefault();
    resetPatientForm();
    view_info1.close(); // Close the modal
  });
