function toggleDetails() {
  const followUpRadio = document.querySelector('input[name="followUp-radio"]:checked');
  const followUpDetails = document.getElementById('followUpDetails');
  const followUpDateInput = document.getElementById('followUpDate');
  const followUpTimeInput = document.getElementById('followUpTime');
  const completedDetails = document.getElementById('completedDetails');

  // Toggle visibility of follow-up details
  followUpDetails.classList.toggle('hidden', followUpRadio.value !== 'yes');
  completedDetails.classList.toggle('hidden', followUpRadio.value === 'yes');

  // Toggle required attribute on date and time inputs
  followUpDateInput.required = followUpRadio.value === 'yes';
  followUpTimeInput.required = followUpRadio.value === 'yes';
}


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
