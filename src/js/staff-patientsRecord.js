document.addEventListener('DOMContentLoaded', function () {
  const today = new Date().toISOString().split('T')[0];
  const followUpDate = document.getElementById('followUpDate');
  if (followUpDate) {
    followUpDate.setAttribute('min', today);
  }

  const editBtn = document.getElementById('editBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const updateBtn = document.getElementById('updateBtn');
  const form = document.getElementById('patientForm');
  const inputs = form
    ? form.querySelectorAll(
        'input[type=text], input[type=date], input[type=time], select, input[type=file], input[type=radio], textarea',
      )
    : [];

  // Enable editing
  if (editBtn && cancelBtn && updateBtn) {
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
  }

  // Radio button change listeners for follow-up decision
  const yesInput = document.getElementById('yesFollowUp');
  const noInput = document.getElementById('noFollowUp');
  const followUpDetails = document.getElementById('followUpDetails');
  const completedDetails = document.getElementById('completedDetails');

  if (yesInput && noInput && followUpDetails && completedDetails) {
    yesInput.addEventListener('change', function () {
      if (this.checked) {
        followUpDetails.classList.remove('hidden');
        completedDetails.classList.add('hidden');
        followUpDate.required = true;
        document.getElementById('followUpTime').required = true;
      }
    });

    noInput.addEventListener('change', function () {
      if (this.checked) {
        completedDetails.classList.remove('hidden');
        followUpDetails.classList.add('hidden');
        followUpDate.required = false;
        document.getElementById('followUpTime').required = false;
      }
    });
  }
});

function resetPatientForm() {
  const form = document.getElementById('patientForm');
  const inputs = form
    ? form.querySelectorAll(
        'input[type=text], input[type=date], input[type=time], select, input[type=file], input[type=radio], textarea',
      )
    : [];

  const followUpDetails = document.getElementById('followUpDetails');
  const completedDetails = document.getElementById('completedDetails');
  const editBtn = document.getElementById('editBtn');
  const updateBtn = document.getElementById('updateBtn');
  const cancelBtn = document.getElementById('cancelBtn');

  if (form) {
    form.reset(); // Reset form fields to their default values
    inputs.forEach((input) => {
      input.disabled = true; // Disable all inputs
    });
  }

  // Hide the follow-up and completed sections if they exist
  if (followUpDetails) followUpDetails.classList.add('hidden');
  if (completedDetails) completedDetails.classList.add('hidden');

  // Show/Hide buttons correctly
  if (editBtn) editBtn.classList.remove('hidden');
  if (updateBtn) updateBtn.classList.add('hidden');
  if (cancelBtn) cancelBtn.classList.add('hidden');
}
