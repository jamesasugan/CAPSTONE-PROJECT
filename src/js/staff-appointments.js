document.addEventListener('DOMContentLoaded', function () {
  const rescheduleSection = document.getElementById('reschedule-section');
  const remarksInput = document.getElementById('remarks'); 
  const approveReason = document.querySelectorAll('input[name="approveReason"]');
  const reschedReason = document.querySelectorAll('input[name="reschedReason"]');
  const cancelReason = document.querySelectorAll('input[name="cancelReason"]');
  const otherReasonContainer = document.getElementById('otherReasoncontainer');
  const otherReasonInput = document.getElementById('otherReason');
  const appointmentDate = document.getElementById('appointment-date');
  const appointmentTime = document.getElementById('appointment-time');

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
    approveReason.forEach(input => {
      input.closest('li').style.display = 'none';
      input.required = false; // Remove required attribute
    });
    reschedReason.forEach(input => {
      input.closest('li').style.display = 'none';
      input.required = false; // Remove required attribute
    });
    cancelReason.forEach(input => {
      input.closest('li').style.display = 'none';
      input.required = false; // Remove required attribute
    });
    hideOtherReasonContainer();
  }

  function hideRescheduleSection() {
    rescheduleSection.style.display = 'none';
    appointmentDate.disabled = true;
    appointmentTime.disabled = true;
  }

  function showRescheduleSection() {
    rescheduleSection.style.display = 'flex';
    appointmentDate.disabled = false;
    appointmentTime.disabled = false;
  }

  function hideAllReasonOptionsInitially() {
    hideAllReasonOptions();
    document.querySelector('input[name="list-status"]:checked')?.click(); 
  }

  function handleStatusChange(status) {
    hideAllReasonOptions();
    switch (status) {
      case 'pending':
        hideRescheduleSection();
        break;
      case 'approved':
        approveReason.forEach(input => {
          input.closest('li').style.display = 'block';
          input.required = true; // Add required attribute
        });
        hideRescheduleSection();
        break;
      case 'rescheduled':
        reschedReason.forEach(input => {
          input.closest('li').style.display = 'block';
          input.required = true; // Add required attribute
        });
        showRescheduleSection();
        break;
      case 'cancelled':
        cancelReason.forEach(input => {
          input.closest('li').style.display = 'block';
          input.required = true; // Add required attribute
        });
        hideRescheduleSection();
        break;
    }
  }

  document.querySelectorAll('input[name="list-status"]').forEach(input => {
    input.addEventListener('change', function () {
      if (this.checked) {
        handleStatusChange(this.value);
      }
    });
  });

  document.querySelectorAll('input[name="approveReason"], input[name="reschedReason"], input[name="cancelReason"]').forEach(input => {
    input.addEventListener('change', function () {
      remarksInput.value = this.value; // Update hidden input value
      if (this.id.includes('others')) {
        showOtherReasonContainer();
        remarksInput.value = otherReasonInput.value
      } else {
        hideOtherReasonContainer();
      }
    });
  });
  if(otherReasonInput){
    otherReasonInput.addEventListener('keyup', function(){
      remarksInput.value = this.value
    })
  }

  hideAllReasonOptionsInitially();

  // Reset form when close button is clicked
  document.getElementById('modalAppointmentbtn').addEventListener('click', function () {
    resetForm();
    clearRadioButtons(document.querySelectorAll('input[name="list-status"]')); 
  });
});
