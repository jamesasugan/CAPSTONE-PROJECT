document.addEventListener('DOMContentLoaded', function () {
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('rescheduled-date').setAttribute('min', today);

  const form = document.querySelector('#update_appointment');
  const modalCloseBtn = document.getElementById('modalAppointmentbtn');
  const rescheduleSection = document.getElementById('reschedule-section');
  const remarksInput = document.getElementById('remarks');
  const dateInput = document.getElementById('rescheduled-date');
  const timeInput = document.getElementById('rescheduled-time');
  const servicesContainer = document.getElementById('services-container');

  document.querySelectorAll('input[name="list-status"]').forEach((input) => {
    input.addEventListener('change', function () {
      if (this.value === 'rescheduled') {
        rescheduleSection.style.display = 'flex';
        dateInput.required = true;
        timeInput.required = true;
        remarksInput.value = '';
      } else {
        rescheduleSection.style.display = 'none';
        dateInput.required = false;
        timeInput.required = false;
        if (this.value === 'approved') {
          remarksInput.value =
            'Your appointment is now listed, comply on the set date and time';
        } else if (this.value === 'cancelled') {
          remarksInput.value =
            'Your Appointment has been Cancelled due to unforeseen circumstances. Please rebook again if you want to continue';
        }
      }
    });
  });

  // Handle modal close action
  modalCloseBtn.addEventListener('click', function () {
    form.reset(); // Reset form values to default

    // Reset additional UI states
    rescheduleSection.style.display = 'none';
    dateInput.required = false;
    timeInput.required = false;
    remarksInput.value = '';

    // Reset the radio buttons explicitly as form.reset() does not necessarily clear them
    document.querySelectorAll('input[name="list-status"]').forEach((radio) => {
      radio.checked = false;
    });

    // Reset the service dropdown
    servicesContainer.selectedIndex = 0;

    // Reset any dynamically added services (if applicable)
    // Assuming you might dynamically add service elements, remove them all except the first one (the original dropdown)
    while (servicesContainer.children.length > 1) {
      servicesContainer.removeChild(servicesContainer.lastChild);
    }
  });
});
