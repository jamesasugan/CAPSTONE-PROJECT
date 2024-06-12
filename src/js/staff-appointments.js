document.addEventListener('DOMContentLoaded', function () {
  const rescheduleSection = document.getElementById('reschedule-section');
  const approveReason = document.querySelectorAll('input[name="approveReason"]');
  const reschedReason = document.querySelectorAll('input[name="reschedReason"]');
  const cancelReason = document.querySelectorAll('input[name="cancelReason"]');
  const otherReasonContainer = document.getElementById('otherReasoncontainer');
  const otherReasonInput = document.getElementById('otherReason');

  function clearRadioButtons(radioButtons) {
    radioButtons.forEach(input => {
      input.checked = false;
    });
  }

  function resetInputFields(inputs) {
    inputs.forEach(input => {
      input.value = '';
    });
  }

  function resetForm() {
    clearRadioButtons(approveReason);
    clearRadioButtons(reschedReason);
    clearRadioButtons(cancelReason);
    resetInputFields([otherReasonInput]);
    hideAllReasonOptions();
    hideRescheduleSection(); 
  }

  function showOtherReasonContainer() {
    otherReasonContainer.style.display = 'block';
    otherReasonInput.required = true;
  }

  function hideOtherReasonContainer() {
    otherReasonContainer.style.display = 'none';
    otherReasonInput.required = false;
  }

  function hideAllReasonOptions() {
    approveReason.forEach(input => input.closest('li').style.display = 'none');
    reschedReason.forEach(input => input.closest('li').style.display = 'none');
    cancelReason.forEach(input => input.closest('li').style.display = 'none');
    hideOtherReasonContainer();
  }

  function hideRescheduleSection() {
    rescheduleSection.style.display = 'none';
  }

  function hideAllReasonOptionsInitially() {
    hideAllReasonOptions();
    document.querySelector('input[name="list-status"]:checked')?.click(); 
  }

  function handleStatusChange(status) {
    hideAllReasonOptions();
    switch (status) {
      case 'approved':
        approveReason.forEach(input => input.closest('li').style.display = 'block');
        break;
      case 'rescheduled':
        reschedReason.forEach(input => input.closest('li').style.display = 'block');
        break;
      case 'cancelled':
        cancelReason.forEach(input => input.closest('li').style.display = 'block');
        break;
    }
  }

  document.querySelectorAll('input[name="list-status"]').forEach(input => {
    input.addEventListener('change', function () {
      if (this.checked) {
        handleStatusChange(this.value);
        if (this.value === 'rescheduled') {
          rescheduleSection.style.display = 'flex';
        } else {
          rescheduleSection.style.display = 'none';
        }
      }
    });
  });

  document.querySelectorAll('input[name="approveReason"], input[name="reschedReason"], input[name="cancelReason"]').forEach(input => {
    input.addEventListener('change', function () {
      if (this.id.includes('others')) {
        showOtherReasonContainer();
      } else {
        hideOtherReasonContainer();
      }
    });
  });

  hideAllReasonOptionsInitially();

  // Reset form when close button is clicked
  document.getElementById('modalAppointmentbtn').addEventListener('click', function () {
    resetForm();
    clearRadioButtons(document.querySelectorAll('input[name="list-status"]')); 
  });
});
