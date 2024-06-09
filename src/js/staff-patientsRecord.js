function toggleDetails() {
  const followUpRadio = document.querySelector('input[name="followUp-radio"]:checked');
  const followUpDetails = document.getElementById('followUpDetails');
  const followUpDateInput = document.getElementById('appointment-date');
  const followUpTimeInput = document.getElementById('appointment-time');
  const completedDetails = document.getElementById('completedDetails');

  // Toggle visibility of follow-up details
  followUpDetails.classList.toggle('hidden', followUpRadio.value !== 'yes');
  completedDetails.classList.toggle('hidden', followUpRadio.value === 'yes');

  // Toggle required attribute on date and time inputs
  followUpDateInput.required = followUpRadio.value === 'yes';
  followUpTimeInput.required = followUpRadio.value === 'yes';
}


